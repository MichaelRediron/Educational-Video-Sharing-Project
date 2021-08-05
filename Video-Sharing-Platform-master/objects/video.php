<?php
class Video
{
  private $conn;
  public $video_id;
  public $video_title;
  public $video_topic;
  public $video_user;
  public $video_rating;
  public $user_id;
  public $test_id;
  public $q_one;
  public $q_two;
  public $q_three;
  public $q_four;
  public $q_five;
  public $a_one;
  public $a_two;
  public $a_three;
  public $a_four;
  public $a_five;
  public $request_id;
  public $request_topic;
  public $request_desc;
  public $complete_id;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function upload($thumb,$vid)
  {
    $rating = "0.00";
    $views = 0;
    $pdate = date('Y-m-d H:i:s');
    $maxthumbsize = 5242880; //5mb

    $vidfile = $_FILES[$vid];
    $vidname = $_FILES[$vid]['name'];
    $newvname = uniqid('',true);
    $vidtemp = $_FILES[$vid]['tmp_name'];
    $vidsize = $_FILES[$vid]['size'];
    $viderror = $_FILES[$vid]['error'];
    $targetvdir = "video/uploadedvideo/".$newvname;

    $thumbfile = $_FILES[$thumb];
    $thumbname = $_FILES[$thumb]['name'];
    $newtname = uniqid('',true);
    $thumbtemp = $_FILES[$thumb]['tmp_name'];
    $thumbsize = $_FILES[$thumb]['size'];
    $thumberror = $_FILES[$thumb]['error'];
    $targettdir = "video/uploadedthumb/".$newtname;

    $vidext = explode('.',$vidname);
    $vidextb = strtolower(end($vidext));
    $thumbext = explode('.',$thumbname);
    $thumbextb = strtolower(end($thumbext));

    $vidallow = array('mp4','avi','3gp','mov','mpeg');
    $thumballow = array('jpg','jpeg','png');

    if(in_array($vidextb,$vidallow) && in_array($thumbextb,$thumballow))
    {
      if($viderror === 0 && $thumberror === 0)
      {
        if($thumbsize <= $maxthumbsize)
        {
          if(move_uploaded_file($vidtemp,"../".$targetvdir) && move_uploaded_file($thumbtemp,"../".$targettdir))
          {
            $sql = "INSERT INTO video
                   SET video_title = :video_title, video_topic = :video_topic,
                   video_path = :video_path, video_thumb = :video_thumb,
                   video_rating = :video_rating, video_views = :video_views, 
                   video_pdate = :video_pdate, video_user = :video_user,
                  user_id = :user_id";

            $stmt = $this->conn->prepare($sql);
            $this->video_title = htmlspecialchars(strip_tags($this->video_title));
            $this->video_topic = htmlspecialchars(strip_tags($this->video_topic));
            $stmt->bindParam(":video_title",$this->video_title);
            $stmt->bindParam(":video_topic",$this->video_topic);
            $stmt->bindParam(":video_path",$targetvdir);
            $stmt->bindParam(":video_thumb",$targettdir);
            $stmt->bindParam(":video_rating",$rating);
            $stmt->bindParam(":video_views",$views);
            $stmt->bindParam(":video_pdate",$pdate);
            $stmt->bindParam(":video_user",$this->video_user);
            $stmt->bindParam(":user_id",$this->user_id);
            $vidcheck = $stmt->execute();

            $sql = "INSERT INTO tests
                   SET q_one = :q_one, q_two = :q_two, q_three = :q_three, q_four = :q_four,
                   q_five = :q_five, a_one = :a_one, a_two = :a_two, a_three = :a_three,
                   a_four = :a_four, a_five = :a_five, video_id = :video_id";

            $videoid = $this->conn->lastInsertId();
            $stmt = $this->conn->prepare($sql);
            $this->q_one = htmlspecialchars(strip_tags($this->q_one));
            $this->q_two = htmlspecialchars(strip_tags($this->q_two));
            $this->q_three = htmlspecialchars(strip_tags($this->q_three));
            $this->q_four = htmlspecialchars(strip_tags($this->q_four));
            $this->q_five = htmlspecialchars(strip_tags($this->q_five));
            $this->a_one = htmlspecialchars(strip_tags($this->a_one));
            $this->a_two = htmlspecialchars(strip_tags($this->a_two));
            $this->a_three = htmlspecialchars(strip_tags($this->a_three));
            $this->a_four = htmlspecialchars(strip_tags($this->a_four));
            $this->a_five = htmlspecialchars(strip_tags($this->a_five));
            $stmt->bindParam(":q_one",$this->q_one);
            $stmt->bindParam(":q_two",$this->q_two);
            $stmt->bindParam(":q_three",$this->q_three);
            $stmt->bindParam(":q_four",$this->q_four);
            $stmt->bindParam(":q_five",$this->q_five);
            $stmt->bindParam(":a_one",$this->a_one);
            $stmt->bindParam(":a_two",$this->a_two);
            $stmt->bindParam(":a_three",$this->a_three);
            $stmt->bindParam(":a_four",$this->a_four);
            $stmt->bindParam(":a_five",$this->a_five);
            $stmt->bindParam(":video_id",$videoid);

            if($vidcheck && $stmt->execute())
              return true;

            return false;
          }
        }
        else
          return false;
      }
      else
        return false;
    }
    else
      return false;
  }

