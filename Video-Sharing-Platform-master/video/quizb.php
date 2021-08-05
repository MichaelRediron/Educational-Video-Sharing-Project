<?php
session_start();

if(isset($_POST['quiz-submit']))
{
  include_once '../backend/dbconnect.php';
  include_once '../objects/video.php';
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->user_id = $_SESSION['uid'];
  $vid->video_id = $_POST['video_id'];
  $vid->test_id = $_POST['test_id'];
  $vid->a_one = $_POST['q1'];
  $vid->a_two = $_POST['q2'];
  $vid->a_three = $_POST['q3'];
  $vid->a_four = $_POST['q4'];
  $vid->a_five = $_POST['q5'];
  $vid->video_rating = $_POST['rate'];

  if(empty($vid->video_rating))
  {
    header("location: ../quiz.php?id=$vid->video_id");
    exit();
  }
  if($vid->uploadquiz())
  {
    header("location: ../home.php?submitsuccess");
    exit();
  }
  else
  {
    header("location: ../quiz.php?id=$vid->video_id");
    exit();
  }
}
else
{
  header("location: ../home.php?error");
  exit();
}