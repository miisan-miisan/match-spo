<?php
session_start();
require_once '../classes/UserLogic.php';

// ログインしているか判定し、していなかったら新規登録画面へ返す
$result = UserLogic::checkLogin();

if(!$result){
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください!';
  header('Location: ./user_register.php');
  return;
}

$id = $_GET['id']; 
$userName = $_SESSION['login_user']['name'];
$userID = $_SESSION['login_user']['id'];

// エラーメッセージ
$err = [];

if(count($err) === 0){
  // ユーザを登録する処理
  $hasCreated = UserLogic::joinTeam($id, $userName, $userID);

  if(!$hasCreated){
    $err[] = '登録に失敗しました';
  }
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
  <link rel="stylesheet" href="./css/comp.css">
  <title>新規チーム登録完了</title>
</head>

<?php 
        require_once('./header_after_login.php' ); 
?>

<body>
  <?php if (count($err) > 0): ?>
    <?php foreach($err as $e): ?>
      <p><?php echo $e ;?></p>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="wrapper">
      <h2><?php echo $teamName;?>に新しく参加しました！</h2>
      <?php endif; ?>
      <a href="./join_team_mypage.php">ホームへ戻る</a>
    </div>
</body>
</html>