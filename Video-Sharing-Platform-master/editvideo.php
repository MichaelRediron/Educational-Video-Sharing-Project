<?php
  session_start();
  include_once 'backend/dbconnect.php';
  include_once 'objects/video.php';

  if(isset($_GET['id'])) {
    $database = new DBconnect();
    $db = $database->connect();
    $vid = new Video($db);
    $vid->video_id = $_GET['id'];
    $rowv = $vid->read_single_video();
    $rowt = $vid->read_single_test();
  }
  else
  {
    header("location: managecontent.php?error");
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
  <title>Upload Video</title>
</head>
<body>
  <?php
     if(isset($_SESSION['uid']))
     {
       if($_SESSION['utype']==='Educator')
         include_once 'headers/educatorheader.php';
       else
       {
         header("location: index.php?error");
         exit();
       }
     }
     else
     {
       header("location: index.php?error");
       exit();
     }
   ?>
  <main>
    <section class="upload-wrapper">
      <div class="upload-container">
        <div class="upload-box">
          <h1>Edit Video</h1>
          <form action="video/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="<?php echo $rowv['video_id']?>" name="video_id">
            <div class="">
              <label for="video_topic">Video Topic:</label>
              <select name="video_topic" class="vinput" id="vidtopic">
                <option value="">Select Video Topic</option>
                <?php
                  $topicstr = "Academic Writing, Accounting, Actuarial Science, Aerospace Engineering, African Studies, 
                  American Sign Language, Anthropology, Arabic Language and Muslim Cultures, Archaeology, Architectural Studies, 
                  Architecture, Architecture, Planning and Landscape, Art, Art History, Astronomy, Astrophysics, Biochemistry, 
                  Biology, Biomedical Engineering, Biostatistics, Botany, Business and Environment, Business Technology Management,
                   Canadian Studies, Microbial Biology, Central and East European Studies, Chemical Engineering, Chemistry, 
                   Chinese, Civil Engineering, Communication and Culture, Communication and Media Studies, 
                   Community Health Sciences, Community Rehabilitation, Computational Media Design, Computer Engineering, 
                   Computer Science, Co-operative Education, Dance, Dance Education, Data Science, Development Studies, Drama, 
                   Earth Sciences, East Asian Languages, East Asian Studies, Ecology, Economics, Education, Electrical Engineering, 
                   Energy and Environment Engineering, Energy and Environmental Systems, Energy Engineering, Energy Management, 
                   Engineering, English, Entrepreneurship and Innovation, Environmental Design, Environmental Engineering, 
                   Environmental Science, Film, Finance, Fine Arts, French, Geography, Geology, Geomatics Engineering, Geophysics, 
                   German, Greek, Greek and Roman Studies, Health and Society, History, Indigenous Languages, Indigenous Studies, 
                   Information Security and Privacy, Innovation, International Relations, Interprofessional Health Education, 
                   talian, Japanese, Kinesiology, Landscape Architecture, Language, Languages, Literatures and Cultures, Latin, 
                   Latin American Studies, Law, Law and Society, Linguistics, Management Studies, Manufacturing Engineering, 
                   Marine Science, Marketing, Mathematics, Mechanical Engineering, Medical Graduate Education, Medical Physics, 
                   Medical Science, Medicine, Museum and Heritage Studies, Music, Music Education, Music Performance, Nanoscience, 
                   Neuroscience, Nursing, Operations Managements, Organizational Behaviour and Human Resources, 
                   Petroleum Engineering, Philosophy, Physical Education, Physics, Planning, Plant Biology, Plant Biology, 
                   Political Science, Professional Land Management, Psychology, Public Policy, Real Estate Studies, 
                   Religious Studies, Risk Management and Insurance, Romance Studies, Russian, 
                   School of Creative and Performing Arts, Science, Slavic, Social Work, Sociology, Software Engineering, 
                   South Asian Studies, Space and Physics, Spanish, Statistics, Strategic Studies, Strategy and Global Management, 
                   Supply Chain Management, Sustainability Studies, Sustainable Energy Development, Tourism Management, 
                   Urban Studies, Veterinary Medicine, Wellbeing, Women’s Studies, Zoology";
                   $topicarr = explode (",", $topicstr);
                   foreach($topicarr as $topic):
                ?>
                      <option value="<?php echo $topic;?>"><?php echo $topic;?></option>
                   <?php endforeach;?>        
              </select>
            </div>
            <div class="">
              <label>Video Title:</label>
              <input type="text" name="video_title" value="<?php echo $rowv['video_title']?>" class="vinput" id="vidtitle">
            </div>
            <div class="">
              <label>Question 1:</label>
              <input type="text" name="q_one" value="<?php echo $rowt['q_one']?>" class="video-question">
            </div>
            <div class="answer">
              <label>Answer 1: </label>
              <label>True</label>
              <input type="radio" value="True" name="a_one" <?php echo ($rowt['a_one']=='True') ? 'checked="checked"' : '';?>>
              <label>False</label>
              <input type="radio" value="False" name="a_one" <?php echo ($rowt['a_one']=='False') ? 'checked="checked"' : '';?>>
            </div>
            <div class="">
              <label>Question 2:</label>
              <input type="text" name="q_two" value="<?php echo $rowt['q_two']?>" class="video-question">
            </div>
            <div class="answer">
              <label>Answer 2: </label>
              <label>True</label>
              <input type="radio" value="True" name="a_two" <?php echo ($rowt['a_two']=='True') ? 'checked="checked"' : '';?>>
              <label>False</label>
              <input type="radio" value="False" name="a_two" <?php echo ($rowt['a_two']=='False') ? 'checked="checked"' : '';?>>
            </div>
            <div class="">
              <label>Question 3:</label>
              <input type="text" name="q_three" value="<?php echo $rowt['q_three']?>" class="video-question">
            </div>
            <div class="answer">
              <label>Answer 3: </label>
              <label>True</label>
              <input type="radio" value="True" name="a_three" <?php echo ($rowt['a_three']=='True') ? 'checked="checked"' : '';?>>
              <label>False</label>
              <input type="radio" value="False" name="a_three" <?php echo ($rowt['a_three']=='False') ? 'checked="checked"' : '';?>>
            </div>
            <div class="">
              <label>Question 4:</label>
              <input type="text" name="q_four" value="<?php echo $rowt['q_four']?>" class="video-question">
            </div>
            <div class="answer">
              <label>Answer 4: </label>
              <label>True</label>
              <input type="radio" value="True" name="a_four" <?php echo ($rowt['a_four']=='True') ? 'checked="checked"' : '';?>>
              <label>False</label>
              <input type="radio" value="False" name="a_four" <?php echo ($rowt['a_four']=='False') ? 'checked="checked"' : '';?>>
            </div>
            <div class="">
              <label>Question 5:</label>
              <input type="text" name="q_five" value="<?php echo $rowt['q_five']?>" class="video-question">
            </div>
            <div class="answer">
              <label>Answer 5: </label>
              <label>True</label>
              <input type="radio" value="True" name="a_five" <?php echo ($rowt['a_five']=='True') ? 'checked="checked"' : '';?>>
              <label>False</label>
              <input type="radio" value="False" name="a_five" <?php echo ($rowt['a_five']=='False') ? 'checked="checked"' : '';?>>
            </div>
            <button type="submit" name="edit-submit" value="submit" class="upload-button">Submit</button>
          </form>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
