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


$err = [];

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header("Location: ./detailed_join_team.php?id={$id}");
  return;
}

$id = $_GET['id'];
$teamName = $_GET['teamName'];

// 削除処理
$userID = $_SESSION['login_user']['id'];

if(count($err) === 0){
  $hasCreated = UserLogic::joinedTeamCancel($id, $userID);

  if(!$hasCreated){
    $err[] = 'キャンセルに失敗しました';
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/comp.css">
  <title>チーム参加キャンセル</title>
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
      <h2><?php echo h($teamName);?> の参加をキャンセルしました。</h2>
      <?php endif; ?>
      <a href="./join_team_mypage.php">ホームへ戻る</a>
    </div>
</body>
</html>