<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);

$stmtrecent = $video->read_ten_videos('video_pdate');
$stmtrating = $video->read_ten_videos('video_rating');
$stmtviews = $video->read_ten_videos('video_views');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <title>Home</title>
</head>

<body>
  <?php
  if (isset($_SESSION['uid'])) {
    if ($_SESSION['utype'] === 'Student')
      include_once 'headers/studentheader.php';
    elseif ($_SESSION['utype'] === 'Educator')
      include_once 'headers/educatorheader.php';
    else {
      header("location: index.php?error");
      exit();
    }
  } else {
    header("location: index.php?error");
    exit();
  }

  ?>
  <main>
    <div class="home-wrapper">
      <section class="top-section">
        <div class="top-container">
          <h1>Welcome to IQTransfer</h1>
          <p>IQ Transfers give our users a simple way for knowledge to be shared and learned all in one place. Educators provide IQ Transfer with the educational videos that students are able to watch and learn from. After each video that a student watches they get a short five question quiz to check the knowledge that they gained from the video. Within IQ transfer there are rankings on videos, educators and students. The top one hundred rankings are public for the users to see which videos, educators and students are excelling in our program. IQ Transfer is for anyone who wants to learn or share their knowledge with others.
          </p>
        </div>
      </section>
      <section class="video-section">
        <div class="recent-vid">
          <h4 class="section-title">Recently Posted Videos</h4>
          <div class="home-videos">
            <?php if ($stmtrecent->rowCount() > 0) :
              while ($vid = $stmtrecent->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="video-container">
                  <div class="video-box" style="background-image: url(<?php echo $vid["video_thumb"]; ?>)">
                    <a class="vid-data" href="watch.php?id=<?php echo $vid['video_id']; ?>"><i class="fas fa-play-circle"></i></a>
                  </div>
                  <div class="home-vid-title">
                    <h1><?php echo $vid['video_title']; ?></h1>
                  </div>
                </div>
            <?php endwhile;
            endif; ?>
          </div>
        </div>
        <div class="top-vid">
          <h4 class="section-title">Top Rated Videos</h4>
          <div class="home-videos">
            <?php if ($stmtrating->rowCount() > 0) :
              while ($vid = $stmtrating->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="video-container">
                  <div class="video-box" style="background-image: url(<?php echo $vid["video_thumb"]; ?>)">
                    <a class="vid-data" href="watch.php?id=<?php echo $vid['video_id']; ?>"><i class="fas fa-play-circle"></i></a>
                  </div>
                  <div class="home-vid-title">
                    <h1><?php echo $vid['video_title']; ?></h1>
                  </div>
                </div>
            <?php endwhile;
            endif; ?>
          </div>
        </div>
        <div class="viewed-vid">
          <h4 class="section-title">Most Viewed Videos</h4>
          <div class="home-videos">
            <?php if ($stmtviews->rowCount() > 0) :
              while ($vid = $stmtviews->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="video-container">
                  <div class="video-box" style="background-image: url(<?php echo $vid["video_thumb"]; ?>)">
                    <a class="vid-data" href="watch.php?id=<?php echo $vid['video_id']; ?>"><i class="fas fa-play-circle"></i></a>
                  </div>
                  <div class="home-vid-title">
                    <h1><?php echo $vid['video_title']; ?></h1>
                  </div>
                </div>
            <?php endwhile;
            endif; ?>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>

</html>