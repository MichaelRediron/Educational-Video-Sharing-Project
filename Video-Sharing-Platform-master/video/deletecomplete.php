<?php  
include_once '../backend/dbconnect.php';
include_once '../objects/video.php';

if(isset($_GET['id'])) {
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->complete_id = $_GET['id'];

  if($vid->delete_complete())
  {
    header("location: ../requestvid.php");
    exit();
  }
  else
  {
    header("location: ../requestvid.php?error");
    exit();
  }
}