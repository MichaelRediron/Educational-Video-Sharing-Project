<?php  
include_once '../backend/dbconnect.php';
include_once '../objects/video.php';

if(isset($_GET['id'])) {
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->video_id = $_GET['id'];

  if($vid->delete_video())
  {
    header("location: ../managevid.php");
    exit();
  }
  else
  {
    header("location: ../managevid.php?error");
    exit();
  }
}
?>
