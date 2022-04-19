<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// $login_user = $_SESSION['login_user'];

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
$allowedSexNum = $teamDetail['allowed_sex'];

if($allowedSexNum == 1){
  $allowedSex = "男女混合";
}else if($allowedSexNum == 2){
  $allowedSex = "男子のみ";
}else if($allowedSexNum == 3){
  $allowedSex = "女子のみ";
}else{
  $allowedSex = "";
}

$teamName = $teamDetail['team_name'];
$hostName = $teamDetail['name'];
$playDate = $teamDetail['play_date'];
$playat = $teamDetail['play_at'];
$playersNum = $teamDetail['players_num'];

$memberNum = UserLogic::memberNum($id);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <title>チーム詳細</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
  <h1 style="margin: 20px;"><?php echo h($teamName) ?>の詳細</h1>
  <?php if(isset($_SESSION['hostIsYou'])):?>
  <p style="color: red"><?php echo $_SESSION['hostIsYou'];?></p>
  <?php unset($_SESSION['hostIsYou']);?>
  <?php endif;?>
  <?php if(isset($_SESSION['alreadyJoined'])):?>
  <p style="color: red"><?php echo $_SESSION['alreadyJoined'];?></p>
  <?php unset($_SESSION['alreadyJoined']);?>
  <?php endif;?>
  <?php if(isset($_SESSION['sexErr']['womenOnly'])):?>
  <p style="color: red"><?php echo $_SESSION['sexErr']['womenOnly'];?></p>
  <?php unset($_SESSION['sexErr']['womenOnly']);?>
  <?php endif;?>
  <?php if(isset($_SESSION['sexErr']['menOnly'])):?>
  <p style="color: red"><?php echo $_SESSION['sexErr']['menOnly'];?></p>
  <?php unset($_SESSION['sexErr']['menOnly']);?>
  <?php endif;?>

  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th><td><?php echo h($sport)?></td></tr>
        <tr><th>チーム名</th><td><?php echo h($teamName)?></td></tr>
        <tr><th>性別制限</th><td><?php echo h($allowedSex)?></td></tr>
        <tr><th>ホスト名</th><td><?php echo h($hostName)?></td></tr>
        <tr><th>開催日</th><td><?php echo h($playDate)?></td></tr>
        <tr><th>開催場所</th><td><?php echo h($playat)?></td></tr>
        <tr><th>募集人数</th><td><?php echo h($playersNum)?></td></tr>
        <tr><th>現在の参加人数</th><td><?php echo $memberNum;?></td></tr>
      </table>
    </div>
  </div>
  <button class="buttonUnifiedSize" style="margin-right: 50px"><a href="./team_searched.php">戻る</a></button>
  <button class="buttonUnifiedSize" style="margin-left: 50px; background-color: red;" ><a href = "./team_join_conf.php?id=<?php echo h($id);?>&teamName=<?php echo h($teamName);?>">参加する</a></button>

</div>
</body>
</html>