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


unset($_SESSION['enteredSport']);
unset($_SESSION['enteredPlayDate']);
unset($_SESSION['enteredPlayat']);

// スポーツ一覧
$sportsList = UserLogic::sportsList();

// バリデーションのセッション化
$err = $_SESSION;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <link rel="stylesheet" href="./css/register.css">
  <title>チーム検索</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
  <div class="container">
  <h1 style="margin-bottom: 0px;">チームの検索条件を入力してください<br><span style="color: red; font-size: 0.5em;">※スポーツと性別制限項目は必須です</span></h1>
    <div class="formBox" style="text-align: center;">
      <form action="./team_searched.php" method="post">

        <?php if (isset($_SESSION['sport_or_sex']['sport'])): ?>
        <p class="validation"><?php echo $_SESSION['sport_or_sex']['sport'];?></p><br>
        <?php unset($_SESSION['sport_or_sex']['sport']);?>
        <?php endif; ?>
        <label>スポーツ<br>
          <select name="sport" id="sport" style="text-align: center;">
          <option value="0">-------選択してください-------</option>
            <?php
            foreach($sportsList as $sport){
              echo '<option value="', $sport,'">', $sport, '</option>';
            }
            ?>
          </select>
        </label><br><br>

        <?php if (isset($_SESSION['sport_or_sex']['allowedSex'])): ?>
        <p class="validation"><?php echo $_SESSION['sport_or_sex']['allowedSex'];?></p><br>
        <?php unset($_SESSION['sport_or_sex']['allowedSex']);?>
        <?php endif; ?>
        <label>性別制限<br>
          <select name="allowedSex" id="allowedSex">
            <option value="0">---選択してください---</option>
            <option value="1">男女混合</option>
            <option value="2">男子のみ</option>
            <option value="3">女子のみ</option>
          </select>
        </label><br><br>
        
        <?php if (isset($err['playDate'])): ?>
        <p class="validation"><?php echo $err['playDate'];?></p>
        <?php endif; ?>
        <label>開催日<br>
            <input type="date" name="playDate" id="playDate">
        </label><br><br>

        <?php if (isset($err['playat'])): ?>
        <p class="validation"><?php echo $err['playat'];?></p>
        <?php endif; ?>
        <label>開催場所<br>
        <input type="text" name="playat" placeholder="住所の一部を入力(例:大阪府)" id="playat">
        </label><br><br>
        <button class="buttonUnifiedSize" style="margin-right: 20px"><a href="./join_team_mypage.php">戻る</a></button>
        <button type="submit" class="buttonUnifiedSize" style="margin-left: 20px">検索</button>
      </form>
   </div>
 </div>
</body>
</html>