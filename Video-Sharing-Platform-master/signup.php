<?php
  session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style.css">
  <title>Sign up</title>
</head>
<body>
  <main>
    <section class="signup-wrapper">
      <div class="signup-container">
        <div class="signup-box">
          <h1>Sign up</h1>
          <form action="backend/signupdb.php" method="POST">
            <div class="signup-input">
              <label>Educator:</label>
              <input type="radio" name="usertype" value="Educator" class="rinput">
              <label>Student:</label>
              <input type="radio" name="usertype" value="Student" class="rinput">
            </div>
            <div class="">
              <input type="text" name="username" placeholder="Username" class="signup-input">
            </div>
            <div class="">
              <input type="password" name="password" placeholder="Password" class="signup-input">
            </div>
            <button type="submit" name="signup-submit" class="signup-submit">Sign up</button>
          </form>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
