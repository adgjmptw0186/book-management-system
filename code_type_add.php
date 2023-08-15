<?php
//関数の呼び出し元を指定
require_once 'utility.php';

//var_dump($_POST);

//-----------------------isert処理----------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  //formが空のまま更新したとき何もしない処理
  if ($_POST["codeType"] == "" || $_POST["Code"] == "") {
    header("Location:code_type_resist.php"); //リロードで再入力防ぐ&指定ページに戻る※
    exit();
  }


  //------------------コード重複チェック-----------------------
  //DBからコード区分とコードを持ってくる処理
  $sql = "SELECT count(code_type)as row_count from code_types where code_type = {$_POST["codeType"]} and code = {$_POST["Code"]}";
  $codetype_data = FuncSelectSql($sql);

  //$row = $this_code_data->fetch()でrowに$codetype_dataをいれる
  //SQLで重複する行数をカウントして0なら重複なし、1なら重複ありで条件を分岐する
  $row = $codetype_data->fetch();


  if ($row["row_count"] == 1) { //rowの中身あり
    echo "<script> alert('コードが重複しています') </script>";


  } else if ($row["row_count"] == 0) { //中身なし

    //------------------insertの実行---------------------------
    $insert_sql = 'INSERT INTO code_types VALUES ("' . $_POST["codeType"] . '", "' . $_POST["Code"] . '", "' . $_POST["codeName"] . '")';
    FuncSelectSql($insert_sql);

    header("Location:code_type_resist.php"); //リロードで再入力防ぐ&指定ページに戻る※
    exit();

  }

}

?>

<!--------------------以下HTML ----------------------------------->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>コード新規登録</title>




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


</head>



<body>

  <h1>コード追加</h1>


  <!--   <?php
  $data = $_GET["data"];

  echo $data[0];
  echo $data[1];

  $code_type = $data[0];

  ?> -->


  登録フォーム
  <form action="" method="post" onsubmit="return check()">

    <?php
    echo '<p>区分：<input type="number" name="codeType" value="' . $code_type . '" size="40"></p>';
    ?>
    <p>コード：<input type="number" name="Code" size="40"></p>
    <p>名称：<input type="text" name="codeName" size="40"></p>
    <button type="submit">登録</button>

  </form>





</body>

</html>