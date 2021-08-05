<?php
session_start();

if(isset($_POST["upload-submit"]))
{
  include_once '../backend/dbconnect.php';
  include_once '../objects/video.php';
  $database = new DBconnect();
  $db = $database->connect();
  $vid = new Video($db);

  $vid->video_topic = $_POST['video_topic'];
  $vid->video_title = $_POST['video_title'];
  $vid->user_id = $_SESSION['uid'];
  $sql = "SELECT user_name FROM users WHERE user_id = $vid->user_id";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $vid->video_user = $row['user_name'];
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

  if($vid->upload('video_thumb','video_file'))
  {
    header("location: ../managevid.php?uploadsuccess");
    exit();
  }
  else
  {
    header("location: ../uploadvid.php?error");
    exit();
  }
}
else
{
  header("location: ../uploadvid.php?error");
  exit();
}
?>
