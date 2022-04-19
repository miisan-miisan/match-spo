<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

$login_user = $_SESSION['login_user'];

$id = $_GET['id'];

// チーム削除不可バリデーション
$tempNum = UserLogic::memberNum($id);
$memberNum = intval($tempNum);

if($memberNum > 0){
  $_SESSION['cannotDelete'] = '既に参加者がいるため、削除できません！';
  header("Location: ./team_detail.php?id={$id}");
  return;
}

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
  <title>チーム詳細</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
  <h2 style="font-size: 2em; margin: 20px;">本当に<?php echo h($teamName) ?>を削除しますか？</h2>
  <?php if(isset($_SESSION['cannotDelete'])):?>
  <p style="color: red;"><?php echo $_SESSION['cannotDelete'];?></p>
  <?php unset($_SESSION['cannotDelete']);?>
  <?php endif;?>
  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th><td><?php echo h($sport)?></td></tr>
        <tr><th>チーム名</th><td><?php echo h($teamName)?></td></tr>
        <tr><th>開催日</th><td><?php echo h($playDate)?></td></tr>
        <tr><th>開催場所</th><td><?php echo h($playat)?></td></tr>
        <tr><th>募集人数</th><td><?php echo h($playersNum)?></td></tr>
        <tr><th>現在の参加人数</th><td><?php echo $memberNum;?></td></tr>
      </table>
    </div>
  </div>
  <button class="buttonUnifiedSize" style="margin-right: 50px"><a href="./team_detail.php?id=<?= h($id)?>">戻る</a></button>
  <button class="buttonUnifiedSize" style="margin-left: 50px; background-color: red;" ><a href = "team_delete.php?id=<?php echo h($id);?>&teamName=<?php echo h($teamName);?>">削除</a></button>

</div>
</body>
</html>