  //FUNCTIONS BELOW NOT TESTED BUT SHOULD WORK

  function read_single_video()
  {
    $sql = "SELECT * FROM video WHERE video_id=:id";
    $stmt = $this->conn->prepare($sql);
    $this->video_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);

    if($stmt->execute() && $stmt->rowCount()>0)
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
  }

  function read_single_test()
  {
    $sql = "SELECT * FROM tests WHERE video_id=:id";
    $stmt = $this->conn->prepare($sql);
    $this->video_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);

    if($stmt->execute() && $stmt->rowCount()>0)
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
  }

  function read_all_video($input)
  {
    $sql = "SELECT * FROM video ORDER BY $input DESC";
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute())
      return $stmt;
  }

  function read_all_video_sort($input)
  {
    if($input==='all')
      $sql = "SELECT * FROM video WHERE user_id = $this->user_id ORDER BY video_pdate DESC";
    else if($input==='video_rating' || $input==='video_pdate')
      $sql = "SELECT * FROM video WHERE user_id = $this->user_id ORDER BY $input DESC";
    else
      $sql = "SELECT * FROM video WHERE user_id = $this->user_id ORDER BY $input ASC";
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute())
      return $stmt;
  }

  function read_ten_videos($input)
  {
    $sql = "SELECT * FROM video ORDER BY $input DESC LIMIT 5";
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute())
      return $stmt;
  }

  function delete_video()
  {
    $sql = "DELETE FROM tests WHERE video_id = :id";
    $stmt = $this->conn->prepare($sql);
    $this->video_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);
    $testcheck = $stmt->execute();

    $sql = "DELETE FROM complete WHERE video_id = :id";
    $stmt = $this->conn->prepare($sql);
    $this->video_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);
    $compcheck = $stmt->execute();

    $sql = "SELECT * FROM video WHERE video_id=:id";
    $stmt = $this->conn->prepare($sql);
    $this->event_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $vpath = $row['video_path'];
    $tpath = $row['video_thumb'];

    $sql = "DELETE FROM video WHERE video_id = :id";
    $stmt = $this->conn->prepare($sql);
    $this->video_id = htmlspecialchars(strip_tags($this->video_id));
    $stmt->bindParam(":id",$this->video_id);
    if($stmt->execute() && $testcheck && $compcheck)
    {
      unlink("../".$tpath);
      unlink("../".$vpath);
      return true;
    }
    return false;
  }

  function search_video($keyword)
  {
    if($keyword==='none')
      return false;
    else
    {
      $sql = "SELECT * FROM video WHERE video_title LIKE '%$keyword%' OR video_topic LIKE '%$keyword%'
              OR video_user LIKE '%$keyword%' ORDER BY video_rating DESC";
      $stmt = $this->conn->prepare($sql);
      if($stmt->execute())
        return $stmt;
    }
  }

  function update_video()
  {
    
    $sql = "UPDATE video
            SET video_title = :video_title, video_topic = :video_topic
            WHERE video_id = $this->video_id";

    $stmt = $this->conn->prepare($sql);
    $this->video_title = htmlspecialchars(strip_tags($this->video_title));
    $this->video_topic = htmlspecialchars(strip_tags($this->video_topic));
    $stmt->bindParam(":video_title",$this->video_title);
    $stmt->bindParam(":video_topic",$this->video_topic);
    $vidcheck = $stmt->execute();

    $sql = "UPDATE tests
            SET q_one = :q_one, q_two = :q_two, q_three = :q_three, q_four = :q_four,
            q_five = :q_five, a_one = :a_one, a_two = :a_two, a_three = :a_three,
            a_four = :a_four, a_five = :a_five
            WHERE video_id = $this->video_id";

    $stmt = $this->conn->prepare($sql);
    $this->q_one = htmlspecialchars(strip_tags($this->q_one));
    $this->q_two = htmlspecialchars(strip_tags($this->q_two));
    $this->q_three = htmlspecialchars(strip_tags($this->q_three));
    $this->q_four = htmlspecialchars(strip_tags($this->q_four));
    $this->q_five = htmlspecialchars(strip_tags($this->q_five));
    $this->a_one = htmlspecialchars(strip_tags($this->a_one));
    $this->a_two = htmlspecialchars(strip_tags($this->a_two));
    $this->a_three = htmlspecialchars(strip_tags($this->a_three));
    $this->a_four = htmlspecialchars(strip_tags($this->a_four));
    $this->a_five = htmlspecialchars(strip_tags($this->a_five));
    $stmt->bindParam(":q_one",$this->q_one);
    $stmt->bindParam(":q_two",$this->q_two);
    $stmt->bindParam(":q_three",$this->q_three);
    $stmt->bindParam(":q_four",$this->q_four);
    $stmt->bindParam(":q_five",$this->q_five);
    $stmt->bindParam(":a_one",$this->a_one);
    $stmt->bindParam(":a_two",$this->a_two);
    $stmt->bindParam(":a_three",$this->a_three);
    $stmt->bindParam(":a_four",$this->a_four);
    $stmt->bindParam(":a_five",$this->a_five);

    if($vidcheck && $stmt->execute())
      return true;

    return false;
  }

