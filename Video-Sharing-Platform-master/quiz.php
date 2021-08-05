<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

if(isset($_GET['id'])) {
    $database = new DBconnect();
    $db = $database->connect();
    $video = new Video($db);
    $video->video_id = $_GET['id'];
    $video->user_id = $_SESSION['uid'];
    $row = $video->read_single_test();
    $video->test_id = $row['test_id'];
    if($video->check_wrote_quiz())
    {
        header("location: home.php?error");
        exit(); 
    }
}
else
{
    header("location: home.php?error");
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
    <!--<script src="javascript/quiz.js"></script> -->
    <title>Quiz</title>
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

        <div class="quiz-container">
            <div class="quiz-heading-text">
                <h1 class="heading--text">Quiz</h1>
            </div>

            <!-- Quiz section -->
            <div class="quiz-body">
                <div class="quiz-score">
                    <h2 class="quiz-score-title">
                        Your are <span class="result"></span> right.
                    </h2>
                </div>

                <form class="quiz-form" action="video/quizb.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $row['video_id']?>" name="video_id">
                    <input type="hidden" value="<?php echo $row['test_id']?>" name="test_id">
                    <div class="quiz-question-container">
                        <p class="quiz-question">
                            1. <?php echo $row["q_one"];?>
                        </p>
                        <label class="quiz-answer" for="q11">
                            <input class="selector" type="radio" name="q1" id="q11" value="True" />

                            <span class="text">True</span>
                        </label>
                        <label class="quiz-answer" for="q12">
                            <input class="selector" type="radio" name="q1" id="q12" value="False" />

                            <span class="text">False</span>
                        </label>

                    </div>

                    <div class="quiz-question-container">
                        <p class="quiz-question">
                            2. <?php echo $row["q_two"];?>
                        </p>
                        <label class="quiz-answer" for="q21">
                            <input class="selector" type="radio" name="q2" id="q21" value="True" />

                            <span class="text">True</span>
                        </label>
                        <label class="quiz-answer" for="q22">
                            <input class="selector" type="radio" name="q2" id="q22" value="False" />

                            <span class="text">False</span>
                        </label>

                    </div>

                    <div class="quiz-question-container">
                        <p class="quiz-question">
                            3. <?php echo $row["q_three"];?>
                        </p>
                        <label class="quiz-answer" for="q31">
                            <input class="selector" type="radio" name="q3" id="q31" value="True" />

                            <span class="text">True</span>
                        </label>
                        <label class="quiz-answer" for="q32">
                            <input class="selector" type="radio" name="q3" id="q32" value="False" />

                            <span class="text">False</span>
                        </label>

                    </div>

                    <div class="quiz-question-container">
                        <p class="quiz-question">
                            4. <?php echo $row["q_four"];?>
                        </p>
                        <label class="quiz-answer" for="q41">
                            <input class="selector" type="radio" name="q4" id="q41" value="True" />

                            <span class="text">True</span>
                        </label>
                        <label class="quiz-answer" for="q42">
                            <input class="selector" type="radio" name="q4" id="q42" value="False" />

                            <span class="text">False</span>
                        </label>

                    </div>

                    <div class="quiz-question-container">
                        <p class="quiz-question">
                            5. <?php echo $row["q_five"];?>
                        </p>
                        <label class="quiz-answer" for="q51">
                            <input class="selector" type="radio" name="q5" id="q51" value="True" />

                            <span class="text">True</span>
                        </label>
                        <label class="quiz-answer" for="q52">
                            <input class="selector" type="radio" name="q5" id="q52" value="False" />

                            <span class="text">False</span>
                        </label>
                    </div>


                    <span class="rate-text">Rate the Video!</span>
                    <div class="rate-container">
                        <div class="rate">
                            <input type="radio" id="star1" name="rate" value="5" />
                            <label for="star1" title="text">1 stars</label>
                            <input type="radio" id="star2" name="rate" value="4" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star4" name="rate" value="2" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star5" name="rate" value="1" />
                            <label for="star5" title="text">5 star</label>
                        </div>
                    </div>
                    <input class="submit" type="submit" value="submit" name="quiz-submit"/>
                </form>
            </div>
        </div>

    </main>

</body>

</html>