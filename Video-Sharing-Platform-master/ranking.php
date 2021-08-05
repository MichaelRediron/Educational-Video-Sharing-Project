<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);
$vstmt = $video->read_all_video('video_rating');

$sql = "UPDATE users u
        INNER JOIN (SELECT user_id, avg(video_rating) as avgrate
                    FROM video GROUP BY user_id)
                    v ON u.user_id = v.user_id
                    SET u.user_ranking = v.avgrate";
$stmt = $db->prepare($sql);
$stmt->execute();


$sqle = "SELECT * FROM users WHERE user_type = 'Educator' ORDER BY user_ranking DESC";
$estmt = $db->prepare($sqle);
$estmt->execute();

$sql = "UPDATE users u
        INNER JOIN (SELECT user_id, avg(score) as tscore
                    FROM testscore GROUP BY user_id)
                    t ON u.user_id = t.user_id
                    SET u.user_ranking = t.tscore";
$stmt = $db->prepare($sql);
$stmt->execute();

$sqls = "SELECT * FROM users WHERE user_type = 'Student' ORDER BY user_ranking DESC";
$ststmt = $db->prepare($sqls);
$ststmt->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <title> Rankings </title>
</head>

<body>
    <?php
    if (isset($_SESSION['uid'])) {
        if ($_SESSION['utype'] === 'Student')
            include_once 'headers/studentheader.php';
        else if ($_SESSION['utype'] === 'Educator')
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

        <section class="ranking-wrapper">
            <!--for demo wrap-->
            <h1 class="ranking-title">Rankings</h1>
            <div class="table-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th class="first-header">
                                <div class="main-rank">Video Ranking</div>
                                <div class="inner-desc">Name - Rating</div>
                            </th>
                            <th class="second-header">
                                <div class="main-rank">Educator Ranking</div>
                                <div class="inner-desc">Name - Rating</div>
                            </th>
                            <th class="third-header">
                                <div class="main-rank">Student Ranking</div>
                                <div class="inner-desc">Name - Average</div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php if($vstmt->rowCount()>0 || $estmt->rowCount()>0 || $ststmt->rowCount()>0 ):
                        $maxe = max($vstmt->rowCount(),$estmt->rowCount(),$ststmt->rowCount());
                        $count = 0;
                        while($count<$maxe): $count++;?>
                        <tr>
                            <td class="rank"><?php echo $count;?></td>
                            <?php
                                if($vid = $vstmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $num = 5 * $vid['video_rating'];
                                    $vidp = $vid['video_title']." - ".$num."/5";
                                }
                                else
                                    $vidp = "";
                            ?>
                            <td class="rank-entry"><?php echo $vidp;?></td>
                            <?php
                                if($edu = $estmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $num = 5 * $edu['user_ranking'];
                                    $edup = $edu['user_name']." - ".$num."/5";
                                }
                                else
                                    $edup = "";
                            ?>
                            <td class="rank-entry"><?php echo $edup;?></td>
                            <?php
                                if($stu = $ststmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $num = 100 * $stu['user_ranking'];
                                    $stup = $stu['user_name']." - ".$num."%";
                                }
                                else
                                    $stup = "";
                            ?>
                            <td class="rank-entry"><?php echo $stup;?></td>
                        </tr>
                        <?php endwhile; endif;?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>
