<?php
   
    require_once ('../common/utility.php');
    FuncCheckSession(1);

    error_reporting(0); //エラー非表示

    $book_number = $_POST['book_number'];
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $category = $_POST[1];
    $lending_type = $_POST[2];
    if(empty($_POST["label"])){
        $label = "追加";
    }else{
        $label = $_POST["label"];
    }
        $sql3=
    "INSERT INTO books ( book_number, book_name, author, category, lending_type) VALUES 
    ('" . $book_number."','" . $book_name."','" . $author. "','" . $category. "','" . $lending_type. "');
    ";

    $sql2=
    "UPDATE books SET book_name = '{$book_name}' , author = '{$author}', category = {$category},
    lending_type = {$lending_type} where book_number = {$book_number}";

    $number_alert =  "すでに書籍番号が使用されています";
        $alert = "<script type = 'text/javascript'>alert('".$number_alert. "');</script>";

        if(!empty($_POST['submit'])){
            if($label=="追加"){
                if(FuncExecuteSql($sql3)){
                    header('Location: /apps/book-management/books_regist_confirm.php');
                }
            }else if($label=="更新"){
                if(FuncExecuteSql($sql2)){
                    header('Location: /apps/book-management/books_regist_confirm.php');
                }else{
                    echo "更新に失敗しました";
                }
            }
            //header('Location: /apps/book-management/books_regist_confirm.php');
           // 'window.location.href = "/apps/book-management/books_regist_confirm.php"';
            //echo $sql;
            //実行成功
        }else{
                
        }

        // 検索ボタンが押されたら
        if(!empty($_POST['search']) && !empty($_POST['book_number'])){ 
            $search = $_POST['book_number'];
            $sql="select * from books where book_number = {$search}";
            $stmt = FuncSelectSql($sql);
            $row = $stmt->fetch();
            if(!empty($row)){// データが見つかったら    
                 $book_number = $row['book_number'];
                 $book_name = $row['book_name'];
                 $author = $row['author'];
                 $category = $row['category'];
                 $lending_type = $row['lending_type'];
                 $label="更新";
            }else{
                $book_name = "";
                $author = "";
                $category = "";
                $lending_type = "";
                $label="追加";
            }
        }
?>
<?php
   
    /*$sql = "select * from books where book_number = :book_number"
    knsk_book = FuncSelectSql($sql);*/
    ?>



<!DOCTYPE html>
<html>
<head>

<script language="javascript" type="text/javascript">
    function confirm_pop(){
        if(confirm("登録してもよろしいですか？")){
           // window.location.href = "/apps/book-management/books_regist_confirm.php";
           window.location.href = "/apps/book-management/books_resist.php";
        }
    }
</script>
<script language="javascript" type="text/javascript">
    function back_pop(){
        if(confirm("戻りますか？")){
           // window.location.href = "/apps/common/menu.php";
           window.location.href = "/apps/common/menu.php";
        }
    }
</script>

<script language="javascript" type="text/javascript">
function clere_pop(){
        if(confirm("画面をクリアしますか?")){
            echo reset;
        }
    }
</script>
<title>書籍登録画面</title>
</head>                
<body>

<h1>書籍登録</h1>
<h2><?php echo $label ?></h2>
書籍内容
<form method="POST" action="">
<p>書籍番号:<input type="search" name="book_number" value=<?php echo $book_number; ?>>
<input type="hidden" name="label" value=<?php echo $label; ?>>
<input type="submit" name="search" value="検索">
     
   
</p>
<p>タイトル:<input type="text" name="book_name" maxlength=101 value=<?php echo $book_name; ?>></p>
<p>著者:<input type="text" name="author" maxlength=31 value=<?php echo $author; ?> ></p>
<p>カテゴリ:<?php FuncMakePulldown(1);echo $category; ?>
</p>
<p>貸出し可否グラフ<?php FuncMakePulldown(2);echo $lending_type; ?>
</p>
<?php 
echo ""
?>
<script language="javascript" type="text/javascript">
    let c = '<?php echo $category; ?>';
    let l = '<?php echo $lending_type; ?>'
    document.getElementById("1").
    querySelector("option[value="+c+"]").selected = true;
    document.getElementById("2").
    querySelector("option[value="+l+"]").selected = true;
</script>
<input type="reset" value=クリア onclick="clere_pop();">
<input type="hidden" name="label" value=<?php echo $label; ?>>
<input type="submit" name="submit" value="登録" onclick ="confirm_pop();">

<input type="button" value="戻る" onclick = "back_pop();">
</form>

</body>
</html>
