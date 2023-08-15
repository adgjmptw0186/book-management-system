<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charaset=UTF-8">
<title>図書館利用者＆書籍ランキング</title>
<link rel="stylesheet" href="style.css">

<?php
require_once '../common/utility.php';
FuncCheckSession(0);
$sql = "select
rank() over(order by count(*) desc) as `rank`
,user_name
,a.code_name as gender
,b.code_name as school_year
,count(*) as count
from
library_test.users as u,library_test.reception_list as r
,(select code_types.code,code_name from code_types where code_type = 3) as a
,(select code_types.code,code_name from code_types where code_type = 4) as b
where u.user_number = r.lending_user_number
and u.sex_type = a.code
and u.school_year = b.code
group by user_name,a.code_name,b.code_name
order by count(*) desc"
;
$user_rank = FuncSelectSql($sql);

$sql = "select
rank() over(order by count(*) desc) as `rank`
,count(*) as count
,a.code_name as category
,b.book_number as book_number
,book_name
,author
from
library_test.books as b,library_test.reception_list as r
,(select code_types.code,code_name from library_test.code_types where code_type = 1) as a
where b.book_number = r.book_number
and b.category = a.code
group by a.code_name,book_number,book_name,author
order by count(*) desc"
;
$book_rank = FuncSelectSql($sql);

?>
<script language="javascript" type="text/javascript">
    function back_pop(){
        if(confirm("戻りますか？")){
           // window.location.href = "/apps/book-management/books_regist_confirm.php";
           window.location.href = "/apps/book-management/books_list.php";
        }
    }
</script>
<script language="javascript" type="text/javascript">
    function back2_pop(){
        if(confirm("戻りますか？")){
           // window.location.href = "/apps/book-management/books_regist_confirm.php";
           window.location.href = "/apps/common/menu.php";
        }
    }
</script>

</head>
<body>
 <table align="center" border="1">
 <input type="submit" name="submit" value="戻る" onclick ="back_pop();">
 <input type="submit" name="submit" value="メニューに戻る" onclick ="back2_pop();">
    <h1  align="center">利用者ランキング</h1>
    <?php
    ?>
    <tr align="center">
        <br>
      <th>順位</th>
      <th>　　氏名　　</th>
      <th>性別</th>
      <th>　学年　</th>
      <th>カウント</th>
    </tr>

    <?php
    while ($row = $user_rank->fetch()) {

      echo "<tr>";
      echo "<th>" . $row['rank'] . "位</th>";
      echo "<th>" . $row['user_name'] . "</th>";
      echo "<th>" . $row['gender'] . "</th>";
      echo "<th>" . $row['school_year'] . "</th>";
      echo "<th>" . $row['count'] . "</th>";
      echo "</tr>";
    }
    ?>
  </table>

  <br></br>
  <table align="center" border="1">
    <h1 align="center">書籍ランキング</h1>
    <tr align="center">
        <br>
      <th>順位</th>
      <th>カウント(回)</th>
      <th>カテゴリ</th>
      <th>書籍番号</th>
      <th>　　　　タイトル　　　　</th>
      <th>　　著者　　</th>
    </tr>

    <?php
    while ($row = $book_rank->fetch()) {

      echo "<tr>";
      echo "<th>" . $row['rank'] . "位</th>";
      echo "<th>" . $row['count'] . "</th>";
      echo "<th>" . $row['category'] . "</th>";
      echo "<th>" . $row['book_number'] . "</th>";
      echo "<th>" . $row['book_name'] . "</th>";
      echo "<th>" . $row['author'] . "</th>";
      echo "</tr>";
    }
    ?>
  </table>
</body>
</html>