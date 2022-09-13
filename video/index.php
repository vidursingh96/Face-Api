<?php
error_reporting(0);
session_start();

if(isset($_POST['submit'])){
   $maxsize = 5242880; // 5MB
   if(isset($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name'] != ''){
       $name = $_FILES['fileToUpload']['name'];
       $target_dir = "uploads/";
       $target_file = $target_dir . $_FILES["fileToUpload"]["name"];

       // Select file type
       $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

       // Valid file extensions
       $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

       // Check extension
       if( in_array($extension,$extensions_arr) ){
 
          // Check file size
          if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
             $_SESSION['message'] = "File too large. File must be less than 5MB.";
          }else{
             // Upload
             if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file)){
               echo "done";
             }
          }

       }else{
          $_SESSION['message'] = "Invalid file extension.";
       }
   }else{
       $_SESSION['message'] = "Please select a file.";
   }
   header('location: index.php');
} 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Image Emotion</title>
  <style type="text/css">
    body{
background-color: #454545;
}
.contain{
  margin-left:auto;
  margin-right:auto;  
}
#form1{
  width:auto;
}
.alert{
  text-align:center;
}

#blah{  
  max-height:300px;
  height:auto;
  width:auto;
  display:block;
  margin-left: auto;
   margin-right: auto;
  padding:20px;
}
#img_contain{
  border-radius:5px;
  /*  border:1px solid grey;*/
  margin-top:20px;
  width:auto;  
}
.input-group{  
  margin-left:calc(calc(100vw - 320px)/2);
  margin-top:40px;
  width:320px;
}
.imgInp{  
  margin-top:10px;
  padding:10px;
  background-color:#d3d3d3;  
}
.loading{
   animation:blinkingText ease 2.5s infinite;
}
@keyframes blinkingText{
    0%{     color: #000;    }     
    50%{   color: #transparent; }
    99%{    color:transparent;  }
    100%{ color:#000; }
}
.custom-file-label{
  cursor:pointer;
}

.credit{    
  font: 14px "Century Gothic", Futura, sans-serif;
  font-size:12px;  
  color:#3d3d3d;
  text-align:left;
  margin-top:10px;
  margin-left:auto;
  margin-right:auto;
  text-align:center;
}
.credit a{
  color:gray;
}
.credit a:hover{
  color:black;  
}
.credit a:visited{
  color:MediumPurple;
}

canvas{
  margin-left: 396px;
    margin-top: 30px;
    height: 325px;
}

  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
  <div class="contain animated bounce"> 
<form id="form1" runat="server" action="" method="post" enctype="multipart/form-data">
    <div class="alert"></div> 
    <div class="input-group"> 
    <div class="custom-file">
    <h2 style="color:white;">Please Select video</h2>    
    <input type="file" name="fileToUpload" id="inputGroupFile01" class="imgInp custom-file-input" aria-describedby="inputGroupFileAddon01">
    <input type="hidden" name="faceExpName" id="faceExpName">
    <input type="hidden" name="faceExpValue" id="faceExpValue">
    <input type="submit"  name="submit" id="submit" style="margin:15px;">
    <a href="image.php?faceExpValue=<?php echo $faceExpValue; ?>&faceExpName=<?php echo $faceExpName; ?>" id="nextBtn" style="color:white;">GO TO NEXT STEP</a>
  </div>
</div>
<video id="blah" src="<?php echo $target_file; ?>" />
</form>
</div>
 <script src="./js/prakher-image.js"></script>
    <script src="./js/app.js"></script>
<script type="text/javascript">
  $("#inputGroupFile01").change(function(event) {  
  RecurFadeIn();
  readURL(this);    
});
$("#inputGroupFile01").on('click',function(event){
  RecurFadeIn();
});
function readURL(input) {    
  if (input.files && input.files[0]) {   
    var reader = new FileReader();
    var filename = $("#inputGroupFile01").val();
    filename = filename.substring(filename.lastIndexOf('\\')+1);
    reader.onload = function(e) {  
      $('#blah').attr('src', e.target.result);
      $('#blah').hide();
      $('#blah').fadeIn(500);      
      $('.custom-file-label').text(filename);             
    }
    reader.readAsDataURL(input.files[0]);    
  } 
  $(".alert").removeClass("loading").hide();
}
function RecurFadeIn(){ 
  //console.log('ran');
  FadeInAlert("Wait for it...");  
}
function FadeInAlert(text){
  $(".alert").show();
  $(".alert").text(text).addClass("loading");  
}
</script>
</body>
</html>