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
$allowedSexNum= $teamDetail['allowed_sex'];
if($allowedSexNum == 1){
  $allowedSex = "男女混合";
}else if($allowedSexNum == 2){
  $allowedSex = "男子のみ";
}else{
  $allowedSex = "女子のみ";
}

$teamName = $teamDetail['team_name'];
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
  <?php if(isset($_SESSION['cannotDelete'])):?>
  <p style="color: red;"><?php echo $_SESSION['cannotDelete'];?></p>
  <?php unset($_SESSION['cannotDelete']);?>
  <?php endif;?>
  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th><td><?php echo h($sport)?></td></tr>
        <tr><th>性別制限</th><td><?php echo h($allowedSex)?></td></tr>
        <tr><th>チーム名</th><td><?php echo h($teamName)?></td></tr>
        <tr><th>開催日</th><td><?php echo h($playDate)?></td></tr>
        <tr><th>開催場所</th><td><?php echo h($playat)?></td></tr>
        <tr><th>募集人数</th><td><?php echo h($playersNum)?></td></tr>
        <tr><th>現在の参加人数</th><td><?php echo $memberNum;?></td></tr>
      </table>
    </div>
  </div>
  <button class="buttonUnifiedSize" style="margin-right: 50px"><a href="./host_mypage.php">戻る</a></button>
  <button class="buttonUnifiedSize" style="margin:0 20px; background-color: rgb(127, 214, 255);" ><a href = "team_edit.php?id=<?php echo h($id);?>">編集</a></button>
  <button class="buttonUnifiedSize" style="margin-left: 50px; background-color: red;" ><a href = "team_delete_conf.php?id=<?php echo h($id);?>&teamName=<?php echo h($teamName);?>">削除</a></button>

</div>
</body>
</html>