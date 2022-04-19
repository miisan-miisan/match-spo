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

// 参加しているチーム一覧
$userID = $_SESSION['login_user']['id'];

$joiningTeamList = UserLogic::joiningTeamList($userID);

  if(isset($joiningTeamList[0])){


    $sports = array_column($joiningTeamList, 'sport_name');
    $teamNames = array_column($joiningTeamList, 'team_name');
    $playDates = array_column($joiningTeamList, 'play_date');
    $teamIDs = array_column($joiningTeamList, 'team_id');
  
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
  <title>参加側マイページ</title>
</head>

<?php 
        require_once('./header_after_login.php'); 
?>

<body>
<div class="container" style="text-align: center;">
  <h1><?php echo h($_SESSION['login_user']['name']) ?>さんが参加予定のチーム一覧</h1>
  <div class="tableFlex">
    <div>
      <table border="1" align="center" style="font-size: 18pt; ">
        <tr><th>スポーツ</th></tr>
          <tr>
            <?php if(isset($joiningTeamList[0])):?>
              <?php foreach($sports as $sport):?>
              <tr>
                  <td><?php echo $sport;?></td>
                  <?php endforeach;?>
                  <?php endif;?>
              </tr>
          </tr>
        </table>
      </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>チーム名</th></tr>
          <tr>
          <?php if(isset($joiningTeamList[0])):?>
            <?php foreach($teamNames as $teamName):?>
            <tr>
              <td><?php echo $teamName;?></td>
              <?php endforeach;?>
              <?php endif;?>
            </tr>
          </tr>
        </table>
      </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>開催日</th></tr>
          <tr>
            <?php if(isset($joiningTeamList[0])):?>
              <?php foreach($playDates as $playDate):?>
              <tr>
                  <td><?php echo $playDate;?></td>
                  <?php endforeach;?>
                  <?php endif;?>
              </tr>
          </tr>
        </table>
      </div>
      <div>
        <table border="1" align="center" style="font-size: 18pt; ">   
          <tr><th>　　</th></tr>
              <tr>
                <?php if(isset($joiningTeamList[0])):?>
                <?php foreach($teamIDs as $teamID):?>
                <tr>
                  <td><a href = "detailed_join_team.php?id=<?php echo $teamID;?>" class="teamDetailLink">詳細</a></td>
                  <?php endforeach;?>
                  <?php endif;?>
                </tr>
              </tr>
        </table>
      </div>
    </div>
  <a href="./team_search.php" class="newTeamLink">近くのチームを探す</a><br>
</div>
<a href="./host_mypage.php" style="display: block; float: right; margin-right: 50px; text-decoration: underline;   color: #0F0AD1;">ホスト側はこちら</a>
</body>
</html>