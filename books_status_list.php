<?php
require_once '../common/utility.php';

//フォームの内容を取得する。
@$reception_number = $_POST['reception_number'];
@$book_number = $_POST['book_number'];
@$lending_user_number = $_POST['lending_user_number'];
@$lending_date = $_POST['lending_date'];
@$return_date = $_POST['return_date'];
@$sentaku = $_POST['現在状況の選択'];


//共通するSQL(これに色々足していく)
$sql = 'SELECT * FROM books INNER JOIN reception_list ON books.book_number = reception_list.book_number where 1 = 1' ;
//管理番号
if($reception_number != ''){
    $sql = $sql.' AND reception_number LIKE \''.$reception_number.'%\'';    

}

//書籍番号
if($book_number != ''){
    if ($reception_number != '') {
        $sql = $sql . ' AND books.book_number LIKE \'' . $book_number.'%\'';
    }
    elseif($reception_number ==''){
        $sql = $sql . ' AND books.book_number LIKE \'' . $book_number.'%\'';
    }
}

//利用者番号
if($lending_user_number != ''){
    if ($reception_number != '' or $book_number != '') {
        $sql = $sql.' AND lending_user_number LIKE \'' . $lending_user_number.'%\'';
    }
    elseif($reception_number == '' and $book_number == ''){
        $sql = $sql. ' AND lending_user_number LIKE \'' . $lending_user_number.'%\'';
    }
}

//貸出日
if($lending_date !=''){
    if ($reception_number != '' or $book_number != '' or $lending_user_number != '') {
        $sql = $sql.' AND lending_date = \'' . $lending_date.'\'';
    }
    elseif($reception_number == '' and $book_number == '' and $lending_user_number == ''){
        $sql = $sql.' AND lending_date = \''. $lending_date.'\'';
    }
}
//返却日
if($return_date !=''){
    if ($reception_number != '' or $book_number != '' or $lending_user_number != '' or $lending_date != '') {
        $sql = $sql.' AND return_date = \''. $return_date.'\'';
    }
    elseif($reception_number == '' and $book_number == '' and $lending_user_number == '' and $lending_date ==''){
        $sql = $sql.' AND return_date = \''. $return_date.'\'';
    }
}
//貸出状態
if($sentaku =='貸出中'){
    $sql = $sql.' AND return_date IS NULL';
}
elseif($sentaku =='返却済み'){
    $sql = $sql . ' AND return_date IS NOT NULL';
}

//SQLを表示(テスト用)
// var_dump($sql);

//SQLの実行
$stmt = FuncSelectSql($sql);

//mysqlレコード件数を取得
$row_count = $stmt->rowCount();

while (true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec == false) {
        //データが無ければ処理終了
        break;
    }
    //テーブルで出力できるように配列格納
    $ary_reception_number[] = $rec['reception_number'];//窓口管理番号
    $ary_book_number[] = $rec['book_number'];//書籍番号
    $ary_book_name[] = $rec['book_name'];//タイトル
    $author[] = $rec['author'];//著者
    $category[] = $rec['category'];//カテゴリ
    $lending_type[] = $rec['lending_type'];//貸出可否
    
    //追加
    $ary_lending_date[] = $rec['lending_date'];//貸出日
    $ary_return_date[] = $rec['return_date'];//返却日
    $ary_lending_user_number[] = $rec['lending_user_number'];//利用者番号
}
?>
<!-- ここから画面構成 -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
        .teable1 {
            border-collapse: separate;
            border-spacing: 50px 0px;
            margin-left: auto;
            margin-right: auto;
        }
        .teable1 {
            text-align: left;
            margin-bottom: 1em;
        }
        /* 検索結果が出力されるテーブル */
        .list1{
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            /* text-align: center; */
        }
        /* テーブルの幅を固定 */
        list1,th,td{
            width: 135px;
        }
        /* 検索・クリアボタン描画設定 */
        .button1 {
            text-align: center;
            margin-bottom: 5px;
        }
        /* 返却画面へリンクを中央に表示 */
        .return{
            text-align: center;
        }

        /* 遊び心 */
        /* body{
            background: linear-gradient(to right,#e60000,#f39800,#fff100,#009944,#0068b7,#1d2088,#920783,#e60000) 0 / 200%;
            animation: 1s example4 linear infinite;
        } */

        #table_id th {
	        cursor:pointer;
	        background-color:lightgray;
        }
        /* 見出し文字の設定 */
        h1{
            background-color: #b0c4de;
            margin-bottom: 5px;
            font-size:210%; 
            
        }
        /* 画面上部や横の余白の削除 */
        * {
            margin: 0px;
            padding: 0px;
        }
        /* メニューに戻るボタンの設定 */
        .back{
            margin-bottom: 0px;
            margin-right: 10px;
            text-align: right;
        }
        /* 検索結果件数の表示に関する設定 */
        .abe{
            text-decoration:underline;
            text-decoration-color: red;
            margin-left:15px;
        }

        @keyframes example4{
            100% { background-position: 200%; }
        }
    </style>

    <script language="javascript" type="text/javascript">
        function OnButtonClick() {
        
            var elm = document.getElementById("table_id");

            console.log(elm)

            var sampleArea = document.getElementById("output");
            sampleArea.innerHTML = elm.innerHtml;

        }
    </script>
</head>

<body>

<div class="example4">
    
    <h1>
        <center>窓口用状態検索</center>
    </h1>
    <div class="back">
