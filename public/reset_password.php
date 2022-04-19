<?php
session_start();

require_once('../classes/UserLogic.php');
require_once('../functions.php');

if(isset($_GET['userName'])){
  $err = $_SESSION;


  $_SESSION['userName'] = $_GET['userName'];
  $_SESSION['userEmail'] = $_GET['email'];
}

if(isset($_POST['name'])){
  // エラーメッセージ
  $err = [];
  
  // バリデーション
  if(!$userName = filter_input(INPUT_POST, 'name')){
    $err['name'] = '氏名を入力してください。';
  };
  if(!$email = filter_input(INPUT_POST, 'email')){
    $err['email'] = 'メールアドレスを入力してください。';
  }
  
  $result =  UserLogic::getUserByEmail_Pass($userName, $email);
  
  if(!isset($result['name'])){
    $err['noUser'] = 'ユーザが存在しません';
    
  }

    $_SESSION['userName'] = $userName;
    $_SESSION['userEmail'] = $email;

  if(count($err) > 0){
    // エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: ./reset_password_form.php');
    return;
  }
  
  $token = filter_input(INPUT_POST, 'csrf_token');
  
  // トークンがない、もしくは一致しない場合、処理を中止
  if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
  }
  
  unset($_SESSION['csrf_token']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/login.css">
  <title>パスワード再設定</title>
</head>

<?php 
        require_once('./header.php'); 
?>

<body>
<div class="loginBox">
  <h2>パスワード再設定</h2>
  <p>新しく設定するパスワードを入力してください</p>
  <?php if (isset($err['msg'])): ?>
    <p class="validation"><?php echo $err['msg']; ?></p>
      <?php endif; ?>
  <div class="loginInputBox">
    <form action="./reset_password_comp.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <p>
        <label for="password">新しいパスワード</label><br>
        <?php if (isset($err['password'])): ?>
        <p class="validation"><?php echo $err['password']; ?></p>
        <?php endif; ?>
        <input type="password" name="password"  class="inputBox">
        </p>
        <p>
          <label for="password_conf">確認用パスワード</label><br>
          <?php if (isset($err['password_conf'])): ?>
          <p class="validation"><?php echo $err['password_conf']; ?></p>
          <?php endif; ?>
          <input type="password" name="password_conf"  class="inputBox">
        </p>
  </div>
          <p class="loginBtnBox">
            <input type="submit" value="パスワードを再設定する">
          </p>
        </form>

</div>
</body>
</html>