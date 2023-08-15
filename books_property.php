<?php
ini_set('display_errors', 0);

  require('../common/utility.php');

  //error_reporting(0);
$a = $_GET["book_number"];
$sql="SELECT * FROM books WHERE book_number = $a";
$book_number = FuncSelectSql($sql);
$sqlreception="SELECT count(*) as cnt FROM reception_list WHERE book_number = $a";
$receptionTotalCount = FuncSelectSql($sqlreception)->fetch();

$sqlreception="SELECT count(*) as cnt FROM reception_list WHERE book_number = $a AND return_date IS NULL";
$receptionNullCount = FuncSelectSql($sqlreception)->fetch();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>書籍詳細</title>
	</head>

	<body>

		<h1>書籍詳細</h1>






		<?php				

		$today = strtotime(date('Y/m/d '));

		//$wa =  strtotime(date('2023-01-11 '));

		$lending = strtotime(date($row['lending_date']));
		$kigen = ($today - $lending)/(60 * 60 * 24) . '日';

		if ($kigen > 10 && date($row['return_date']) == null) {
		echo "<th>" . "返却期限から" . $kigen . "過ぎています";
	}

?>



		<?php
		while ($row = $book_number->fetch()){
		echo "<table>";
		echo"<tr>";
			echo"<th>"."書籍番号</th>";
			echo"<th>". $row['book_number']. "</th>";
		echo"</tr>";
		echo"<tr>";
			echo"<th>"."タイトル</th>";
			echo"<th>". $row['book_name']. "</th>";
		echo"</tr>";
		echo"<tr>";
			echo"<th>"."著者</th>";
			echo"<th>". $row['author']."</th>";
		echo"</tr>";
		echo"<tr>";
			echo"<th>"."カテゴリ</th>";
			echo"<th>". $row['category']. "</th>";
		echo"</tr>";
		echo"<tr>";
			echo"<th>"."貸し出し可否フラグ</th>";
			echo"<th>". $row['lending_type']."</th>";
		echo"</tr>";


		echo"<tr>";
			echo"<th>"."現在状況</th>";
			echo "<th>";
			if ($receptionNullCount["cnt"] >0) {
				echo "<th>" . "貸出し中</th>";
			}else{
				echo "<th>" . "返却済み</th>";
			}
			 echo"</th>";
		echo"</tr>";




		echo"<tr>";
			echo"<th>"."貸出し回数</th>";
			echo"<th>". $receptionTotalCount['cnt']."</th>";
		echo"<tr>";
			}
		echo "</table>";

			?>
		
		<input value="戻る"type="button"onclick="var ok=confirm('書籍検索画面へ戻ります。');if (ok) location.href='books_list.php';return false;">

</body>
</html>

