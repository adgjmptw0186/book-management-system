<?php 
// http://localhost/php_base/sangi_library/apps/common/unit-test.php?user_number=1
//上記URLで実行
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charaset=UTF-8">
        <title>unit.phpテスト用</title>
    </head>
    <body>
        <p>
            FuncMakePulldown:<br>
            <form method="POST" action="">
            <?php 
            require_once 'utility.php';
            $kubun = 1;
            FuncMakePulldown($kubun);
            ?>
            <input type="submit" value="選択確認">
            <?php
            if(!empty($_POST[$kubun])){
                echo $_POST[$kubun];
            }else{
                echo "選択されていません";
            }
            ?>
        </p>
        <p>
            FuncSelectSql:<br>
            <?php
            $stmt = FuncSelectSql("select code_type,code,code_name from code_types");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(codetype)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }
            $stmt = FuncSelectSql("select book_number,book_name,author,category,lending_type from books");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(books)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }
            $stmt = FuncSelectSql("select reception_number,book_number,lending_user_number,lending_date,return_date from reception_list");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(reception_list)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }
            $stmt = FuncSelectSql("select user_number,user_name,sex_type,school_year,use_type,password,user_type from users");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(users)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }
            $a = '10';
            $stmt = FuncSelectSql("select * from users where user_number < {$a}");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(user_number<10)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }
            $stmt = FuncSelectSql("select code_type,code,code_name from code_types");
            if($row=$stmt->fetch()){
                    echo $stmt -> rowCount() . "行取得(codetype)<br>";
            }else{
                echo "文法エラー<br>";echo "または結果が0行";
            }

            ?>
        </p>
        <p>
            FuncExecuteSql:<br>
            <?php
            
            echo FuncExecuteSql("select * from code_types");

            echo "実行前1<br>";
            $sql = "INSERT INTO users(`user_number`, `user_name`,`sex_type`,`school_year`,`use_type`,`password`,`user_type`)"
            ." VALUES (9990,'山田太郎',1,1,0,'taro',0)";
            echo "実行前2<br>";
            if(FuncExecuteSql($sql)){//True
                echo 'INSERT成功<br>';
            }else{
                echo "INSERT失敗<br>";
            }
            echo "実行中1<br>";
            $sql = "DELETE FROM users WHERE user_number = 9990";
            if(FuncExecuteSql($sql)){//True
                echo 'DELETE成功<br>';
            }else{
                echo "DELETE失敗<br>";
            }
            $sql = "UPDATE userss SET user_name = '田中太郎' WHERE user_number = 9990";//userssテーブルはない
            if(!(FuncExecuteSql($sql))){//False
                echo 'UPDATE失敗<br>';
            }else{
                echo "UPDATE失敗<br>";
            }

            

            ?>
        </p>
        <a href=<?php echo "unit-test.php?user_number=1" ?>>
        user-numberテスト
        </a>
        <p>
            FuncCheckSession:<br>
        </p>
        <p>
        </p>
    </body>
</html>