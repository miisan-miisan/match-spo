<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// エラーメッセージ
$err = [];

// バリデーション

if(!$email = filter_input(INPUT_POST, 'email')){
  $err['email'] = 'メールアドレスを入力してください。';
}
if(!$password = filter_input(INPUT_POST, 'password')){
  $err['password'] = 'パスワードを入力してください。';

};

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header('Location: ./login_form.php');
  return;
}
// ログイン成功時の処理
$result = UserLogic::login($email, $password);

if(!$result){
  header('Location:./login_form.php');
  return;
}

$login_user = $_SESSION['login_user'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <title>マイページ</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
  <h1 style="text-align: center;">どちらでログインしますか？</h1>
<div class="linkLoginAsBox">
    <a href="./join_team_mypage.php" class="linkLoginAs">チームへ参加したい</a>
    <a href="./host_mypage.php" class="linkLoginAs">チームを作りたい</a>
</div>
</body>
</html>