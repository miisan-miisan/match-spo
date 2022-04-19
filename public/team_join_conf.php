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

$loginUser = $_SESSION['login_user'];


$id = $_GET['id'];


$teamDetail = UserLogic::teamDetail($id);
// ホストが同じかどうかのバリデーション
if($teamDetail['host_id'] === $loginUser['id']){
  $_SESSION['hostIsYou'] = "あなたがホストです！<br>参加できません。";
  header("Location: ./team_join_detail.php?id={$id}");
  return;
}

// 既にこのチームに参加しているかどうかのバリデーション
$userID = $loginUser['id'];

  $result = UserLogic::joiningTeamID($userID);

  if(isset($result['team_id'])){
    $joiningTeamID = $result['team_id'];

    $joiningTeam = UserLogic::joiningTeam($joiningTeamID);
  }

  if(isset($joiningTeam['id'])){
    if($id === $joiningTeam['id']){
      $_SESSION['alreadyJoined'] = "既にこのチームに参加しています！";
      header("Location: ./team_join_detail.php?id={$id}");
    }
  }

  
  $sport = $teamDetail['sport_name'];
  $temp_allowedSexNum= $teamDetail['allowed_sex'];
  $allowedSexNum = intval($temp_allowedSexNum);
  if($allowedSexNum === 1){
    $allowedSex = "男女混合";
}else if($allowedSexNum === 2){
  $allowedSex = "男子のみ";
}else{
  $allowedSex = "女子のみ";
}
$teamName = $teamDetail['team_name'];
$hostName = $teamDetail['name'];
$playDate = $teamDetail['play_date'];
$playat = $teamDetail['play_at'];
$playersNum = $teamDetail['players_num'];


// 性別制限バリデーション

if($_SESSION['login_user']['sex'] == '男'){
  if($allowedSexNum === 3){
    $_SESSION['sexErr']['womenOnly']= "このチームは女性のみ参加可能です。";
  }
}else if($_SESSION['login_user']['sex'] == '女'){
  if($allowedSexNum === 2){
    $_SESSION['sexErr']['menOnly']= "このチームは男性のみ参加可能です。";
  }
}else{
  return;
};

if(isset($_SESSION['sexErr'])){
  header("Location: ./team_join_detail.php?id={$id}'");
  return;
}




?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <title>参加確認</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
<h2 style="font-size: 2em; margin: 20px;">本当に<?php echo h($teamName) ?>に参加しますか？</h2>
  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th><td><?php echo h($sport)?></td></tr>
        <tr><th>性別制限</th><td><?php echo h($allowedSex)?></td></tr>
        <tr><th>チーム名</th><td><?php echo h($teamName)?></td></tr>
        <tr><th>ホスト名</th><td><?php echo h($hostName)?></td></tr>
        <tr><th>開催日</th><td><?php echo h($playDate)?></td></tr>
        <tr><th>開催場所</th><td><?php echo h($playat)?></td></tr>
        <tr><th>募集人数</th><td><?php echo h($playersNum)?></td></tr>
      </table>
    </div>
  </div>
  <button class="buttonUnifiedSize" style="margin-right: 50px"><a href="./team_search.php">戻る</a></button>
  <button class="buttonUnifiedSize" style="margin-left: 50px; background-color: red;" ><a href = "./team_join_comp.php?id=<?php echo h($id);?>&teamName=<?php echo h($teamName);?>">参加する</a></button>

</div>
</body>
</html>