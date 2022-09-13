<?php
//here we show the all 3 values
if (isset($_GET['webval'],$_GET['webemot'],$_GET['imgval'],$_GET['aud_val'],$_GET['aud_emot']))
  {
     $webval = $_GET['webval'];
     $webemot = $_GET['webemot'];
     $imgval = $_GET['imgval'];
     $aud_val = $_GET['aud_val'];
     $aud_emot = $_GET['aud_emot'];
     //$data = "CONCLUSIVE DATA";
     $op = (($webval)*(1) + ($imgval)*(2) + ($aud_val)*(3))/6;
     //final value
     $op = round($op,2);
     if(($webemot == 'neutral' && $aud_emot == 'neutral') || ($webemot == 'happy' && $aud_emot == 'happy') || ($webemot == 'sad' && $aud_emot == 'sad'))
     {
          $os = $op;
     }else if($webemot == 'surprised' && $aud_emot == 'surprised' || $webemot == 'surprised' && $aud_emot == 'excited')
     {
         $os = $op;
     }else if($webemot == 'disgusted' && $aud_emot == 'frustration' || $webemot == 'frustration' && $aud_emot == 'fearful')
     {
         $os = $op;
     }else if($webemot == 'angry' && $aud_emot == 'anger')
     {
         $os = $op;
     }
     else
     {
          $data = "INCONCLUSIVE DATA";
     }
     
  }
?>
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
        </style>
</head>
<body style="background-color: #32293a;">
 <h3 class="content">Your Device camera emotion score is <b style="text-decoration: underline; "><?php echo $webval; ?></b></h3>
  <h3 class="content">Your face emotion score is <b style="text-decoration: underline; "><?php echo $imgval; ?></b></h3>
  <h3 class="content">Your Audio Score is <b style="text-decoration: underline; "><?php echo $aud_val; ?></b></h3>
  <?php if($os){?>
  <h3 class="content">CONCLUSION:- Emotion is <b style="text-decoration: underline; "><?php echo $webemot; ?></b> AND Optimised Score is <b style="text-decoration: underline; "><?php echo $os; ?></b>
   </h3>
  <?php } else { ?>
  <h3 class="content">It is <b style="text-decoration: underline; "><?php echo $data; ?></b></h3>
  <?php } ?>
</body>
</html>