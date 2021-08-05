<?php
  session_start();
  include_once 'backend/dbconnect.php';
  include_once 'objects/video.php';

  $database = new DBconnect();
  $db = $database->connect();
  $video = new Video($db);
  $video->user_id = $_SESSION['uid'];
  $default = 'all';
  $selection = !empty($_GET['sid']) ? $_GET['sid'] : $default;
  $stmt = $video->read_all_video_sort($selection);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style.css">
  <script src="javascript/msort.js"></script>
  <title>Manage Video</title>
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
    <section class="manage-wrapper">
      <div class="mbutton">
        <a href="uploadvid.php" class="mupload-button">Upload Video +</a>
      </div>
      <div class="manage-header">
        <div class = "manage-sort">
          <label for="msort">Sort By:</label>
          <select name="msort" class="vinput" id="vidtopic" onChange="refreshP(this.value);">
            <option value="all">All</option>
            <option value="video_pdate">Post Date</option>
            <option value="video_rating">Rating</option>
            <option value="video_title">Title</option>
            <option value="video_topic">Topic</option>
          </select>
       </div>
      </div>
      <div class="manage-container">
          <div class="manage-box">
            <table>
              <thead>
                <th class="tv">Video Info</th>
                <th class="tt">Thumbnail</th>
                <th class="ta">Action</th>
              </thead>
              <tbody>
              <?php if($stmt->rowCount()>0):
                while($vid = $stmt->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                  <td class="video-info">
                    <div>
                      <a href="watch.php?id=<?php echo $vid['video_id'];?>"><?php echo $vid['video_title'];?></a>
                    </div>
                    <span>Video Topic: <?php echo $vid['video_topic'];?></span>
                    <div>
                    <span>Video Postdate: <?php echo $vid['video_pdate'];?></span>
                    <?php $num = 5 * $vid['video_rating']?>
                    <span>Video Rating: <?php echo $num.'/5 Stars';?></span>
                    </div>
                  </td>
                  <td class="aligndata">
                    <img src="<?php echo $vid["video_thumb"];?>">
                  </td>
                  <td class="aligndata">
                    <div>
                      <a href="editvideo.php?id=<?php echo $vid['video_id'];?>" class="edit" class="action">edit</a>
                    </div>
                    <div>
                      <a href="video/delete.php?id=<?php echo $vid['video_id'];?>" class="delete" class="action">delete</a>
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
