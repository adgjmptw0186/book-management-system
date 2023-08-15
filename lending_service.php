<?php

require_once('../common/utility.php');
FuncCheckSession(1);
//error_reporting(0);

$sql = "selct * from users";
$useid = 25;
$sqlcnt = "select count(*) as cnt , user_name FROM users Where user_number = '{$useid}'";
$cnt = FuncSelectSql($sqlcnt);
$flag_u=false;$flag_b=false;
$user = "";$book="";

//窓口管理番号計算
$sql = "
select
count(*)+1 as c 
from
reception_list
";
$c = FuncSelectSql($sql);
if($row=$c->fetch()){
    $reception_number = $row['c'];
}

if(isset($_POST['book']) && isset($_POST['user'])){// 利用者番号と書籍番号が入力されていた場合
    $user=$_POST['user'];
    $book=$_POST['book'];

    //利用者検索
    if(is_numeric($user)){
        $sql= "
        select
        user_name
        ,a.code_name as gender
        ,b.code_name as school_year
        from 
        users u
        ,(select code_types.code,code_name from code_types where code_type = 3) as a
        ,(select code_types.code,code_name from code_types where code_type = 4) as b
        where user_number =  {$user}
        and u.sex_type = a.code
        and u.school_year = b.code
        ";
        $user_data = FuncSelectSql($sql);
        $flag_u = true;
    }

    //本検索
    if (is_numeric($book)) {
        $sql = "
        select
        book_name,
        author
        from
        books
        where book_number = {$book}
        ";
        $book_data = FuncSelectSql($sql);
        $flag_b = true;
    }
}

if(!empty($_POST['submit']) && $flag_b && $flag_u){//入力項目OKかつ貸し出しボタンが押されたとき
    $date=date("Y/m/d");
    $sql = "
    INSERT INTO reception_list(reception_number,book_number,lending_user_number,lending_date,return_date)
    VALUES({$reception_number},{$book},{$user},'{$date}',NULL)
    ";
    //echo $sql;
    if(FuncExecuteSql($sql)){
        header('Location:/apps/common/menu.php');
    }else{
        //echo "false";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<script language="javascript" type="text/javascript">
    function confirm_pop() {
        if(confirm("この書籍を貸し出しますか？")){
            window.location.href ="/apps/reception/lending_service.php";
        }
        
    }

</script>

    <title>図書管理システム</title>
</head>

<body>
    <h1>書籍貸出し</h1>
    <p>窓口番号 <?php echo $reception_number; ?></p><br>
    <form method="post" action="">
    <p>利用者番号
        <input type="number" name="user" size="20" value=<?php echo $user; ?>>
        <input type="submit" value="検索" id="button1">
    </p>
    <p>
    <?php
    if($flag_u && ($row=$user_data->fetch())){
        echo "氏名  " . $row['user_name'] . "<br>";
        echo "性別  " . $row['gender'] . "<br>";
        echo "学年  " . $row['school_year'] . "<br>";
    }else{
        echo "氏名  <br>";
        echo "性別　<br>";
        echo "学年　<br>";
    }
    
    ?>
    </p>
    <p>書籍番号
        <input type="number" name="book" size="20"
        value=<?php  echo $book; ?>>
        <input type="submit" value="検索" id="button1">
    </p>
    <p>
    <?php
    if($flag_b && ($row=$book_data->fetch())){
        echo "タイトル " . $row['book_name'] . "<br>";
        echo "著者 " . $row['author'] . "<br>";
    }else{
        echo "タイトル　<br>";
        echo "著者　<br>";
    }
    ?>
    </p>
    <p><input type="reset" value="クリア" id="button2" >
        <input type="submit" name="submit" value="貸出し" id="button3" onclick="confirm_pop();">
        <input type="button" value="戻る" id="button4" onclick="location.href='/apps/common/menu.php'">
    </p>
    </form>
</body>

</html>