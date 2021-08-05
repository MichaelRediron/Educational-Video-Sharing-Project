<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);
$default = 'none';
$selection = !empty($_GET['SearchPhrase']) ? $_GET['SearchPhrase'] : $default;
$stmt = $video->search_video($selection);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="javascript/search.js"></script>
    <title>Search</title>
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
        <div class="search-bar">
            <input type="search" placeholder="Find Videos" class="search-box" id=videoSearch pattern=".*\S.*" required />
            <span id="searchBtn" class="search-button">
                <span class="search-icon"></span>
            </span>
        </div>

        <div class="results-container">
            <div id="vidResultsTitle">
            </div>

            <div class="vidListMembers">

                <ul class="videolist" id="videoResults">
                    <?php if ($stmt != false) : if ($stmt->rowCount() > 0) :
                            while ($vid = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <li>

                                    <div class="search-title-wrapper"><a href="watch.php?id=<?php echo $vid['video_id']; ?>" class=videoTitle><?php echo $vid['video_title']; ?></a></div>
                                    <p class="vidDescription">Topic: <?php echo $vid['video_topic']?></p>
                                    <div class="Stars" style="--rating: <?php echo $vid['video_rating'] * 5; ?>;" aria-label="Rating of this product is 2.3 out of 5.">
                                        <img src="<?php echo $vid["video_thumb"]; ?>">
                                </li>
                            <?php endwhile;

                        else : ?>
                            <h5 id="vidResultsTitle">No Results For
                                "<?php echo $_GET['SearchPhrase'] ?>"</h5>
                    <?php
                        endif;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </main>

</body>

</html>