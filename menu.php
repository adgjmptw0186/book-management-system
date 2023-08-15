<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>窓口メニュー</title>
</head>

<?php
require_once 'utility.php';

FuncCheckSession(1);
  

  
?>

<body>
    <h1>窓口メニュー画面</h1>
    <p>書籍管理</p>
    <th>
    <td colspan="2"><input type="button" value="本の登録"onclick="location.href='../book-management/books_resist.php'"></td>
    <td colspan="2"><input type="button" value="本の検索"onclick="location.href='../book-management/books_list.php'"></td>
    </th>

    <p>窓口</p>
    <th>
    <td colspan="2"><input type="button" value="貸出画面"onclick="location.href='../reception/lending_service.php'"></td>
    <td colspan="2"><input type="button" value="返却画面"onclick="location.href='../reception/return_service.php'"></td>
    <td colspan="2"><input type="button" value="窓口検索"onclick="location.href='../reception/books_status_list.php'"></td>
    </th>

    <p>利用者管理</p>
    <th>
    <td colspan="2"><input type="button" value="利用者登録画面"onclick="location.href='../user-management/users_resist.php'"></td>
    <td colspan="2"><input type="button" value="利用者検索"onclick="location.href='../user-management/users_list.php'"></td>
    <td colspan="2"><input type="button" value="ランキング"onclick="location.href='../reception/ranking.php'"></td>
    </th>

    <p>共通</p>
    <th>
    <td colspan="2"><input type="button" value="コード区分マスタ"onclick="location.href='code_type_resist.php'"></td>
    </th>

    <p></p>
    <th>
    <td colspan="2"><input type="button" name = "return" value="戻る"onclick="location.href='login.php'"></td>
</th>
</body>
</html>