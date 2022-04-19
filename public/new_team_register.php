<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';


// スポーツ一覧
$sportsList = UserLogic::sportsList();

// バリデーションのセッション化
$err = $_SESSION;

// ページ遷移後セッションが消えるため再生成
if(isset($_GET['userid'])){
  $_SESSION['login_user']['id'] = $_GET['userid'];
  $_SESSION['login_user']['name'] = $_GET['userName'];
}

// ログインチェック
$result = UserLogic::checkLogin();

if(!$result){
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください!';
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
  <link rel="stylesheet" href="./css/mypage.css">
  <link rel="stylesheet" href="./css/register.css">
  <title>新規チーム登録</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
  <div class="container">
  <h1>新規チーム登録</h1>
    <div class="formBox" style="text-align: center;">
      <form action="./new_team_register_conf.php" method="post">
        <?php if (isset($err['sport'])): ?>
        <p class="validation"><?php echo $err['sport'];?></p><br>
        <?php unset($_SESSION['sport']);?>
        <?php endif; ?>
        <label>スポーツ:
          <select name="sport" id="sport">
            <option value="0">---選択してください---</option>
            <?php
            foreach($sportsList as $sport){
              echo '<option value="', $sport,'">', $sport, '</option>';
            }
            ?>
          </select>
        </label><br><br>

        <?php if (isset($err['allowedSex'])): ?>
        <p class="validation"><?php echo $err['allowedSex'];?></p><br>
        <?php unset($_SESSION['allowedSex']);?>
        <?php endif; ?>
        <label>性別制限:
          <select name="allowedSex" id="allowedSex">
            <option value="0">---選択してください---</option>
            <option value="1">男女混合</option>
            <option value="2">男子のみ</option>
            <option value="3">女子のみ</option>
          </select>
        </label><br><br>
        <?php if (isset($err['teamName'])): ?>
        <p class="validation"><?php echo $err['teamName'];?></p>
        <?php unset($_SESSION['teamName']);?>
        <?php endif; ?>
        <label>チーム名:
        <input type="text" name="teamName" id="teamName">
          </label><br><br>
        <?php if (isset($err['playDate'])): ?>
        <p class="validation"><?php echo $err['playDate'];?></p>
        <?php unset($_SESSION['playDate']);?>
        <?php endif; ?>
        <label>開催日:
        <input type="date" name="playDate" id="playDate">
        </label><br><br>
        <?php if (isset($err['playat'])): ?>
        <p class="validation"><?php echo $err['playat'];?></p>
        <?php unset($_SESSION['playat']);?>
        <?php endif; ?>
        <label>開催場所:
        <input type="text" name="playat" placeholder="開催地の住所を入力" id="playat">
        </label><br><br>
        <?php if (isset($err['playersNumber'])): ?>
        <p class="validation"><?php echo $err['playersNumber'];?></p>
        <?php endif; ?>
        <label>募集人数:
        <select name="playersNumber" id="playersNumber">
          <?php
          $number = array (
            "5","10","15","20","25","30",
          );
          foreach ( $number as $value ) {
            echo '<option value="', $value, '">', $value, '</option>';
          }
          ?>
        </select>  
        </label><br><br>
        <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
        <button class="buttonUnifiedSize" style="margin-right: 20px"><a href="./host_mypage.php">戻る</a></button>
        <button type="submit" class="buttonUnifiedSize" style="margin-left: 20px">内容確認</button>
      </form>
   </div>
 </div>
</body>
</html>