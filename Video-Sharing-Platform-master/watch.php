
<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

if(isset($_GET['id'])) {
    $database = new DBconnect();
    $db = $database->connect();
    $video = new Video($db);
    $video->video_id = $_GET['id'];
    $row = $video->read_single_video();
}
else
{
    header("location: search.php?error");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <script src="javascript/watch.js"></script>
    <title>Watch</title>
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

        <div class="video_container">
            <video id="video_player" class="video-js" controls preload="auto" width="896" height="504" data-setup="{}">
                <source src="<?php echo $row["video_path"];?>" type="video/mp4" />
            </video>
        </div>
        <div class="title_container">
            <div>
                <h5 id="watchTitle" class=videoTitle><?php echo $row["video_title"];?></h5>
                <p class="vidDescription">by <?php echo $row["video_user"];?></p>
            </div>

            <div id="video_stars" class="Stars2" style="--rating: <?php echo $row["video_rating"] * 5;?>" aria-label="Rating of this product is 4.3 out of 5."></div>
            <div class="videoViews"><?php echo $row["video_views"];?> Views </div>
        </div>
        <div class="button_container">
            <button class="quiz-button"><a href="quiz.php?id=<?php echo $row["video_id"];?>">Take The Quiz</a></button>
        </div>
    </main>
    
   


</body>

</html>