<?php
session_start();
include_once 'backend/dbconnect.php';
include_once 'objects/video.php';

$database = new DBconnect();
$db = $database->connect();
$video = new Video($db);
$stmt = $video->get_all_request();
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
    <section class="requested-wrapper">
      <div class="request-header">
        <h1>Requested Videos</h1>
      </div>
      <div class="request-container">
          <div class="request-box">
            <table>
              <thead>
                <th class="ndesc">Description</th>
                <th class="ntopic">Topic</th>
                <th class="nnotify">Notify User</th>
              </thead>
              <tbody>
                <?php if($stmt->rowCount()>0):
                while($req = $stmt->fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                  <td class = "request-title">
                      <p><?php echo $req['request_desc'];?></p>
                  </td>
                  <td class="request-topic">
                    <div>
                      <p><?php echo $req['request_topic'];?></p>
                    </div>
                  </td>
                  <td class="request-notify">
                    <div>
                      <a href="notify.php?id=<?php echo $req['request_id'];?>">Notify User of Upload</a>
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