function update_views() {
  $sql = "UPDATE video
          SET video_views = video_views + 1
          WHERE video_id = $this->video_id";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
}

function get_views() {
  $sql = "SELECT video_views
          FROM video
          WHERE video_id = $this->video_id";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
  $views = $stmt->fetch(PDO::FETCH_ASSOC);
  return $views['video_views'];
}

function check_wrote_quiz() {
  $sql = "SELECT * FROM testscore WHERE test_id=:tid AND user_id=:usid";
  $stmt = $this->conn->prepare($sql);
  $this->test_id = htmlspecialchars(strip_tags($this->test_id));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $stmt->bindParam(":tid",$this->test_id);
  $stmt->bindParam(":usid",$this->user_id);
  
  if($stmt->execute()) 
  {
    if($stmt->rowCount()>0)
      return true;
    else
      return false;
  }
  else
    return false;
}

function update_video_rating() {
  $this->update_views();
  $numviews = $this->get_views();
  $newweight = $numviews * 5;
  $prevweight = ($numviews-1)*5;
  $rate = $this->video_rating;

  $sql = "UPDATE video
          SET video_rating = (video_rating * $prevweight + $rate) / $newweight
          WHERE video_id = $this->video_id";
  $stmt = $this->conn->prepare($sql);
  if($stmt->execute())
    return true;
  else
    return false;
}

function uploadquiz()
{
  $score = 0;
  $testrow = $this->read_single_test();

  if($testrow['a_one']===$this->a_one)
    $score++;
  if($testrow['a_two']===$this->a_two)
    $score++;
  if($testrow['a_three']===$this->a_three)
    $score++;
  if($testrow['a_four']===$this->a_four)
    $score++;
  if($testrow['a_five']===$this->a_five)
    $score++;
  $score /= 5;

  $sql = "INSERT INTO testscore
          SET score = :score, user_id = :user_id, test_id = :test_id";
    
  $stmt = $this->conn->prepare($sql);
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->test_id = htmlspecialchars(strip_tags($this->test_id));

  $stmt->bindParam(":score",$score);
  $stmt->bindParam(":user_id",$this->user_id);
  $stmt->bindParam(":test_id",$this->test_id);

  if($stmt->execute())
  {
    if($this->update_video_rating())
      return true;
    else
      return false;
  }
  else
    return false;
}

