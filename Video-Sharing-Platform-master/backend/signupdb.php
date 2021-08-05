<?php
  function retpage ()
  {
    header("location: ../signup.php?error");
    exit();
  }

  if(isset($_POST['signup-submit']))
  {
    include_once '../backend/dbconnect.php';
    $database = new DBconnect();
    $conn = $database->connect();

    $username = $_POST['username'];
    $usertype = $_POST['usertype'];
    $ranking = 0.00;
    $password = $_POST['password'];

    if (empty($username) || empty($usertype) || empty($password))
      retpage();
    else
    {
      $sql = "SELECT * FROM users WHERE user_name=:uname";
      if ($stmt = $conn->prepare($sql))
      {
        $username = htmlspecialchars(strip_tags($username));
        $stmt->bindParam(":uname",$username);
        $stmt->execute();
        $numRow = $stmt->rowCount();
        if($numRow>0)
          retpage();
      }
      else
        retpage();
    }

    $sql = "INSERT INTO users (user_name,user_type,user_ranking,user_password)
            VALUES (:username,:usertype,:ranking,:password)";

    if($stmt = $conn->prepare($sql))
    {
      $hash = password_hash($password,PASSWORD_DEFAULT);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':usertype', $usertype);
      $stmt->bindParam(':ranking', $ranking);
      $stmt->bindParam(':password', $hash);
      $stmt->execute();
      header("Location: ../index.php?success");
      exit();
    }
    else
      retpage();

    $stmt->close();
    $conn->close();
  }
  else
    retpage();
?>
