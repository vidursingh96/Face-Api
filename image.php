<?php
session_start();
$image = $_SESSION['fileToUpload'];
$faceExpValue = $_GET['faceExpValue'];
$faceExpName = $_GET['faceExpName'];
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_URL => "https://centralindia.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=emotion&detectionModel=detection_01&faceIdTimeToLive=86400",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "{\r \"url\": \"http://grade.techmente.com/prakher/$image;\"\r }",
	CURLOPT_HTTPHEADER => [
		"content-type: application/json",
		"Ocp-Apim-Subscription-Key:10c906319365491091d7f2cb29c9b7d5",
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$output = json_decode($response, true);

for($i=0; $i<count($output); $i++){
    
    $emotion = ($output[$i]["faceAttributes"]['emotion']);
    
    arsort($emotion);
    
    $result = array_slice($emotion,0,1);
    
    foreach($result as $resltKey => $resltVal){
        //echo $resltKey .' => '. $resltVal;
    }
     $op = (($faceExpValue)*(1) + ($resltVal)*(2))/3;
     $op = round($op,2);
    if($i == 0){ ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <title>Show Data</title>
                <style>
        
                html, body {
                    height: 100%;
                    margin: 0;
                    padding: 0;
                    width: 100%;
                }
        
                body {
                    display: table;
                }
        
                .content {
                    text-align: center;
                    margin-top: 60px;
                    vertical-align: middle;
                    color: white;	
                }
                .center{
                  display: block;
                  margin-left: auto;
                  margin-right: auto;
                }
                </style>
        </head>
        <body style="background-color: #32293a;">
        <img src="http://grade.techmente.com/prakher/<?php echo $image; ?>" height="250px" width="300px;" class="center">
        <?php
    }
    ?>
    <h3 class="content">Your image emotion scores are <b style="text-decoration: underline; "> <?php echo $faceExpValue;?></b>(<?php echo $faceExpName; ?>)
    </h3><h3 class="content">AND</h3> 
     <h3 class="content"><b style="text-decoration: underline; "><?php echo $resltVal; ?></b>(<?php echo $resltKey; ?>)</h3>
     <h3 class="content"><b style="text-decoration: underline; "><?php echo $op; ?></b></h3>
     <?php
    if($i == 0){ ?>
        </body></html>
    <?php
    }
}

?>
