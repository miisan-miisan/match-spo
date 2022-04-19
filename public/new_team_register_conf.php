<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// ページ遷移後セッションが消えるため再生成
$userid = $_SESSION['login_user']['id'];
$userName = $_SESSION['login_user']['name'];


$result = UserLogic::checkLogin();

if(!$result){
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください!';
  header('Location: ./user_register.php');
  return;
}




// 新規チーム登録内容バリデーション
$err = [];

if(filter_input(INPUT_POST, 'sport') == 0){
  $err['sport'] = 'スポーツを選択してください。';
}
if(filter_input(INPUT_POST, 'allowedSex') == 0){
  $err['allowedSex'] = '性別制限を選択してください。';
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

if(count($err) > 0){
  // エラーがあった場合は戻す
  $_SESSION = $err;
  header("Location: ./new_team_register.php?userid={$userid}&userName={$userName}");
  return;
}

// ログインユーザ情報

// スポーツ一覧
$sportsList = UserLogic::sportsList();

$allowedSexNum= $_POST['allowedSex'];
if($allowedSexNum == 1){
  $allowedSex = "男女混合";
}else if($allowedSexNum == 2){
  $allowedSex = "男子のみ";
}else{
  $allowedSex = "女子のみ";
}

intval($_POST['allowedSex']);





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
  <title>新規チーム登録確認</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
  <div class="container">
    <h1>新規チーム登録内容確認</h1>
    <p>この内容でチームを作成します。</p>
    <div class="formBox" style="text-align: center;">
    <form action="./new_team_register_comp.php" method="post">
      <label>スポーツ:
        <input type="text" name="sport" id="sport" value="<?php echo $_POST['sport'];?>" style=border:none; readonly>
      </label><br><br>
      <label>性別制限:
        <input type="hidden" name="allowedSex" id="allowedSex" value="<?php echo intval($_POST['allowedSex']);
;?>" style=border:none; readonly>
        <input type="text" name="allowedSexDisplay" id="allowedSexDisplay" value="<?php echo $allowedSex;?>" style=border:none; readonly>
      </label><br><br>
      <label>チーム名:
      <input type="text" name="teamName" id="teamName" value="<?php echo $_POST['teamName'];?>" style=border:none; readonly>
    </label><br><br>
    <label>開催日:
      <input type="date" name="playDate" id="playDate" value="<?php echo $_POST['playDate'];?>" style=border:none; readonly>
    </label><br><br>
    <label>開催場所:
      <input type="text" name="playat" placeholder="開催地の住所を入力" id="playat" value="<?php echo $_POST['playat'];?>" style=border:none; readonly>
    </label><br><br>
      <label>募集人数:
      <input type="text" name="playersNumber" id="playersNumber" value="<?php echo $_POST['playersNumber'];?>" style=border:none; readonly>
      </label><br><br>
      <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
      <button type="button" class="buttonUnifiedSize" style="margin-right: 20px" onclick=history.back()>戻る</button>
      <button type="submit" class="buttonUnifiedSize" style="margin-left: 20px">登録</button>
    </form>
    </div>
  </div>
</body>
</html>