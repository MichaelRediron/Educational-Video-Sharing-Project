<?php
session_start();

if(isset($_POST['request-submit']))
{
  include_once '../backend/dbconnect.php';
  include_once '../objects/video.php';
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->user_id = $_SESSION['uid'];
  $vid->request_topic = $_POST['request_topic'];
  $vid->request_desc = $_POST['request_desc'];

  if($vid->sendrequest())
  {
    header("location: ../requestvid.php?submitsuccess");
    exit();
  }
  else
  {
    header("location: ../requestvid.php?error");
    exit();
  }
}
else
{
  header("location: ../requestvid.php?error");
  exit();
}