<?php
  function retpage ()
  {
    header("location: ../index.php?error");
    exit();
  }

  if(isset($_POST['login-submit']))
  {
    include_once '../backend/dbconnect.php';
    $database = new DBconnect();
    $conn = $database->connect();

    $username = $_POST['login-uid'];
    $password = $_POST['login-password'];

    if (empty($username) || empty($password))
      retpage();
    else
    {
      $sql = "SELECT * FROM users WHERE user_name=:uname";
      $stmt = $conn->prepare($sql);
      $username = htmlspecialchars(strip_tags($username));
      $stmt->bindParam(":uname",$username);
      $stmt->execute();
      $numRow = $stmt->rowCount();

      if($numRow>0)
      {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $pass = password_verify($password,$row['user_password']);
        if($pass)
        {
          session_start();
          $_SESSION['uid'] = $row['user_id'];
          $_SESSION['username'] = $row['user_name'];
          $_SESSION['utype'] = $row['user_type'];
          header("Location: ../home.php");
          exit();
        }
        else
          retpage();
      }
      else
        retpage();
    }
  }
  else
    retpage();
?>
