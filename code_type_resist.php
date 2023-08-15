<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>コード区分マスタ</title>

  <?php
  //関数の呼び出し�??を指�?
  require_once 'utility.php';

  //DBから�?目を引っ張ってくる�?$codetype_dataに�?れる
  $codetype_data = FuncSelectSql('select * from code_types');
  ?>


</head>

<body>

  <h1>コード区分マスタ</h1>
  <table border="1">
    <tr>
      <th>区分</th>
      <th>コード</th>
      <th>名称</th>
      <th>--</th>


    </tr>

    <?php
    //
    while ($row = $codetype_data->fetch()) {

      //コード区�?�?ーブルを生�?
      echo  " <tr>";
      echo "<th>" . $row['code_type'] . "</th>";
      echo "<th>" . $row['code'] . "</th>";
      echo "<th>" . $row['code_name'] . "</th>";


      //次ペ�?�ジへのリンクを�?�れる
      switch ($row['code_type']) {

          //修正リンクからコード区�?2,3(利用フラグと性別)を除�?
        case 2:
          break;

        case 3:
          break;


        default:
          echo '<th><a href="code_type_update.php?data[0]='
            . $row['code_type'] . '&data[1]=' . $row['code'] . '">修正</a>';

          break;
      }

      echo  " </tr>";
    } ?>


  </table>

<button onclick="location.href='menu.php'">メニューに戻る</button>




</body>

</html>