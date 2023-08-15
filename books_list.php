<?php
    require('../common/utility.php');
    //FuncCheckSession(1);
    $book = FuncSelectSql('select * from books');
    error_reporting(0);

    
    //検索ボタンを押した時の処理
    if( isset($_POST['kensaku']) ){
    //sortType1を押したとき
        if( !isset($_POST['sortType1']) || isset($_POST['sortType1']) && $_POST['sortType1'] == "book_number" ) $sortType1 = 'book_number' ;
        if( isset($_POST['sortType1']) && $_POST['sortType1'] == "book_name" ) $sortType1 = 'book_name' ;
        if( isset($_POST['sortType1']) && $_POST['sortType1'] == "author" ) $sortType1 = 'author' ;
        if( isset($_POST['sortType1']) && $_POST['sortType1'] == "category" ) $sortType1 = 'category' ;
    //sortType2を押したときの昇順・降順
    if (!isset($_POST['sortType2']) || isset($_POST['sortType2']) && $_POST['sortType2'] == "asc") {
        $sortType2 = 'ASC';
        //echo "asc"; 確認用
    }
    if (isset($_POST['sortType2']) && $_POST['sortType2'] == "desc") {
        $sortType2 = 'DESC';
        //echo "desc"; 確認用
    }
        
        
        $book_number = trim($_POST['book_number']);
        $book_name = trim($_POST['book_name']);
        $author = trim($_POST['author']);
        //カテゴリの前方一致
    
        if( !isset($_POST['1']) || (isset($_POST['1']) && $_POST['1'] == "1" ))  $category = '1' ;
        if( isset($_POST['1']) && $_POST['1'] == "2" ) $category = '2' ;
        if( isset($_POST['1']) && $_POST['1'] == "3" ) $category = '3' ;
        //検索処理
        if( $book_number != "" && isset($book_number) ){
            $book = FuncSelectSql(" SELECT * FROM books WHERE book_number LIKE '$book_number%' ORDER BY $sortType1 $sortType2 ");
        }
        elseif( $book_name != "" && isset($book_name) ){
            $book = FuncSelectSql(" SELECT * FROM books WHERE book_name LIKE '%$book_name%' ORDER BY $sortType1 $sortType2 ");
        }
        elseif( $author != "" && isset($author) ){
            $book = FuncSelectSql(" SELECT * FROM books WHERE author LIKE '%$author%' ORDER BY $sortType1 $sortType2 ");
        }
        elseif( $category != "" && isset($category) ){
            $book = FuncSelectSql(" SELECT * FROM books WHERE category LIKE '%$category%' ORDER BY $sortType1 $sortType2 ");
        }
    }
    
?>
    







<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <!--<link rel="stylesheet" type="text/css" href="../css/book-search.css">-->
    <title>書籍検索</title>
</head>

