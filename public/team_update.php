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


$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない、もしくは一致しない場合、処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);


// 新規チーム登録内容バリデーション
$err = [];

if(!$sport = filter_input(INPUT_POST, 'sport')){
  $err['sport'] = 'スポーツを選択してください。';
}
if(!$teamName = filter_input(INPUT_POST, 'teamName')){
  $err['teamName'] = 'チーム名を入力してください。';
}
if(!$playDate = filter_input(INPUT_POST, 'playDate')){
  $err['playDate'] = '開催日を選択してください。';
}
if(!$playat = filter_input(INPUT_POST, 'playat')){
  $err['playat'] = '開催場所を入力してください。';
}
if(!$playersNumber = filter_input(INPUT_POST, 'playersNumber')){
  $err['playersNumber'] = '募集人数を選択してください。';
}


$id = $_POST['id'];

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header("Location: ./team_edit.php?id={$id}");
  return;
}

$updatedTeamDetail = UserLogic::teamUpdate($_POST);


if(count($err) === 0){
  $hasCreated = UserLogic::teamUpdate($_POST);

  if(!$hasCreated){
    $err[] = '登録に失敗しました';
  }
}

// 最新チーム情報
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
  <title><?php echo h($teamName);?>の内容変更完了</title>
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
      <h2><?php echo h($teamName);?> の内容変更が完了しました！</h2><br>
      <a href="./host_mypage.php">ホームへ戻る</a>
    </div>
  <?php endif; ?>
</body>
</html>