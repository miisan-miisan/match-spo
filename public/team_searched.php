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

if(isset($_SESSION['sport_or_sex']['sport'])){
  unset($_SESSION['sport_or_sex']['sport']);
}
if(isset($_SESSION['sport_or_sex']['allowedSex'])){
  unset($_SESSION['sport_or_sex']['allowedSex']);
}

$sportName = "";
$playDate = "";
$playat = "";

if(isset($_SESSION['enteredSport'])){
  $sportName = $_SESSION['enteredSport'];
  $playDate = $_SESSION['enteredPlayDate'];
  $playat = $_SESSION['enteredPlayat'];

  $allowedSex = 0;
  $allowedSex = $_SESSION['enteredAllowedSex'];

}

if(isset($_POST['sport'])){

  $sportName = $_POST['sport'];
  $playDate = $_POST['playDate'];
  $playat = $_POST['playat'];

  $allowedSex = 0;
  $allowedSex = $_POST['allowedSex'];

  // バリデーション
  if($sportName == "0"){
    $_SESSION['sport_or_sex']['sport'] = 'スポーツを選択してください。';
  }
  if($allowedSex == "0"){
    $_SESSION['sport_or_sex']['allowedSex'] = '性別制限を選択してください。';
  }

  if($sportName == "0" || $allowedSex == "0"){
    header("Location: ./team_search.php?playDate={$playDate}&playat={$playat}");
    return;
  }
}

$tempid = $_SESSION['login_user']['id'];
$userID = intval($tempid);

$searchedTeam = UserLogic::teamSearch($sportName, $playDate, $playat, $allowedSex);

if(isset($searchedTeam)){

  $teamIDs = array_column($searchedTeam, 'id');
  $sports = array_column($searchedTeam, 'sport_name');
  $teamNames = array_column($searchedTeam, 'team_name');
  $hostIDs = array_column($searchedTeam, 'host_id');
  $playDates = array_column($searchedTeam, 'play_date');
  $playsAt= array_column($searchedTeam, 'play_at');
  $playersNum = array_column($searchedTeam, 'players_num');

}

$_SESSION['enteredSport'] = $sportName;
$_SESSION['enteredPlayDate'] = $playDate;
$_SESSION['enteredPlayat'] = $playat;
$_SESSION['enteredAllowedSex'] = $allowedSex;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/mypage.css">
  <title>チーム検索結果</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
  <h1>チーム検索結果</h1>
  <?php if (count($teamIDs) == 0):?>
  <p class="validation"><?php echo '検索結果がありません！';?></p><br>
  <?php endif; ?>

  <div class="tableFlex">
    <div>

      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th></tr>
        <?php foreach ($sports as $sport):?>
          <tr>
            <td><?php echo $sport;?></td>
            <?php endforeach; ?>
          </tr>
        </table>
      </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>チーム名</th></tr>
          <?php foreach ($teamNames as $teamName):?>
            <tr>
              <td><?php echo $teamName;?></td>
              <?php endforeach; ?>
            </tr>
          </table>
        </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>開催日</th></tr>
          <?php foreach ($playDates as $playDate):?>
            <tr>
              <td><?php echo $playDate;?></td>
              <?php endforeach; ?>
            </tr>
          </table>
        </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>開催場所</th></tr>
          <?php foreach ($playsAt as $playat):?>
            <tr>
              <td><?php echo $playat;?></td>
              <?php endforeach; ?>
            </tr>
          </table>
        </div>
        <div>
          <table border="1" align="center" style="font-size: 18pt; ">   
            
            <tr><th>　　</th></tr>
            <?php foreach ($teamIDs as $teamID):?>
              <tr>
                <td><a href = "team_join_detail.php?id=<?php echo $teamID;?>" class="teamDetailLink">詳細</a></td>
                <?php endforeach; ?>
              </tr>
            </table>
          </div>
          </div>
  <button class="buttonUnifiedSize"><a href="./team_search.php">戻る</a></button>


</div>
</body>
</html>