<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();

$this_userid = $_SESSION['uid']; 

$sql = "SELECT v.video_title, t.score
        FROM testscore as t, video as v 
        WHERE t.user_id = $this_userid AND t.test_id = v.video_id
        ORDER BY t.score DESC";

$scores = $db->prepare($sql);
$scores->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <title> Grades </title>
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

        <section class="scores-wrapper">
            <h1 class="ranking-title">Students Grades</h1>
            <div class="table-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th class="first-header">
                                <div class="main-rank">Video Name</div>

                            </th>
                            <th class="second-header">
                                <div class="main-rank">Grade</div>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <?php if($scores->rowCount()>0):
                        $numrows = $scores->rowCount();
                        $count = 0;
                        while($count<$numrows): $count++;?>
                        <tr>
                            <td class="rank"><?php echo $count;?></td>
                            <?php
                                $row = $scores->fetch(PDO::FETCH_ASSOC);
                                $grade = 100 * $row['score'];
                                $vidtitle = $row['video_title'];
                            ?>
                            <td class="rank-entry"><?php echo $vidtitle;?></td>
                            
                            <td class="rank-entry"><?php echo $grade;?>%</td>
                            
                        </tr>
                        <?php endwhile; endif;?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>