<input class = "button4" type="submit" name="submit" value="メニューに戻る" onclick ="back2_pop();">
</div>

    <form method="post" name = "main">
        <table align="center" class="teable1">
            <tr>
                <th>窓口管理番号</th>
                <th><input id ="reception" name="reception_number" type="text" value="<?php echo $reception_number; ?>" ></th>
            </tr>
            <tr>
                <th>書籍番号</th>
                <th><input id = "book" name="book_number" type="text" value="<?php echo $book_number; ?>"></th>
            </tr>
            <tr>
                <th>利用者番号</th>
                <th><input id = "lending_u" name="lending_user_number" type="text" value="<?php echo $lending_user_number; ?>"></th>
            </tr>
            <tr>
                <th>貸出日</th>
                <th><input id ="lending_d" name="lending_date" type="date" value="<?php echo $lending_date; ?>" /></th>
            </tr>
            <tr>
                <th>返却日</th>
                <th><input id = "return" name="return_date" type="date" value="<?php echo $return_date; ?>" /></th>
            </tr>
            <tr>
                <th>現在状態</th>
                <th><select id = "select" name="現在状況の選択">
                        <option><?php echo $sentaku; ?></option>
                        <option>指定しない</option>
                        <!-- 返却値が格納されているもの -->
                        <option>貸出中</option>
                        <!-- 返却値が格納されていいないもの→借りることができるもの -->
                        <option>返却済み</option>
                    </select></th>
            </tr>
            <!-- <tr>
                <th>ソート順</th>
                <th></th>
            </tr> -->
        </table>
        <div class="button1">
            <input value="検索" type="submit" /> 
            <input  type="button" value="クリア" onclick="clearText()"/>
            
        </div>
        <div class = "abe">
        <?php
        echo '◆検索件数'.$row_count.'件';
        ?>
        </div>
        <!-- リセットボタンを押したときの処理 -->
        <script>
            function clearText(){
                var a = document.getElementById("reception");
                var b = document.getElementById("book");
                var c = document.getElementById("lending_u");
                var d = document.getElementById("lending_d");
                var e = document.getElementById("return");
                var f = document.getElementById("select");
                a.value = '';
                b.value = '';
                c.value = '';
                d.value = '';
                e.value = '';
                f.value = '';

                document.main.submit();
            } 

        </script>
        
    </form>
    <table id="table_id" align="center" border="1" style="border-collapse: collapse" class="list1">
        <tr>
            <th>窓口管理番号▼</th>
            <th>書籍番号▼</th>
            <th>タイトル▼</th>
            <th>著者名▼</th>
            <th>利用者番号▼</th>
            <th>貸出日▼</th>
            <th>返却日▼</th>
            <th>返却▼</th>
        </tr>
    
        <?php for ($i = 0; $i < $row_count; $i++) {?>
        <tr>
            <td>
                <?php echo $ary_reception_number[$i]; ?>
            </td>
            <td>
                <?php echo $ary_book_number[$i]; ?>
            </td>
            <td>
                <?php echo $ary_book_name[$i]; ?>
            </td>
            <td>
                <?php echo $author[$i]; ?>
            </td>
            <td>
                <?php echo $ary_lending_user_number[$i]; ?>
            </td>
            <td>
                <?php echo $ary_lending_date[$i]; ?>
            </td>
            <td>
                <?php echo $ary_return_date[$i]; ?>
            </td>
            <td>
                <div class = "return">
                <?php
                if($ary_return_date[$i] ==''){
                    echo "<a href="."return_service.php?id=" .$ary_reception_number[$i].">返却画面へ</a>";

                    
                } 
                ?>
                </div>
            </td>
        </tr>
        <?php
}
?>
    </table>
    
    <script>
        //ソート順に関する処理
window.addEventListener('load', function () {
	let column_no = 0; //今回クリックされた列番号
	let column_no_prev = 0; //前回クリックされた列番号
	document.querySelectorAll('#table_id th').forEach(elm => {
		elm.onclick = function () {
			column_no = this.cellIndex; //クリックされた列番号
			let table = this.parentNode.parentNode.parentNode;
			let sortType = 0; //0:数値 1:文字
			let sortArray = new Array; //クリックした列のデータを全て格納する配列
			for (let r = 1; r < table.rows.length; r++) {
				//行番号と値を配列に格納
				let column = new Object;
				column.row = table.rows[r];
				column.value = table.rows[r].cells[column_no].textContent;
				sortArray.push(column);
				//数値判定
				if (isNaN(Number(column.value))) {
					sortType = 1; //値が数値変換できなかった場合は文字列ソート
				}
			}
			if (sortType == 0) { //数値ソート
				if (column_no_prev == column_no) { //同じ列が2回クリックされた場合は降順ソート
					sortArray.sort(compareNumberDesc);
				} else {
					sortArray.sort(compareNumber);
				}
			} else { //文字列ソート
				if (column_no_prev == column_no) { //同じ列が2回クリックされた場合は降順ソート
					sortArray.sort(compareStringDesc);
				} else {
					sortArray.sort(compareString);
				}
			}
			//ソート後のTRオブジェクトを順番にtbodyへ追加（移動）
			let tbody = this.parentNode.parentNode;
			for (let i = 0; i < sortArray.length; i++) {
				tbody.appendChild(sortArray[i].row);
			}
			//昇順／降順ソート切り替えのために列番号を保存
			if (column_no_prev == column_no) {
				column_no_prev = -1; //降順ソート
			} else {
				column_no_prev = column_no;
			}
		};
	});
});
//数値ソート（昇順）
function compareNumber(a, b)
{
	return a.value - b.value;
}
//数値ソート（降順）
function compareNumberDesc(a, b)
{
	return b.value - a.value;
}
//文字列ソート（昇順）
function compareString(a, b) {
	if (a.value < b.value) {
		return -1;
	} else {
		return 1;
	}
	return 0;
}
//文字列ソート（降順）
function compareStringDesc(a, b) {
	if (a.value > b.value) {
		return -1;
	} else {
		return 1;
	}
	return 0;
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
</div>

</body>

</html>