<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>コード新規登録</title>

  <?php
  //関数の呼び出し元を指定
  require_once 'utility.php';
  //DBから項目を引っ張ってくる⇒$codetype_dataにいれる
  $codetype_data = FuncSelectSql('select * from code_types');
  ?>

</head>

<body>

  <h1>コード新規登録</h1>


  <?php
  $data = $_GET["data"];

  echo $data[0];
  echo $data[1];

  ?>


  登録フォーム
  <form action="cgi-bin/formmail.cgi" method="post">

    <p>区分：<input type="text" name="codeType" size="40"></p>
    <p>コード：<input type="text" name="codeType" size="40"></p>
    <p>名称：<input type="text" name="codeType" size="40"></p>
    <button type="submit">更新</button>

  </form>




</body>

</html>