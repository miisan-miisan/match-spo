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

    <!-- <p>
      <label for="adress">住所</label><br>
        <?php if (isset($err['adress'])): ?>
        <p class="validation"><?php echo $err['adress']; ?></p>
        <?php unset($err['adress']);?>
        <?php endif; ?>
      <input type="text" name="adress" class="inputBox">
    </p> -->
    <label for="adress">住所</label><br>
    <table  style="margin: 0 auto; width: 100%;">
        <tbody>
            <tr>
              <?php if (isset($err['zipcode'])): ?>
              <p class="validation"><?php echo $err['zipcode']; ?></p>
              <?php unset($err['zipcode']);?>
              <?php endif; ?>
              <th style="font-weight: normal;">郵便番号</th>
              <td style="display: flex;">
                <input id="input" class="zipcode" type="text" name="zipcode" value="" placeholder="例) 8120012"
                style="display: block;">
                <button id="search" type="button" class="hover" style="display: block; margin: 0 auto; align-items: center; background-color: rgb(127, 214, 255); border: 1px solid white;
">住所検索</button>
                <p id="error"></p>
              </td>
            </tr>
            
            <tr style="width: 100%;">
              <?php if (isset($err['prefecture'])): ?>
              <p class="validation"><?php echo $err['prefecture']; ?></p>
              <?php unset($err['prefecture']);?>
              <?php endif; ?>
                <th style="font-weight: normal;">都道府県</th>
                <td><input id="address1" type="text" name="prefecture" value="" placeholder="郵便番号を入力すると選択できます。" style="width: 100%;"></td>
              </tr>
              
              <tr>
              <?php if (isset($err['address1'])): ?>
              <p class="validation"><?php echo $err['address1']; ?></p>
              <?php unset($err['address1']);?>
              <?php endif; ?>
              <th style="font-weight: normal;">市区町村</th>
              <td><input id="address2" type="text" name="address1" value="" placeholder="郵便番号を入力すると選択できます。" style="width: 100%;"></td>
            </tr>
            
            <tr>
              <?php if (isset($err['address2'])): ?>
              <p class="validation"><?php echo $err['address2']; ?></p>
              <?php unset($err['address2']);?>
              <?php endif; ?>
              <th style="font-weight: normal;">丁目/番地/号</th>
              <td><input id="address3" type="text" name="address2" value="" placeholder="郵便番号を入力すると選択できます。" style="width: 100%;"></td>
            </tr>
          </tbody>
        </table>
        
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
        <!-- 以下郵便番号から住所取得API -->
        <script src="https://cdn.jsdelivr.net/npm/fetch-jsonp@1.1.3/build/fetch-jsonp.min.js"></script>
        <script>
        let search = document.getElementById('search');
        search.addEventListener('click', ()=>{
          
          let api = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=';
            let error = document.getElementById('error');
            let input = document.getElementById('input');
      let address1 = document.getElementById('address1');
      let address2 = document.getElementById('address2');
      let address3 = document.getElementById('address3');
      let param = input.value.replace("-",""); //入力された郵便番号から「-」を削除
      let url = api + param;
      
      fetchJsonp(url, {
        timeout: 10000, //タイムアウト時間
      })
      .then((response)=>{
        error.textContent = ''; //HTML側のエラーメッセージ初期化
        return response.json();  
      })
      .then((data)=>{
        if(data.status === 400){ //エラー時
          error.textContent = data.message;
          }else if(data.results === null){
            error.textContent = '郵便番号から住所が見つかりませんでした。';
          } else {
            address1.value = data.results[0].address1;
            address2.value = data.results[0].address2;
            address3.value = data.results[0].address3;
          }
        })
        .catch((ex)=>{ //例外処理
          console.log(ex);
        });
      }, false);
      </script>
</html>