<?php

require_once '../dbconnect.php';

class UserLogic{

  /**
   * ユーザを登録する
   * @param array $userData
   * @return bool $result
   */
  public static function createUser($userData){
    $return = false;
    
    $sql = 'INSERT INTO users (name, email, password, created_at, sex, zip_code, prefecture, address1, address2) VALUES(?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)';

    // ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $userData['name'];
    $arr[] = $userData['email'];
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);
    $arr[] = $userData['sex'];
    $arr[] = $userData['zipcode'];
    $arr[] = $userData['prefecture'];
    $arr[] = $userData['address1'];
    $arr[] = $userData['address2'];

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }
  }
  
  /**
   * ログイン処理
   * @param array $email
   * @param array $password
   * @return bool $result
   */
  public static function login($email, $password){
    // 結果
    $result = false;
    // ユーザをemailから検索して取得
    $user = self::getUserByEmail($email);

    if(!$user){
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;
    }

    // パスワードの照会
    if(password_verify($password, $user['password'])){
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }

      $_SESSION['msg'] = 'パスワードが一致しません。';
      return $result;

    
  }
  
  /**
   * emailからユーザを取得
   * @param array $email
   * @return array|bool $user|false
   */
  public static function getUserByEmail($email){
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    
    $return = false;
    
    $sql = 'SELECT * FROM users WHERE email = ?';
    
    // emailを配列に入れる
    $arr = [];
    $arr[] = $email;
    
    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    }catch(\Exception $e){
      return $result;
    }
  }

    /**
   * 性別【男女】を配列に入れる
   * @param array $email
   * @return array|bool $user|false
   */
  public static function getSex(){
    
    $return = false;
    
    $sql = 'SELECT sex FROM sex';
    
    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute();
      // SQLの結果を返す
      $sex = $stmt->fetchAll(PDO::FETCH_COLUMN);
      return $sex;
    }catch(\Exception $e){
      return $result;
    }
  }


    /**
   * emailと名前でユーザチェック（パスワード再発行用）
   * @param array $email
   * @return array|bool $user|false
   */
  public static function getUserByEmail_Pass($userName, $email){
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    
    $return = false;
    
    $sql = 'SELECT * FROM users WHERE name = ? AND email = ?';
    
    // emailを配列に入れる
    $arr = [];
    $arr[] = $userName;
    $arr[] = $email;
    
    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    }catch(\Exception $e){
      return $result;
    }
  }

      /**
   * パスワードを再設定する
   * @param array 
   * @return bool $result
   */
  public static function newPassword($password, $email){
    $return = false;
    
    $sql = 'UPDATE users SET password = ? WHERE email = ?';

    // ユーザデータを配列に入れる
    $arr = [];
    $arr[] = password_hash($password, PASSWORD_DEFAULT);
    $arr[] = $email;
    
    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }
  }

  
  /**
   * ログインチェック
   * @param void
   * @return bool $result
   */
  public static function checkLogin(){
    $result = false;

    // セッションにログインユーザが入っていなかったらfalse
    if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
      return $result = true;
    }

    return $result;
  }
  
  /**
   * ログアウト処理
   */
  public static function logout(){
    $_SESSION = array();
    session_destroy();
  }

  /**
   * スポーツ一覧取得
   */
  public static function sportsList(){

    $sql = 'SELECT sport_name FROM sports';
    
    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute();
      // SQLの結果を返す
      $sports = $stmt->fetchAll(PDO::FETCH_COLUMN);
      return $sports;
    }catch(\Exception $e){
      return $result;
    }
  }

    /**
   * 新規チームを登録する
   * @param array 
   * @return bool $result
   */
  public static function createNewTeam($newTeam){
    $return = false;
    
    $sql = 'INSERT INTO teams (sport_name, team_name, host_id, play_date, play_at, players_num, created_at, allowed_sex) VALUES(?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?)';

    // チームデータを配列に入れる
    $hostID = $_SESSION['login_user']['id'];

    $arr = [];
    $arr[] = $newTeam['sport'];
    $arr[] = $newTeam['teamName'];
    $arr[] = $hostID;
    $arr[] = $newTeam['playDate'];
    $arr[] = $newTeam['playat'];
    $arr[] = $newTeam['playersNumber'];
    $arr[] = $newTeam['allowedSex'];
  

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }

  }


   /**
   * ホストしているチーム一覧
   * @param array 
   * @return bool $result
   */
  public static function hostingTeam(){
    $return = false;
    
    $sql = 'SELECT * FROM teams WHERE host_id = ?';

    $arr = [];
    $hostID = $_SESSION['login_user']['id'];
    $arr[] = $hostID;
  

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $hostingTeams = $stmt->fetchAll();
      return $hostingTeams;
    }catch(\Exception $e){
      return $result;
    }

  }

     /**
   * チーム詳細
   * @param array 
   * @return bool $result
   */
  public static function teamDetail($id){
    $return = false;
    
    $sql = 'SELECT * FROM teams LEFT OUTER JOIN users ON teams.host_id = users.id WHERE teams.id = ?';

    $arr = [];
    $arr[] = $id;
  

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $selectedTeam = $stmt->fetch();
      return $selectedTeam;
    }catch(\Exception $e){
      return $result;
    }

  }

    /**
   * チーム内容を更新する
   * @param array 
   * @return bool $result
   */
  public static function teamUpdate(){
    $return = false;
    
    $sql = 'UPDATE teams SET sport_name = ?, team_name = ?, play_date = ?, play_at = ?, players_num = ? WHERE id = ?';

    // ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $_POST['sport'];
    $arr[] = $_POST['teamName'];
    $arr[] = $_POST['playDate'];
    $arr[] = $_POST['playat'];
    $arr[] = $_POST['playersNumber'];
    $arr[] = $_POST['id'];


    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }
  }

      /**
   * チームを削除する
   * @param array 
   * @return bool $result
   */
  public static function teamDelete($id){
    $return = false;
    
    $sql = 'DELETE FROM teams WHERE id = ?';

    $arr = [];
    $arr[] = $id;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }
  }

        /**
   * チームを検索する
   * @param array 
   * @return bool $result
   */

  public static function teamSearch($sportName, $playDate, $playat, $allowedSex){

    $sql = 'SELECT * FROM teams WHERE sport_name = ? AND (play_date = ? OR play_at LIKE ?) AND allowed_sex LIKE ?';

    $playAt = "%".$playat."%";
    $allowed_sex = "%".$allowedSex."%";

    $arr = [];
    $arr[] = $sportName;
    $arr[] = $playDate;
    $arr[] = $playAt;
    $arr[] = $allowed_sex;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $searchedTeam = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $searchedTeam;
    }catch(\Exception $e){
      return $result;
    }
  }

     /**
   * チームに参加する
   * @param array 
   * @return bool $result
   */
  public static function joinTeam($id, $userName, $userID){
    $return = false;
    
    $sql = 'INSERT INTO team_members (team_id, user_name, user_id) VALUES(?, ?, ?)';

    // チームデータを配列に入れる

    $arr = [];
    $arr[] = $id;
    $arr[] = $userName;
    $arr[] = $userID;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }

  }
          /**
   * 参加しているチームのid情報を出力する
   * @param array 
   * @return bool $result
   */

  public static function joiningTeamID($userID){

    $sql = 'SELECT team_id FROM team_members WHERE user_id = ?';

    $arr = [];
    $arr[] = $userID;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $joiningTeamIDs = $stmt->fetch();
      return $joiningTeamIDs;
    }catch(\Exception $e){
      return $result;
    }
  }

     /**
   * 参加しているチーム情報
   * @param array 
   * @return bool $result
   */
  public static function joiningTeam($joiningTeamID){
    $return = false;
    
    $sql = 'SELECT * FROM teams WHERE id = ?';

    $arr = [];
    $arr[] = $joiningTeamID;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $joiningTeam = $stmt->fetch();
      return $joiningTeam;
    }catch(\Exception $e){
      return $result;
    }

  }

        /**
   * チームの参加をキャンセルする
   * @param array 
   * @return bool $result
   */
  public static function joinedTeamCancel($id, $userID){
    $return = false;
    
    $sql = 'DELETE FROM team_members WHERE team_id = ? AND user_id = ?';

    // ユーザデータを配列に入れる
    $arr = [];
    $arr[] = $id;
    $arr[] = $userID;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    }catch(\Exception $e){
      return $result;
    }
  }

       /**
   * 現状の参加人数
   * @param array 
   * @return array $memberNum
   */
  public static function memberNum($id){
    $return = false;
    
    $sql = 'SELECT count(team_id) FROM team_members WHERE team_id = ?';

    $arr = [];
    $arr[] = $id;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $memberNum = $stmt->fetch(PDO::FETCH_COLUMN);
      return $memberNum;
    }catch(\Exception $e){
      return $result;
    }
  }

   /**
   * メールアドレスが既に登録されているかのバリデーション
   * @param array 
   * @return bool $result
   */

  public static function emailCheck($email){

    $sql = 'SELECT count(email) FROM users WHERE email = ?';

    $arr = [];
    $arr[] = $email;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $emailCheck = $stmt->fetch(PDO::FETCH_COLUMN);
      return $emailCheck;
    }catch(\Exception $e){
      return $result;
    }
  }

     /**
   * 参加しているチーム情報
   * @param array 
   * @return bool $result
   */
  public static function joiningTeamList($userID){
    $return = false;
    
    $sql = 'SELECT * FROM teams LEFT OUTER JOIN team_members ON teams.id = team_members.team_id WHERE team_members.user_id = ?';

    $arr = [];
    $arr[] = $userID;

    try{
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの結果を返す
      $joiningTeamList = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $joiningTeamList;
    }catch(\Exception $e){
      return $result;
    }

  }
  

}