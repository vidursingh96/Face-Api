<?php
ini_set('xdebug.max_nesting_level', 200);
ob_start();
if (isset($_GET['expvalue'], $_GET['img_value'] , $_GET['expname']))
{
    $expvalue = $_GET['expvalue'];
    $img_value = $_GET['img_value'];
    $expname = $_GET['expname'];
}

if (isset($_POST['submit']))
{
    $path = "audio_upl/"; //file to place within the server
    $valid_formats1 = array(
        "mp3",
        "wav",
        "flac"
    ); //list of file extention to be accepted
    if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
    {
        $file1 = $_FILES['file1']['name']; //input file name in this code is file1
        $size = $_FILES['file1']['size'];

        if (strlen($file1))
        {
            list($txt, $ext) = explode(".", $file1);
            if (in_array($ext, $valid_formats1))
            {
                $actual_audio_name = $txt . "." . $ext;
                $tmp = $_FILES['file1']['tmp_name'];
                if (move_uploaded_file($tmp, $path.$actual_audio_name))
                {
                   include 'curl.php';
                }
                else echo "failed";
            }
        }
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
    <title>upload audio</title>
    <style type="text/css">
        #parent {
   display: table;
   width: 100%;
}
#form_login {
   display: table-cell;
   text-align: center;
   vertical-align: middle;
}
.center{margin-top: 260px;}    
    </style>
</head>
<body style="background-color: #636363;">
    <div class="center">
    <h2 style="color: white; text-align: center;">Please Upload Audio File</h2>
    <div id="parent">
    <form id="form_login" enctype="multipart/form-data" method="POST" action="" class="form-inline">
        <input type="hidden" name="value" value="<?php echo $expvalue; ?>">
        <input type="hidden" name="value" value="<?php echo $img_value; ?>">
        <input type="file" name="file1" class="form-control" required="required"/>
        <button type="submit" id="submit" name="submit" class="btn btn-danger">Submit</button>
    </form>
    </div>
    <h4 style="color: white; text-align: center;">* Supported Formats - WAV,MP3</h4>
    <h4 style="color: white; text-align: center;">* Duration upto 5 seconds</h4>
   </div> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
