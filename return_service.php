<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="template.css">
	<script src="template.js"></script>
	<title>書籍返却</title>
	<?php
	require_once '../common/utility.php';
	$codetype_data = FuncSelectSql('select * from reception_list');
	?>
</head>

<body>
	<?php
	$f = false;
	if (isset($_POST["reception_number"])) {
		$sql = "UPDATE `reception_list` SET `return_date`=now() WHERE `reception_number`={$_POST['reception_number']};";
		$junkfood = FuncSelectSql($sql);
		echo "
			<script>
				alert('返却しました。')
				// location.href = ''
				// location.replace('')
			</script>";
	} elseif (isset($_POST["use"])) {
		$f = true;
		//echo $_POST["use"];
		$reception_number = $_POST["use"];
		$sql = "SELECT * FROM reception_list WHERE reception_number = {$reception_number} ";
		$sql = "
	SELECT
	reception_number
	,lending_user_number
	,user_name
	,a1.code_name as sex_type
	,a2.code_name as school_year
	,r.book_number
	,book_name
	,author
	FROM
	reception_list r
	,books b
	,users u
	,(select code_types.code,code_name from code_types where code_type=3) as a1
	,(select code_types.code,code_name from code_types where code_type=4) as a2
	WHERE r.book_number = b.book_number
	AND r.lending_user_number = u.user_number
	AND u.sex_type = a1.code
	AND u.school_year = a2.code
	AND reception_number = {$reception_number}
		";
		$junkfood = FuncSelectSql($sql);
		$row = $junkfood->fetch();
		//echo $row['book_number'];
	} else {
		// $alert = "<script type='text/javascript'>alert('有効な数字を入力してください。');</script>";
		// echo $alert;
	}
	?>
	<div class="cen">
		<h1>書籍返却</h1>
	</div>
	<br>
	<div class="poteto">
		窓口管理番号
		<div style="display:inline-flex">
			<div class="humbergar">
				<form id="form1" method="post">
					<input id="sbox1" id="s" name="use" type="text" pattern="[0-9]*" title="数字で入力して下さい。" placeholder="キーワードを入力" value="<?php
																									@$deta = $_GET['id'];
																									if ($deta == '') {
																										echo '';
																									} else {
																										echo $deta;
																									}
																									?>" />
					<input id="sbtn1" type="submit" value="検索" />
				</form>
			</div>
		</div>
	</div>
	<div class="poteto">
		<br>
		<br>
		利用者番号　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['lending_user_number']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		氏名　　　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['user_name']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		性別　　　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['sex_type']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		学年　　　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['school_year']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		書籍番号　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['book_number']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		タイトル　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['book_name']; ?>
			</div>
		</div>
		<br>
		<br>
		<br>
		著者　　　　
		<div style="display:inline-flex">
			<div class="humbergar">
				<?php if ($f) echo $row['author']; ?>
			</div>
		</div>
	</div>
	<br>
	<div class="food">
		<dialog id="clear">
			入力内容をクリアしますか？
			<p>
				<button type="button" onclick="crea()">はい</button>
				<button type="button" onclick="this.parentNode.parentNode.close()">いいえ</button>
			</p>
		</dialog>
		<button type="button" onclick="document.getElementById( 'clear' ).show()">クリア</button>
		<th>　</th>
		<input value="返却" type="button" onclick="showReturnDialog()">
		<th>　</th>
		<dialog id="back">
			戻りますか？
			<p>
				<button type="button" onclick="location.href='/apps/common/menu.php'">はい</button>
				<button type="button" onclick="this.parentNode.parentNode.close()">いいえ</button>
			</p>
		</dialog>
		<button type="button" onclick="document.getElementById( 'back' ).show()">戻る</button>
	</div>


	<form method="POST" action="" id="returnForm">
		<input type="hidden" name="reception_number" value="<?= $_POST["use"] ?>">
	</form>
	<form method="POST" action="" id="crea">
		<input type="hidden" name="crea" value="#ffffffff">
	</form>
</body>



<script>
	function showReturnDialog() {
		debugger;
		let userAction = window.confirm("返却しますか？");

		if (userAction == true) {
			document.getElementById("returnForm").submit();
		}
	}
	function crea(){
		document.getElementById("crea").submit();
	}
</script>

</html>