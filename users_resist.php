<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>利用者登録</title>
</head>

<body>
<?php
require('../common/utility.php');
FuncCheckSession(1);
//$user = FuncSelectSql('select * from users');

//初期値
$label = "追加";
$user_number = "";
$user_name = "";
$sex_type = "";
$school_year = "";
$use_type = "";
$password = "";
$user_type = "";

//追加/更新ラベルの確認
if(!empty($_POST["label"])){//ラベルがあればそれを受け取る
  $label = $_POST["label"];
}

//formに入力されたデータを取得
if(!empty($_POST['user_number'])){$user_number = $_POST['user_number'];}else{$user_number = null;}
if(!empty($_POST['user_name'])){$user_name = $_POST['user_name'];}
if(!empty($_POST[3])){$sex_type = $_POST[3];}
if(!empty($_POST[4])){$school_year = $_POST[4];}
if(!empty($_POST[2])){$use_type = $_POST[2];}
if(!empty($_POST['password'])){$password = $_POST['password'];}
if(!empty($_POST['区分'])){$user_type = $_POST['区分'];}


//検索ボタンが押されたら
if (!empty($_POST['search']) && !empty($_POST['user_number'])) {
  if(!empty($_POST[2])){$use_type = $_POST[2];}else{$use_type=0;}
  if(!empty($_POST['区分'])){$user_type = $_POST['区分'];}else{$user_type=0;}
  $user_id = $_POST['user_number'];
  $useridsql = "select * from users where user_number = {$user_id}";
  $userid = FuncSelectSql($useridsql);
  $row = $userid->fetch();
  if(!empty($row)){ // useridがuserテーブルにあったら
    $label = "更新";
    $user_number = $row['user_number'];
    $user_name = $row['user_name'];
    $sex_type = $row['sex_type'];
    $school_year = $row['school_year'];
    $use_type = $row['use_type'];
    $password = $row['password'];
    $user_type = $row['user_type'];
  }else{
    //初期値
    $label = "追加";
    $user_name = "";
    $sex_type = "";
    $school_year = "";
    $use_type = "";
    $password = "";
    $user_type = "";
  }
}

// 登録ボタンが押されたら
if(!empty($_POST['submit']) && !empty($_POST['user_number'])){
  if(empty($use_type)){$use_type=0;}
  if(empty($user_type)){$user_type=0;}
  $sql3=
"INSERT INTO users ( user_number, user_name, sex_type, school_year, use_type, `password`,user_type) VALUES (
{$user_number},'{$user_name}',{$sex_type},{$school_year},{$use_type},'{$password}',{$user_type});
";

$sql2=
"UPDATE users SET user_name = '{$user_name}', sex_type = {$sex_type}, school_year = {$school_year},
use_type = {$use_type}, `password` = '{$password}' ,user_type = {$user_type} where user_number = {$user_number}";

if($label=="追加"){
  if(FuncExecuteSql($sql3)){
    echo "追加しました";
  }else{
    echo "追加に失敗しました";
    //echo $sql3;
  }
}else if($label=="更新"){
  if(FuncExecuteSql($sql2)){
      echo "更新しました";
  }else{
      echo "更新に失敗しました";
  }
}
}
//$booksql = "select * from users";
//$book = FuncSelectSql($booksql);

?>
  <h1>利用者登録</h1>
  <!-- データ入力フォーム -->
  <form method="post">
    <table>
      <h3><?php echo $label; ?></h3>
      <tr>利用者内容</tr>
        <br><br>
      <tr>利用者番号</tr>

        <input type="number" required name="user_number" size="20" value=<?php echo $user_number; ?>>
        <input type="hidden" name="label" value=<?php echo $label; ?>>
        <input type="submit" name="search" value="検索"  >
        <?php
        //echo $alert;  
        ?>
        <br>
      <tr>氏名</tr>
      <tr>
        <input type="text" maxlength="30" name="user_name" placeholder="氏名を入力" size="20" value=<?php echo $user_name; ?>></tr>
        <br>
      <tr>性別</tr>
      <tr>
        <?php FuncMakePulldown(3); echo $sex_type; ?>
      </tr>

        <br>
      <tr>学年</tr>
      <tr>
      <?php FuncMakePulldown(4); echo $school_year; ?>
      </tr>
        <br>
      <tr>利用可否フラグ</tr>
      <tr>
      <?php FuncMakePulldown(2); echo $use_type; ?>
      </tr>
        <br>
      <tr>パスワード</tr>
      <tr>
        <input style="ime-mode:disabled" type="password" name="password" placeholder="パスワードを入力" size="15" value=<?php echo $password; ?>></tr>
        <br>
      <tr>区分</tr>
      <tr>
        <select name="区分">
          <option selected disabled hidden style='display: none' value='user_type' ></option>
          <option value="0">0:一般</option>
          <option value="1">1:窓口</option>
        </select>
        <?php echo $user_type; ?>
      </tr>
    </table>
    <br>
    <tr>
      <input class="Bl_button" type="reset" value="クリア" onclick="return confirm('画面をクリアしますか？');" />
      <input class="B2_button" type="submit" name="submit" value="登録" onclick="return confirm('登録しますか？');" />
      <input class="B3_button" type="button"
        onclick="var ok=confirm('窓口管理メニューに戻りますか？');if (ok) location.href='/apps/common/menu.php';return false;"
        value="戻る" />
    </tr>

    <?php
    // if (!empty($_POST["user_number"])) {
    //   $user_id = $_POST['user_number'];
    //   $user_name = $_POST["user_name"];
    //   $sex_type = $_POST["性別"];
    //   $school_year = $_POST["学年"];
    //   $use_type = $_POST["利用可否フラグ"];
    //   $user_pass = $_POST["password"];
    //   $user_kubun = $_POST["区分"];
    //   $users = ("insert into library_test.users(user_number,user_name,sex_type,school_year,use_type,password,user_type) values ('{$user_id}','{$user_name}','{$sex_type}','{$school_year}','{$use_type}','{$user_pass}','{$user_kubun}');");
    //   $book = FuncExecuteSql($users);
    //   // $aaaaaa = 100022;
    //   // $users = ("insert into library_test.users(user_number,user_name,sex_type,school_year,use_type,password,user_type) values ('{$aaaaaa}','user5',1,2,9,'pass5',0);");
    //   // $book = FuncExecuteSql($users);
    // }
    ?>

  </form>

</body>

</html>