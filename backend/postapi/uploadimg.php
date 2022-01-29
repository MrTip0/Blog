<?php
require './lib/db.php';
require './lib/auth.php';

$db = getDB();
if(isset($_COOKIE["jwt"])) {
   $user = decode($_COOKIE["jwt"])["username"];
   $isadmin = $db -> query("SELECT admin FROM users WHERE username = $user;") -> fetch_array()["admin"];
   if($isadmin == 1) {
      $target_dir = "../uploaded_images/";
      $uploadErr = null;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
         $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
         if($check === false) {
            $uploadErr = "file is not an image";
         }
      }

      // Check if file already exists
      if (file_exists($target_file)) {
         $uploadErr = "Sorry, file already exists.";
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadErr != null) {
         echo json_encode(array(
            "result" => "failure",
            "reason" => $uploadErr
         ));
      // if everything is ok, try to upload file
      } else {
         $target_file = sha1_file($_FILES["fileToUpload"]["tmp_name"]) . '.' . $imageFileType;
         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
            echo json_encode(array(
               "result" => "success",
               "filename" => "/uploaded_images/" . $target_file
            ));
         } else {
            echo json_encode(array(
               "result" => "failure",
               "reason" => "unknown"
            ));
         }
      }
   } else {
      echo json_encode(array(
         "result" => "failure",
         "reason" => "You are not allowed to post pictures"
      ));
   }
} else {
   echo json_encode(array(
      "result" => "failure",
      "reason" => "Login to post pictures"
   ));
}
?>