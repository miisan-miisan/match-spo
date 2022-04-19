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

$id = intval($_GET['id']);
$teamName = $_GET['teamName'];

$err = [];

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header("Location: ./team_detail.php?id={$id}");
  return;
}

// 削除処理
if(count($err) === 0){
  $hasDeleted = UserLogic::teamDelete($id);

  if(!$hasDeleted){
    $err[] = '削除失敗！';
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
  <title>チーム削除</title>
</head>

<?php 
        require_once('./header_after_login.php' ); 
?>

<body>
  <div class="wrapper">
    <?php if (count($err) > 0): ?>
    <?php foreach($err as $e): ?>
    <h2><?php echo $e ;?></h2>
    <?php endforeach; ?>
    <?php else : ?>
    <?php endif; ?>
    <h2><?php echo h($teamName);?> を削除しました。</h2>
    <a href="./host_mypage.php">ホームへ戻る</a>
  </div>
</body>
</html>