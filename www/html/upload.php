<?php
$filename = "resume.pdf";
$filetmp = $_FILES[resumefile][tmp_name];
$filesize = $_FILES[resumefile][size];

$targetDirectory = "";
$base = explode('.', $filename);
$base = $base[0];
$targetFile = $targetDirectory . $filename;
$error = false;

if(isset($_POST["submit"])) {
  print_r($_FILES[resumefile]);
  echo "$filetmp<br>$targetFile";
  if (move_uploaded_file($filetmp, $targetFile)) {
      echo "The file has been uploaded.";
  } else {
    echo "Sorry, the file may not be uploaded";
  }
}
?>
