<?php
session_start();

require_once('../classes/UserLogic.php');

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
  <title>パスワード再設定画面</title>
</head>

<?php 
        require_once( dirname(__FILE__) . './header.php' ); 
?>

<body>
<div class="loginBox">
  <?php 
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if(empty($selector) || empty($validator)){
      echo "不正なリクエストです！";
    }else{
      if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
        ?>

        <form action="./reset_password.inc.php" method="post">
          <input type="hidden" name="selector" value="<?php echo $selector ?>">
          <input type="hidden" name="validator" value="<?php echo $validator ?>">
          <input type="password" name="pwd" placeholder="新しいパスワードを入力してください">
          <input type="password" name="pwd-repeat" placeholder="確認のためもう一度入力してください">
          <button type="submit" name="reset-password-submit">パスワードの再設定を完了する</button>
        </form>
        <?php
      }
    }

  ?>
</div>

</body>
</html>