<body style="align-items: center;
            background-color: white;
            margin-top: 6vmin;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            text-align: center;">
    <h1>書籍検索</h1>
    <!--検索する内容を入力-->
      <form method="post">
        <table style="align-items: center;
                background-color: white;
                margin-top: 6vmin;
                margin-left: auto;
                margin-right: auto;
                position: relative;
                text-align: center;">
            <tbody>
                <tr>
                    <td>書籍番号　</td>
                    <td><input type="search" name="book_number" size="30" placeholder="書籍番号を入力してください">
                        
                    </td>
                </tr>
                <tr>
                    <td>タイトル　</td>
                    <td>
                        <input type="search" name="book_name" size="30" placeholder="タイトルを入力してください">
                    </td>
                </tr>
                <tr>
                    <td>著者　</td>
                    <td>
                        <input type="search" name="author" size="30" placeholder="著者を入力してください">
                    </td>
                </tr>
                <tr>
                    <td>カテゴリ　</td>
                    <td>
                        <!--<select type="search" name="category" style="width:100%" >
                            何も選択していないときにプルダウンの中を空にする
                            <option selected disabled hidden style='display: none' value=''></option>
                            <option value="1">歴史</option>
                            <option value="2">文学</option>
                            <option value="3">小説</option>
                        </select>-->
                        <?php
                        FuncMakePulldown(1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>ソート順　</td>
                    <!--display:flexの定義することでその直下の要素が並列になる-->
                    <td style="display:flex;">
                        <select name="sortType1" type="search" style="width:49%;margin-right:2%">
                            <option selected disabled hidden style='display: none' value=''></option>
                            <option value="book_number">書籍番号</option>
                            <option value="book_name">タイトル</option>
                            <option value="author">著者</option>
                            <option value="category">カテゴリ</option>
                        </select>


                        <select name="sortType2" type="search" style="width:49%">
                            <option selected disabled hidden style='display: none' value=''></option>
                            <option value="asc">昇順</option>
                            <option value="desc">降順</option>
                        </select>
                    </td>
                </tr>
                <td></td>
                <td>
                    <input class="Bl_button" type="submit" name="kensaku"  value="検索">
                </td>
            </tbody>
        </table>

        <br>
        <!--検索結果を表示-->
        
            <table style="white-space: nowrap;
                            width:80vw;
                            background-color: white;
                            border: ridge 1px black;
                            margin: auto;
                            overflow: scroll;
                            white-space: nowrap;">
                <tr>
                    <th>書籍番号</th>
                    <th>タイトル</th>
                    <th>著者</th>
                    <th>カテゴリ</th>
                    <th>詳細</th>
                </tr>
                <?php
                    $counter = 0;
                    foreach ($book as $books):
                        if($counter >= 10){
                            //警告アラート
                            $counter11 = "<script type='text/javascript'> alert('表示可能件数を超えています。');</script>";
                            echo $counter11;

                            break;
                        } 
                        echo "<tr>";
                ?>
                <td style="border: ridge 1px black;
	                    font-size: 1vmin;						
	                    height: 2vmin;							
	                    text-align: center;						
	                    overflow: auto;">
                    <?php
                        echo $books['book_number'];
                    ?>
                </td>
                    <td style="border: ridge 1px black;
	                    font-size: 1vmin;						
	                    height: 2vmin;							
	                    text-align: center;						
	                    overflow: auto;">
                    <?php
                        echo $books['book_name'];
                    ?>
                </td>
                    <td style="border: ridge 1px black;
	                    font-size: 1vmin;						
	                    height: 2vmin;							
	                    text-align: center;						
	                    overflow: auto;">
                    <?php 
                        echo $books['author'];
                    ?>
               </td>
                    <td style="border: ridge 1px black;
	                    font-size: 1vmin;						
	                    height: 2vmin;							
	                    text-align: center;						
	                    overflow: auto;">
                    <?php
                        echo $books['category'];
                    ?>
                </td>
                    <td style="border: ridge 1px black;
	                    font-size: 1vmin;						
	                    height: 2vmin;							
	                    text-align: center;						
	                    overflow: auto;">
                    <a onclick="var ok=confirm('本の詳細へいきますか？');if (ok) location.href='/apps/book-management/books_property.php?book_number=<?=$books['book_number']?>&book_name=<?=$books['book_name']?>&author=<?=$books['author']?>&category=<?= $books['category']?>';return false;">本の詳細へ</a></td>
                    <?php
                        echo "</tr>";  
                        $counter++;        
                        endforeach;   
                    ?>     
            </table>
        
        
        <div style='display:flex;justify-content:end;width:20vw;'>
                <?php  echo "表示件数",$counter; ?>  
        </div>
            
        <div style="display:flex;justify-content:end;width:90vw">
        <input class="Bl_button" type="button" onclick="var ok=confirm('メニュー画面に行きますか？');if (ok) location.href='/apps/common/menu.php';return false;" value="メニュー画面に戻る"/>
            <input class="Bl_button" type="button" onclick="var ok=confirm('ランキングへいきますか？');if (ok) location.href='/apps/reception/ranking.php';return false;" value="ランキングへ"/>
            <input class="Bl_button" type="reset"  value="クリア" onclick="return confirm('本当に入力内容を消去しますか？');" />

        </div>
        <?php
            //接続設定
            $dbtype ="mysql";
            $sv = "localhost";
            $dbname = "library_test"
        ?>
    </form>
</body>