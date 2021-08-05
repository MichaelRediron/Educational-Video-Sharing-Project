<?php
session_start();

if(isset($_POST['edit-submit']))
{
  include_once '../backend/dbconnect.php';
  include_once '../objects/video.php';
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->video_id = $_POST['video_id'];
  $vid->video_topic = $_POST['video_topic'];
  $vid->video_title = $_POST['video_title'];
  $vid->q_one = $_POST['q_one'];
  $vid->q_two = $_POST['q_two'];
  $vid->q_three = $_POST['q_three'];
  $vid->q_four = $_POST['q_four'];
  $vid->q_five = $_POST['q_five'];
  $vid->a_one = $_POST['a_one'];
  $vid->a_two = $_POST['a_two'];
  $vid->a_three = $_POST['a_three'];
  $vid->a_four = $_POST['a_four'];
  $vid->a_five = $_POST['a_five'];

  if($vid->update_video())
  {
    header("location: ../managevid.php?success");
    exit();
  }
  else
  {
    header("location: ../managevid.php?error");
    exit();
  }
}
else
{
  header("location: ../managevid.php?error");
  exit();
}
?>