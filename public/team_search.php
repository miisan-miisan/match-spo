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
          <option value="0">スポーツを選択</option>
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
            <option value="0">性別制限を選択</option>
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

        <!-- <label>開催場所<br>
        <input type="text" name="playat" placeholder="住所の一部を入力(例:大阪府)" id="playat">
        </label><br><br> -->

        <label>エリア<br>
        <select name="playat" id="select_prefecture" class="">
          <option value="">都道府県を選択</option>
          <option value="北海道" data-pref-id="01">北海道</option>
          <option value="青森県" data-pref-id="02">青森県</option>
          <option value="岩手県" data-pref-id="03">岩手県</option>
          <option value="宮城県" data-pref-id="04">宮城県</option>
          <option value="秋田県" data-pref-id="05">秋田県</option>
          <option value="山形県" data-pref-id="06">山形県</option>
          <option value="福島県" data-pref-id="07">福島県</option>
          <option value="茨城県" data-pref-id="08">茨城県</option>
          <option value="栃木県" data-pref-id="09">栃木県</option>
          <option value="群馬県" data-pref-id="10">群馬県</option>
          <option value="埼玉県" data-pref-id="11">埼玉県</option>
          <option value="千葉県" data-pref-id="12">千葉県</option>
          <option value="東京都" data-pref-id="13">東京都</option>
          <option value="神奈川県" data-pref-id="14">神奈川県</option>
          <option value="新潟県" data-pref-id="15">新潟県</option>
          <option value="富山県" data-pref-id="16">富山県</option>
          <option value="石川県" data-pref-id="17">石川県</option>
          <option value="福井県" data-pref-id="18">福井県</option>
          <option value="山梨県" data-pref-id="19">山梨県</option>
          <option value="長野県" data-pref-id="20">長野県</option>
          <option value="岐阜県" data-pref-id="21">岐阜県</option>
          <option value="静岡県" data-pref-id="22">静岡県</option>
          <option value="愛知県" data-pref-id="23">愛知県</option>
          <option value="三重県" data-pref-id="24">三重県</option>
          <option value="滋賀県" data-pref-id="25">滋賀県</option>
          <option value="京都府" data-pref-id="26">京都府</option>
          <option value="大阪府" data-pref-id="27">大阪府</option>
          <option value="兵庫県" data-pref-id="28">兵庫県</option>
          <option value="奈良県" data-pref-id="29">奈良県</option>
          <option value="和歌山県" data-pref-id="30">和歌山県</option>
          <option value="鳥取県" data-pref-id="31">鳥取県</option>
          <option value="島根県" data-pref-id="32">島根県</option>
          <option value="岡山県" data-pref-id="33">岡山県</option>
          <option value="広島県" data-pref-id="34">広島県</option>
          <option value="山口県" data-pref-id="35">山口県</option>
          <option value="徳島県" data-pref-id="36">徳島県</option>
          <option value="香川県" data-pref-id="37">香川県</option>
          <option value="愛媛県" data-pref-id="38">愛媛県</option>
          <option value="高知県" data-pref-id="39">高知県</option>
          <option value="福岡県" data-pref-id="40">福岡県</option>
          <option value="佐賀県" data-pref-id="41">佐賀県</option>
          <option value="長崎県" data-pref-id="42">長崎県</option>
          <option value="熊本県" data-pref-id="43">熊本県</option>
          <option value="大分県" data-pref-id="44">大分県</option>
          <option value="宮崎県" data-pref-id="45">宮崎県</option>
          <option value="鹿児島県" data-pref-id="46">鹿児島県</option>
          <option value="沖縄県" data-pref-id="47">沖縄県</option>
      </select>
      </label>
      <div style="display: flex; padding-top: 20px;">
        <button class="buttonUnifiedSize" style="margin-right: 20px"><a href="./join_team_mypage.php">戻る</a></button>
        <button type="submit" class="buttonUnifiedSize" style="margin-left: 20px">検索</button>
      </div>
      </form>
   </div>
 </div>
</body>
</html>