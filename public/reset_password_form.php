<?php
session_start();

require_once('../classes/UserLogic.php');
require_once('../functions.php');

$err = $_SESSION;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/login.css">
  <title>パスワード再設定認証</title>
</head>

<?php 
        require_once('./header.php'); 
?>

<body>
<div class="loginBox">
  <h2>パスワード再設定</h2>
  <p>氏名と登録しているメールアドレスを入力してください</p>
  <?php if (isset($err['noUser'])): ?>
  <p class="validation"><?php echo $err['noUser']; ?></p>
  <?php endif; ?>
  <div class="loginInputBox">
    <form action="./reset_password.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <p>
        <label for="name">氏名</label><br>
        <?php if (isset($err['name'])): ?>
          <p class="validation"><?php echo $err['name']; ?></p>
          <?php endif; ?>
        <input type="name" name="name"  class="inputBox">
        </p>
        <p>
          <label for="email">メールアドレス</label><br>
          <?php if (isset($err['email'])): ?>
          <p class="validation"><?php echo $err['email']; ?></p>
          <?php endif; ?>
          <input type="email" name="email"  class="inputBox">
        </p>
      </div>
      <p class="loginBtnBox">
        <input type="submit" value="パスワード再設定画面へ進む">
          </p>
        </form>

</div>
</body>
</html>