<?php
session_start();

require_once('../classes/UserLogic.php');

// $result = UserLogic::checkLogin();
// if($result){
//   header('Location: mypage.php');
//   return;
// }

$err = $_SESSION;

// セッションを消す
$_SESSION = array();
session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/login.css">
  <title>ログイン</title>
</head>

<?php 
        require_once('./header.php'); 
?>

<body>
<div class="loginBox">
  <h2>ログイン</h2>
  <?php if (isset($err['msg'])): ?>
    <p class="validation"><?php echo $err['msg']; ?></p>
      <?php endif; ?>
  <div class="loginInputBox">
    <form action="./login.php" method="POST">
      <p>
        <label for="email">メールアドレス</label><br>
        <?php if (isset($err['email'])): ?>
        <p class="validation"><?php echo $err['email']; ?></p>
        <?php endif; ?>
        <input type="email" name="email"  class="inputBox">
      </p>
        <p>
          <label for="password">パスワード</label><br>
          <?php if (isset($err['password'])): ?>
          <p class="validation"><?php echo $err['password']; ?></p>
          <?php endif; ?>
          <input type="password" name="password"  class="inputBox">
          </p>
          <div style="font-size: 0.8em; text-align: center;">
            <a href="./reset_password_form.php">パスワードを忘れた方はこちら</a>
          </div>
  </div>
          <p class="loginBtnBox">
            <input type="submit" value="ログイン">
          </p>
        </form>

</div>
</body>
</html>