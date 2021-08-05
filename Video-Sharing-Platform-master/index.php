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
  <title>Welcome</title>
</head>
<body>
  <main>
    <section class="index-wrapper">
      <div class="index-left">
          <div class="index-content">
            <h1>Welcome</h1>
            <p>Please sign in or create an account</p>
          </div>
      </div>
      <div class="index-right">
        <div class="signin-box">
          <div class="logo">
             <img class="header-img" src="img/logo2.png">
          </div>
            <form class="login" action="backend/logindb.php" method="post">
              <div class="">
                <label>Username</label>
                <input type="text" name="login-uid" class="index-input">
              </div>
              <div class="">
                <label>Password</label>
                <input type="password" name="login-password" class="index-input">
              </div>
              <button type="submit" name="login-submit" value="submit" class="signin-button">Sign in</button>
            </form>
            <a href="signup.php" class="signup-button">Create Free Account</a>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
