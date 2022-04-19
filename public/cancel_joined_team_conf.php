<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// ログインしているか判定し、していなかったら新規登録画面へ返す
$result = UserLogic::checkLogin();

if(!$result){
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください!';
  header('Location: ./user_register.php');
  return;
}

$id = $_GET['id'];

$teamDetail = UserLogic::teamDetail($id);

$sport = $teamDetail['sport_name'];
$teamName = $teamDetail['team_name'];
$playDate = $teamDetail['play_date'];
$playat = $teamDetail['play_at'];
$playersNum = $teamDetail['players_num'];



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <title>参加チーム詳細</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
  <p style="font-size: 2em;">本当に<?php echo h($teamName) ?>の参加をキャンセルしますか？</p>
  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th><td><?php echo h($sport)?></td></tr>
        <tr><th>チーム名</th><td><?php echo h($teamName)?></td></tr>
        <tr><th>開催日</th><td><?php echo h($playDate)?></td></tr>
        <tr><th>開催場所</th><td><?php echo h($playat)?></td></tr>
        <tr><th>募集人数</th><td><?php echo h($playersNum)?></td></tr>
      </table>
    </div>
  </div>
  <button class="buttonUnifiedSize" style="margin: 0 50px 50px 50px;"><a href="./join_team_mypage.php">戻る</a></button>

  <button class="buttonUnifiedSize" style="margin: 0 50px 50px 50px; background-color: red;" ><a href = "./cancel_joined_team.php?id=<?php echo h($id);?>&teamName=<?php echo $teamName;?>">キャンセル</a></button>

</div>
</body>
</html>