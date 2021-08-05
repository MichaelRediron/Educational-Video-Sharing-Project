<?php
$noti = new Video($db);
$noti->user_id = $_SESSION['uid'];
$noticount = $noti->get_noti();
 ?>

<header>
  <!--<a href="home.php" class="header-logo">IQTransfer</a> -->
  <!--<img class="header-img" src="img/logo2.png"> -->
  <a href="home.php"><img class="header-combined" src="img/logo2.png"></img></a>
  <nav>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="search.php">Search</a></li>
      <li><a href="ranking.php">Rankings</a></li>
      <li><a href="scores.php">Grades</a></li>
      <li><a href="requestvid.php">
      <span>Video Request/Notification</span>
      <span class="badge"><?php echo $noticount?></span>
      </a></li>
    </ul>
    <a href="backend/logout.php" class="header-button">Log Out</a>
  </nav>
</header>
