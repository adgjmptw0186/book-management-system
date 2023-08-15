<?php
//関数の呼び出し元を指定
require_once 'utility.php';

//var_dump($_POST);

$data = $_GET["data"];

//echo $data[0];
//echo $data[1];

//-----------------------------------------------------------------

//DBから項目を引っ張ってくる⇒$codetype_dataにいれる
$sql = 'SELECT * FROM code_types WHERE code_type =' . $data[0] . ' AND code =' . $data[1];
$this_code_data = FuncSelectSql($sql);



//$row = $this_code_data->fetch()でrowに$codetype_dataをいれる※これしないと取り出せない
if ($row = $this_code_data->fetch()) {

  //さらに変数に代入
  $codetype = $row['code_type'];
  $code = $row['code'];
  $codename = $row['code_name'];
} else {
  echo 'リンクが正しくありません';
  //エラーデス
}


//-----------------------update処理----------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  //formが空のまま更新したとき何もしない処理
  if ($_POST["codeType"] == "" || $_POST["Code"] == "") {
    header("Location:code_type_resist.php"); //リロードで再入力防ぐ&指定ページに戻る※
    exit();
  }


  //------------------コード重複チェック-----------------------
  //DBからコード区分とコードを持ってくる処理
  //$sql = "SELECT count(code_type)as row_count from code_types where code_type = {$_POST["codeType"]} and code = {$_POST["Code"]}";
  //$codetype_data = FuncSelectSql($sql);

  //$row = $this_code_data->fetch()でrowに$codetype_dataをいれる
  //SQLで重複する行数をカウントして0なら重複なし、1なら重複ありで条件を分岐する
  //$row = $codetype_data->fetch();


  //if ($row["row_count"] == 1) { //rowの中身あり
  // echo "<script> alert('コードが重複しています') </script>";


  // } else if ($row["row_count"] == 0) { //中身なし

  //------------------updateの実行---------------------------

  $codeTypeIn = $_POST["codeType"];
  $codeIn = $_POST["Code"];
  $codeNameIn = $_POST["codeName"];



  $update_sql2 = "UPDATE code_types SET code_type = " . $codeTypeIn . ", code = " . $codeIn . ", code_name = '" . $codeNameIn . "' WHERE code_type =" . $codetype . " AND code =" . $code;
  FuncExecuteSql($update_sql2);

  header("Location:code_type_resist.php"); //リロードで再入力防ぐ&指定ページに戻る※
  exit();

  //}

}

?>

<!--------------------以下HTML ----------------------------------->









<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>コード修正</title>



  <!--フォーム登録ボタン押したときに確認アラート表示-->
  <script type="text/javascript">

    function check() {

      if (window.confirm('登録してよろしいですか？')) {
        return true; // 「OK」時は「5：insert処理」を実行

      }
      else { // 「キャンセル」時の処理
        //window.alert('キャンセルされました'); 
        return false; // 送信を中止

      }
    }

  </script>


  <?php

  //関数の呼び出し元を指定
  //require_once 'utility.php';
  


  //------------------getで前のページのを持って生きたことを確認--------
  

  ?>

</head>

<body>

  <h1>コード修正</h1>







  修正フォーム

  <form action="" method="post" onsubmit="return check()">

    <?php
    echo '<p>区分：<input type="number" name="codeType" value="' . $codetype . '" size="40"></p>';
    echo '<p>コード：<input type="number" name="Code" value="' . $code . '" size="40"></p>';
    echo '<p>名前：<input type="text" name="codeName" value="' . $codename . '" size="40"></p>';
    echo '<button type="submit">更新</button>';

    ?>
  </form>




  <!-------//追加のリンク。次のページにコード区分だけ飛ばす-------------->
  <?php

  echo '<th><a href="code_type_add.php?data[0]='
    . $row['code_type'] . '&data[1]=' . $row['code'] . '">追加</a>';
  ?>




</body>

</html>