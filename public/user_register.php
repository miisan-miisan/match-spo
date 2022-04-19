<?php
session_start();
require_once('../functions.php');
require_once('../classes/UserLogic.php');

$sex = Userlogic::getSex();

$err = $_SESSION;

unset($_SESSION['userName']);
unset($_SESSION['userEmail']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/register.css">
  <title>新規登録</title>
</head>

<?php 
        require_once('./header_user_register.php' ); 
?>

<body>
  <div class="registerFormBox">
<h2>新規登録</h2>
<?php if(isset($_SESSION['login_err'])){
  echo  $_SESSION['login_err'];
  unset($_SESSION['login_err']);
  }?>
  <div class="registerInputBox">
    <form action="user_register_conf.php" method="POST">
      <p>
        <label for="name">氏名</label><br>
        <?php if (isset($err['name'])): ?>
        <p class="validation"><?php echo $err['name']; ?></p>
        <?php unset($err['name']);?>
        <?php endif; ?>
      <input type="text" name="name" class="inputBox">
    </p>
    <p>
      <label for="adress">住所</label><br>
        <?php if (isset($err['adress'])): ?>
        <p class="validation"><?php echo $err['adress']; ?></p>
        <?php unset($err['adress']);?>
        <?php endif; ?>
      <input type="text" name="adress" class="inputBox">
    </p>

    <p>
      <label for="sex">性別</label><br>
        <?php if (isset($err['sex'])): ?>
        <p class="validation"><?php echo $err['sex']; ?></p>
        <?php unset($err['sex']);?>
        <?php endif; ?>
        <select name="sex" id="sex">
          <option value="0">---選択してください---</option>
          <?php
           foreach($sex as $value){
             echo '<option value="', $value,'">', $value, '</option>';}
          ?>
        </select>
    </p>
    <p>
      <label for="email">メールアドレス</label><br>
      <?php if (isset($err['email'])): ?>
        <p class="validation"><?php echo $err['email']; ?></p>
        <?php unset($err['email']);?>
        <?php endif; ?>
      <?php if (isset($err['alreadyRegistered'])): ?>
        <p class="validation"><?php echo $err['alreadyRegistered']; ?></p>
        <?php unset($err['alreadyRegistered']);?>
        <?php endif; ?>
        <input type="email" name="email" class="inputBox">
      </p>
      <p>
        <label for="password">パスワード</label><br>
        <?php if (isset($err['password'])): ?>
          <p class="validation"><?php echo $err['password']; ?></p>
          <?php unset($err['password']);?>
          <?php endif; ?>
          <input type="password" name="password" class="inputBox">
        </p>
        <p>
          <label for="password_conf">パスワード確認</label><br>
          <?php if (isset($err['password_conf'])): ?>
            <p class="validation"><?php echo $err['password_conf']; ?></p>
            <?php unset($err['password_conf']);?>
            <?php endif; ?>
            <input type="password" name="password_conf" class="inputBox">
          </p>
        </div>
        <div class="registerBtnBox">
          <input type="submit" value="新規登録">
        </div>
      </div>
      </form>
</body>
</html>