<?php
session_start();

if(isset($_POST['notify-submit']))
{
  include_once '../backend/dbconnect.php';
  include_once '../objects/video.php';
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->user_id = $_SESSION['uid'];
  $vid->video_id = $_POST['video_title'];
  $vid->request_id = $_POST['request_id'];

  if($vid->send_notify())
  {
    header("location: ../request.php?submitsuccess");
    exit();
  }
  else
  {
    header("location: ../request.php?error");
    exit();
  }
}
else
{
  header("location: ../request.php?error");
  exit();
}