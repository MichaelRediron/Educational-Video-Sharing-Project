<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);
$video->user_id = $_SESSION['uid'];
$reqid = $_GET['id'];
$stmt = $video->read_all_video_sort('all');
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style.css">
  <title>Requested Videos</title>
</head>
<body>
  <?php
     if(isset($_SESSION['uid']))
     {
       if($_SESSION['utype']==='Educator')
         include_once 'headers/educatorheader.php';
       else
       {
         header("location: index.php");
         exit();
       }
     }
     else
     {
       header("location: index.php");
       exit();
     }
   ?>
  <main>
  <section class="notify-wrapper">
      <div class="notify-container">
        <div class="notify-box">
          <h1>Notify User</h1>
          <p>Note: Make sure video is uploaded in order to select</p>
          <form action="video/notifyb.php" method="POST">
          <input type="hidden" value="<?php echo $reqid?>" name="request_id">
          <div class="">
              <label for="video_title">Video Title:</label>
              <select name="video_title" class="vinput" id="nottopic">
              <?php if($stmt->rowCount()>0):
                while($vid = $stmt->fetch(PDO::FETCH_ASSOC)):?>
                  <option value="<?php echo $vid['video_id'];?>"><?php echo $vid['video_title'];?></option>
                <?php endwhile; endif;?>
              </select>
            </div>
            <button type="submit" name="notify-submit" class="notify-submit">Send</button>
          </form>
        </div>
      </div>
    </section>
  </main>
</body>
</html>