function sendrequest() {

  $sql = "INSERT INTO request
          SET request_topic = :request_topic, request_desc = :request_desc,  user_id = :user_id";

  $stmt = $this->conn->prepare($sql);
  $this->request_topic = htmlspecialchars(strip_tags($this->request_topic));
  $this->request_desc = htmlspecialchars(strip_tags($this->request_desc));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));

  $stmt->bindParam(":request_topic",$this->request_topic);
  $stmt->bindParam(":request_desc",$this->request_desc);
  $stmt->bindParam(":user_id",$this->user_id);

  if($stmt->execute())
    return true;
  else
    return false;
}

function get_request() {
  $sql = "SELECT * FROM request WHERE user_id = $this->user_id";
  $stmt = $this->conn->prepare($sql);
  if($stmt->execute())
      return $stmt;
}

function get_all_request() {
  $sql = "SELECT * FROM request ORDER BY request_id DESC";
  $stmt = $this->conn->prepare($sql);
  if($stmt->execute())
      return $stmt;
}

function delete_request() {
    $sql = "DELETE FROM request WHERE request_id = :id";
    $stmt = $this->conn->prepare($sql);
    $this->request_id = htmlspecialchars(strip_tags($this->request_id));
    $stmt->bindParam(":id",$this->request_id);
    if($stmt->execute())
      return true;
    else
      return false;
}

function get_data_request() {
  $sql = "SELECT * FROM request WHERE request_id = $this->request_id";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row;
}

function get_complete() {
  $sql = "SELECT * FROM complete WHERE user_id = $this->user_id";
  $stmt = $this->conn->prepare($sql);
  if($stmt->execute())
      return $stmt;
}

function delete_complete() {
  $sql = "DELETE FROM complete WHERE complete_id = :id";
  $stmt = $this->conn->prepare($sql);
  $this->request_id = htmlspecialchars(strip_tags($this->complete_id));
  $stmt->bindParam(":id",$this->complete_id);
  if($stmt->execute())
    return true;
  else
    return false;
}

function get_noti() {
  $unread = 'unread';
  $sql = "SELECT * FROM complete WHERE user_id = :user_id AND noti_status = :noti_status";
  $stmt = $this->conn->prepare($sql);
  $stmt->bindParam(":user_id",$this->user_id);
  $stmt->bindParam(":noti_status",$unread);
  $stmt->execute();
  $num = $stmt->rowCount();
  return $num;
}

function clear_noti()
{
  $sql = "UPDATE complete
  SET noti_status = 'read'
  WHERE user_id = $this->user_id";
  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
}

function send_notify()
{
  $row = $this->get_data_request();
  $uid = $row['user_id'];
  $topic = $row['request_topic'];
  $desc = $row['request_desc'];
  $unread = 'unread';

  $row = $this->read_single_video();
  $title = $row['video_title'];

  $sql = "INSERT INTO complete
          SET video_id = :video_id, video_title = :video_title, request_topic = :request_topic,
          request_desc = :request_desc, noti_status = :noti_status, request_id = :request_id, user_id =:user_id";

  $stmt = $this->conn->prepare($sql);
  $this->video_id = htmlspecialchars(strip_tags($this->video_id));
  $this->request_id = htmlspecialchars(strip_tags($this->request_id));

  $stmt->bindParam(":video_id",$this->video_id);
  $stmt->bindParam(":video_title",$title);
  $stmt->bindParam(":request_id",$this->request_id);
  $stmt->bindParam(":request_topic",$topic);
  $stmt->bindParam(":request_desc",$desc);
  $stmt->bindParam(":noti_status",$unread);
  $stmt->bindParam(":user_id",$uid);

  if($stmt->execute())
  {
    if($this->delete_request())
      return true;
    else
      return false;
  }
  else
    return false;
}

}
?>
