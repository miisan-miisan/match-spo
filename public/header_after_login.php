<?php
require_once '../classes/UserLogic.php';

$userName = $_SESSION['login_user']['name'];
?>

<header>
  <div id="header">
    <div class="logoBox">
      <div>
        <a href="./host_mypage.php">MATCH-SPO</a>
      </div>
    </div>
    <div style="line-height: 50px;">ユーザ名：<?= $userName?></div>
    <div class="logoutButton">
      <form action="logout.php" method="POST">
        <input type="submit" name="logout" value="ログアウト">
      </form>   
    </div>
  </div>
</header>