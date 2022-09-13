<?php
//here we generate log file
$fileName = time().".log";
//file_put_contents( $fileName, "lorem ipsum"  );
if(isset($_GET['fileName'])){
    $fileName = $_GET['fileName'];
}
  $files = glob("*.log");
  $now   = time();

  foreach ($files as $file) {
    if (is_file($file)) {
      if ($now - filemtime($file) >= 60) {
        unlink($file);
      }
    }
  }
header('Content-Type: application/json');
$request = file_get_contents('php://input');
$req_dump = print_r( $request, true );
$fp = file_put_contents( $fileName, $req_dump );
?>