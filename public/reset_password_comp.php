<?php
session_start();
require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

// バリデーション
// if(!$name = filter_input(INPUT_POST, 'name')){
//   $err['name'] = '氏名を記入してください。';
// }
// if(!$adress = filter_input(INPUT_POST, 'adress')){
//   $err['adress'] = '住所を記入してください。';
// }
// if(!$email = filter_input(INPUT_POST, 'email')){
//   $err['email'] = 'メールアドレスを記入してください。';
// }

$password = filter_input(INPUT_POST, 'password');
// 正規表現
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
  $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
  $err['password_conf'] = '確認用パスワードが異なっています。';
}


if(isset($_SESSION['userName'])){
  $userName = $_SESSION['userName'];
  $email = $_SESSION['userEmail'];
}

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  $url = "./reset_password.php?userName={$userName}&email={$email}";
  header("Location: ".$url);
  return;
}

$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない、もしくは一致しない場合、処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);


if(count($err) === 0){
  // ユーザを登録する処理
  $hasCreated = UserLogic::newPassword($password, $email);
  unset($_SESSION['userName']);
  unset($_SESSION['userEmail']);

  if(!$hasCreated){
    $err[] = 'パスワードの再設定に失敗しました';
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
  <title>パスワード再設定完了</title>
</head>

<?php 
        require_once './header.php' ; 
?>

<body>
  <?php if (count($err) > 0): ?>
    <?php foreach($err as $e): ?>
      <p><?php echo $e ;?></p>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="wrapper">
      <h2>パスワードの再設定が完了しました!</h2>
      <?php endif; ?>
      <a href="./login_form.php">ログイン</a>
    </div>
</body>
</html>