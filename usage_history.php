<?php
require('../common/utility.php');
FuncCheckSession(1);

$user_id = $_GET['user_number'];
$usersql = "select * from users where user_number = '{$user_id}'";
$user = FuncSelectSql($usersql);

$receptionsql = "select * from library_test.reception_list as lr inner join library_test.books as lb ON lr.book_number = lb.book_number where lending_user_number = '{$user_id}' order by lending_date desc;";
$reception = FuncSelectSql($receptionsql);

$receptioncntsql = "select count(*) as cnt from library_test.reception_list as lr inner join library_test.books as lb ON lr.book_number = lb.book_number where lending_user_number = '{$user_id}';";
$receptioncnt = FuncSelectSql($receptioncntsql);

$booksql = "select * from books";
$book = FuncSelectSql($booksql);

$alert = "<script type='text/javascript'>
  if(confirm('無効な利用者番号です')){
    history.back();
  } else {
    window.close();
  };
  </script>";

$return = "<script type='text/javascript'>
  history.back();
</script>";

foreach ($receptioncnt as $receptioncnts):
  $cnt = $receptioncnts['cnt'];
endforeach

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>利用者履歴状況</title>
</head>
<style>
  .t {
    display: inline-block;
  }

  .h {
    vertical-align: top;
  }

  .sp {
    position: relative;
    right: px;
  }
</style>

<body>
  <?php foreach ($user as $users): ?>
    <table class="sp">
      <tr>
        <th align="right">利用者番号</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['user_number'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">氏名</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['user_name'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">性別</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['sex_type'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">学年</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['school_year'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">利用可否フラグ</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['use_type'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">パスワード</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['password'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right">区分</th>
        <th align="left">　
          <?php echo htmlspecialchars($users['user_type'], ENT_QUOTES); ?>
        </th>
      </tr>
      <tr>
        <th align="right"><br>これまでに借りた冊数</th>
        <th align="left"><br>　
          <?php echo $cnt; ?>
        </th>
      </tr>
    </table>
  <?php endforeach ?>
  <b class="h sp"><br>　 　借りた本のリスト</b>
  <table class="t" border="1" style="border-collapse: collapse">
    <tr>
      <th>期間</th>
      <th>タイトル</th>
      <th>カテゴリ</th>
      <th>著者</th>
    </tr>
    <?php foreach ($reception as $receptions): ?>

        <tr>
          <th>
            <?php echo htmlspecialchars($receptions['lending_date'], ENT_QUOTES);
            echo "~";
            echo htmlspecialchars($receptions['return_date'], ENT_QUOTES);
            ?>
          </th>
          <th>
            <?php echo htmlspecialchars($receptions['book_name'], ENT_QUOTES); ?>
          </th>
          <th>
            <?php echo htmlspecialchars($receptions['category'], ENT_QUOTES); ?>
          </th>
          <th>
            <?php echo htmlspecialchars($receptions['author'], ENT_QUOTES); ?>
          </th>
        </tr>
      <?php endforeach ?>

  </table>
  <?php

  //echo $alert;
  //echo "<script type='text/javascript'>if(!alert('無効な利用者番号です');</script>";
  //echo "<script type='text/javascript'>alert('無効な利用者番号です');</script>";
  //echo "<script type='text/javascript'>window.close();</script>";
  ?>
  <br>
  <button type="button" onclick="location.href='/apps/user-management/users_list.php'">利用者検索ページへ戻る</button>
</body>

</html>