<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);
$video->user_id = $_SESSION['uid'];
$stmt = $video->get_request();
$stmtc = $video->get_complete();
$video->clear_noti();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style.css">
  <title>Request Video / Notification</title>
</head>
<body>
  <?php
     if(isset($_SESSION['uid']))
     {
       if($_SESSION['utype']==='Student')
         include_once 'headers/studentheader.php';
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
    <section class="upload-wrapper">
      <div class="upload-container">
        <div class="upload-box">
          <h1>Request Video</h1>
          <form action="video/requestb.php" method="POST" enctype="multipart/form-data">
            <div class="">
              <label for="request_topic">Video Topic:</label>
              <select name="request_topic" class="vinput" id="vidtopic">
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
              <label>Video Description:</label>
              <input type="text" name="request_desc" placeholder="Video Description" class="vinput" id="vidtitle">
            </div>
            <button type="submit" name="request-submit" value="submit" class="upload-button">Send Request</button>
          </form>
        </div>
      </div>
    </section>

    <section class="request-wrapper">
      <div class="request-header">
        <h1>Completed Requests</h1>
      </div>
      <div class="request-container">
          <div class="request-box">
            <table>
              <thead>
                <th class="ttitle">Title</th>
                <th class="tdesc">Description</th>
                <th class="ttopic">Topic</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php if($stmtc->rowCount()>0):
                while($req = $stmtc->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                  <td class="request-title">
                    <a href="watch.php?id=<?php echo $req['video_id'];?>"><?php echo $req['video_title'];?></a>
                  </td>
                  <td class = "request-title">
                      <p><?php echo $req['request_desc'];?></p>
                  </td>
                  <td class="request-topic">
                      <p><?php echo $req['request_topic'];?></p>
                  </td>
                  <td class="aligndata">
                    <div>
                      <a href="video/deletecomplete.php?id=<?php echo $req['complete_id'];?>" class="delete" class="action">delete</a>
                    </div>
                  </td>
                </tr>
                <?php endwhile; endif;?>
              </tbody>
            </table>
          </div>
      </div>
    </section>

    <section class="request-wrapper">
      <div class="request-header">
        <h1>Pending Requests</h1>
      </div>
      <div class="request-container">
          <div class="request-box">
            <table>
              <thead>
                <th class="tdesc">Description</th>
                <th class="ttopic">Topic</th>
                <th class="taction">Action</th>
              </thead>
              <tbody>
                <?php if($stmt->rowCount()>0):
                while($req = $stmt->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                  <td class = "request-title">
                      <p><?php echo $req['request_desc'];?></</p>
                  </td>
                  <td class="request-topic">
                    <div>
                      <p><?php echo $req['request_topic'];?></p>
                    </div>
                  </td>
                  <td class="aligndata">
                    <div>
                      <a href="video/deletepending.php?id=<?php echo $req['request_id'];?>" class="delete" class="action">delete</a>
                    </div>
                  </td>
                </tr>
                <?php endwhile; endif;?>
              </tbody>
            </table>
          </div>
      </div>
    </section>
  </main>
</body>
</html>
