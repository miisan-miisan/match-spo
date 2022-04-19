<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

// バリデーション
if(!$name = filter_input(INPUT_POST, 'name')){
  $err['name'] = '氏名を記入してください。';
}
if(filter_input(INPUT_POST, 'sex') == 0){
  $err['sex'] = '性別を選択してください。';
}
if(!$adress = filter_input(INPUT_POST, 'adress')){
  $err['adress'] = '住所を記入してください。';
}
if(!$email = filter_input(INPUT_POST, 'email')){
  $err['email'] = 'メールアドレスを記入してください。';
}
// メールアドレスに重複がないかのバリデーション
if(isset($email)){

  $result = UserLogic::emailCheck($email);

  $emailCheck = intval($result);
  
  if($emailCheck === 1){
    $err['alreadyRegistered'] = 'このメールアドレスは既に登録されています。';
  }
}

$password = filter_input(INPUT_POST, 'password');
// 正規表現
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
  $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
  $err['password_conf'] = '確認用パスワードと異なっています。';
}

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header('Location: ./user_register.php');
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
  <link rel="stylesheet" href="./css/register.css">
  <title>新規登録確認画面</title>
</head>

<?php 
        require_once('./header_user_register.php'); 
?>

<body>
  <div class="registerFormBox">
    <h2>新規登録</h2>
    <p style="font-size: 1.5em;">この内容で登録してもよろしいですか？</p>
    <div class="registerInputBox" style="padding-top: 0;">
      <form action="user_register_comp.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
        <p>
          <label for="name">氏名</label><br>
          <input type="text" name="name" value=<?php echo $_POST['name'];?> class="inputBox" style=border:none; readonly>
        </p>
        <p>
        <p>
          <label for="sex">性別</label><br>
          <input type="text" name="sex" value=<?php echo $_POST['sex'];?> class="inputBox" style=border:none; readonly>
        </p>
        <p>
          <label for="adress">住所</label><br>
          <input type="text" name="adress" value=<?php echo $_POST['adress'];?> class="inputBox" style=border:none; readonly>
        </p>
        <p>
          <label for="email">メールアドレス</label><br>
          <input type="email" name="email" value=<?php echo $_POST['email'];?> class="inputBox" style=border:none; readonly>
        </p>
        <p>
          <label for="password">パスワード</label><br>
          <input type="password" name="password" value=<?php echo $_POST['password'];?> class="inputBox" style=border:none; readonly>
        </p>
      </div>
      <input type="button" value="戻る" onclick=history.back() style="margin-right: 100px"></input>
        <input type="submit" value="新規登録" style="margin-left: 100px">
      </form>
    <div class="registerBtnBox" style="">
    </div>
  </div>
</body>
</html>