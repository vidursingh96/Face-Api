<?php
if (isset($_REQUEST['action']))
{
    $arr = [];
    $arr['expvalue'] = $_POST['expvalue'];
    $arr['expname'] = $_POST['expname'];
    $arr['imgcap'] = $_POST['imgcap'];
    $arr['filepath'] = $_SERVER['HTTP_HOST'] . '/prakher/' . basename(__DIR__);
    define('UPLOAD_DIR', 'uploads/');
    $image_parts = explode(";base64,", $arr['imgcap']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    //upload files and save to upload directory
    $file = UPLOAD_DIR . uniqid() . '.png';
    $files = $arr['filepath'] .= "/$file";
    file_put_contents($file, $image_base64);
    //Azure API START
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://centralindia.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false&returnFaceAttributes=emotion&detectionModel=detection_01&faceIdTimeToLive=86400",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r \"url\": \"https://$files;\"\r }",
    CURLOPT_HTTPHEADER => [
      "content-type: application/json",
      "Ocp-Apim-Subscription-Key:10c906319365491091d7f2cb29c9b7d5",
    ],
  ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $output = json_decode($response, true);
    $emotion = ($output[0]["faceAttributes"]['emotion']);
    arsort($emotion); 
    $result = array_slice($emotion,0,1);
    foreach($result as $resltKey => $resltVal){
        //echo $resltKey .' => '. $resltVal;
    }
    //output
    $arr['img_expvalue'] = $resltVal;
    $arr['img_expname'] = $resltKey;
    unset($arr['imgcap']);
    echo json_encode($arr);
    exit();
   } 
else
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Face recognition App</title>
    <style type="text/css">
      body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  height: 100vh;
  background: #2f2f2f;
  width: calc(100% - 33px);
}

canvas {
  position: absolute;
}
.container {
  display: flex;
  width: 100%;
  justify-content: center;
  align-items: center;
}
.result-container {
  display: flex;
  width: 100%;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 30px;
}
.result-container > div {
  font-size: 1.3rem;
  padding: 0.5rem;
  margin: 5px 0;
  color: white;
  text-transform: capitalize;
}
#age {
  background: #1e94be;
}
#emotion {
  background: #8a1025;
}
#gender {
  background: #62d8a5;
}
video {
  width: 100%;
}
header {
  background: #42a5f5;
  color: white;
  width: 100%;
  font-size: 2rem;
  padding: 1rem;
  font-size: 2rem;
}
.btn{
  padding: 5px 20px 5px;
  cursor: pointer;
}
    </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body id="body">
    <header style="text-align:center;">Device Camera</header>
    <div class="container">
      <div id="webcam" style="margin-top:50px; border:3px solid white;"></div>
      <div><img id="imgCapture" src="" height="375px" width="500px" style="display: none;" /></div>
    </div>
    <div class="result-container">
        <form>
          <input type="hidden" name="faceExpValue" id="ExpValue">
          <input type="hidden" name="faceExpName" id="ExpName">
          <input type="hidden" name="imagesave" id="imagesave">
          <input type="submit" value="submit" name="submit" id="submit" class="btn"> 
        </form>
    </div>
    <script src="./js/prakher-face.js"></script>
    <script src="./js/webcam.js"></script>
<script type = "text/javascript" >
    var data_url;
$(document).ready(function() {
    Webcam.set({
        width: 500,
        height: 375,
        image_format: 'png',
        //jpeg_quality: 90
    });
    Webcam.attach('#webcam');
    $("#submit").click(function(event) {
        event.preventDefault();
        Webcam.snap(function(data_uri) {
            $("#imgCapture")[0].src = data_uri;
            data_url = data_uri;
            $.ajax({
                type: "POST",
                url: "index.php",
                data: {
                    'action': 'submit',
                    'expvalue': $('#ExpValue').val(),
                    'expname': $('#ExpName').val(),
                    'imgcap': data_url
                },
                success: function(data){
                   var res = JSON.parse(data);    
                   window.location.href = 'https://grade.techmente.com/prakher/webcam/audio_emotion.php?expvalue='+res.expvalue+'&expname='+res.expname+'&img_value='+res.img_expvalue;
                   //console.log(data) 
                } 
            });
        });
        return false;
    });
});
 </script>
 </body>
</html>
<?php
} ?>
