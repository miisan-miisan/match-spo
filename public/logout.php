<?php
session_start();
require_once '../classes/UserLogic.php';

if(!$logout = filter_input(INPUT_POST, 'logout')){
  exit('不正なリクエストです。');
}

// ログインしているか判定し、セッションが切れていたらログインしてくださいとメッセージを出す。
$result = UserLogic::checkLogin();

if(!$result){
  exit('セッションが切れましたので、ログインし直してください。');
}

// ログアウトする
UserLogic::logout();


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/comp.css">
  <title>ログアウト完了</title>
</head>

<?php 
        require_once('./header.php'); 
?>

<body>
  <div class="wrapper">
    <h2>ログアウトしました!</h2>
    <a href="login_form.php">ログインページへ</a>
  </div>
</body>
</html>