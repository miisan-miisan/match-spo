<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';


// チーム内容詳細
if(isset($_GET['id'])){
  $id = $_GET['id'];
}

$teamDetail = UserLogic::teamDetail($id);

$sport = $teamDetail['sport_name'];
$teamName = $teamDetail['team_name'];
$playDate = $teamDetail['play_date'];
$playat = $teamDetail['play_at'];
$playersNum = $teamDetail['players_num'];

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
  <title>チーム内容変更</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
  <div class="container">
    <h1><?php echo h($teamName) ?>の内容変更</h1>
      <div class="formBox" style="text-align: center;">
        <form action="./team_update.php" method="post">
        <?php if (isset($err['sport'])): ?>
        <p class="validation"><?php echo $err['sport'];?></p><br>
        <?php endif; ?>
        <label>スポーツ:
        <select name="sport" id="sport">
          <?php
          foreach($sportsList as $sport){
            echo '<option value="', $sport,'">', $sport, '</option>';
          }
          ?>
        </select>
        </label><br><br>
        <?php if (isset($err['teamName'])): ?>
        <p class="validation"><?php echo $err['teamName'];?></p>
        <?php endif; ?>
        <label>チーム名:
        <input type="text" name="teamName" id="teamName" value="<?php echo h($teamName)?>">
        </label><br><br>
        <?php if (isset($err['playDate'])): ?>
        <p class="validation"><?php echo $err['playDate'];?></p>
        <?php endif; ?>
        <label>開催日:
        <input type="date" name="playDate" id="playDate" value="<?php echo h($playDate)?>">
        </label><br><br>
        <?php if (isset($err['playat'])): ?>
        <p class="validation"><?php echo $err['playat'];?></p>
        <?php endif; ?>
        <label>開催場所:
        <input type="text" name="playat" placeholder="開催地の住所を入力" id="playat" value="<?php echo h($playat)?>">
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
        <input type="hidden" name="id" value="<?php echo $id?>">
        <button class="buttonUnifiedSize" style="margin-right: 20px"><a href="./team_detail.php?id=<?php echo h($id);?>">戻る</a></button>
        <button type="submit" class="buttonUnifiedSize" style="margin-left: 20px">内容変更</button>
        </form>
      </div>
  </div>
</body>
</html>