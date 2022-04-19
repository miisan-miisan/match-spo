<?php
session_start();
require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない、もしくは一致しない場合、処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);


if(count($err) === 0){
  // ユーザを登録する処理
  $hasCreated = UserLogic::createUser($_POST);

  if(!$hasCreated){
    $err[] = '登録に失敗しました';
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
  <title>ユーザー登録完了画面</title>
</head>

<?php 
        require_once './header_user_register.php'; 
?>

<body>
  <?php if (count($err) > 0): ?>
    <?php foreach($err as $e): ?>
      <p><?php echo $e ;?></p>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="wrapper">
      <h2>ユーザー登録が完了しました!</h2>
      <?php endif; ?>
      <a href="./login_form.php">ログイン</a>
    </div>
</body>
</html>