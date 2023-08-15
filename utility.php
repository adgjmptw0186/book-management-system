<?php
// データベース接続～検索の実行
function FuncSelectSql($sql){
    $rtn = false;

    if($sql != null){
    // DB接続設定
    $dbtype="mysql";
    $sv="10.123.100.102";//サーバのIPアドレス
    $dbname="library_test";
    $user="root";
    $pass="";

    // DBに接続
    $dsn="$dbtype:dbname=$dbname;host=$sv;charset=utf8";
    $conn=new PDO($dsn,$user,$pass);

    $csql='use library_test';
    $stmt=$conn->exec($csql);

    // SQLの実行
    $stmt=$conn->prepare($sql);
    $stmt->execute();

    $rtn = $stmt;
    }

    return $rtn;// 結果はfalse(失敗) か 検索実行結果配列
}

// データベース接続～登録/更新/削除の実行
function FuncExecuteSql($sql){
    $rtn = false;

    if($sql != null){
    // DB接続設定
    $dbtype="mysql";
    $sv="10.123.100.102";//サーバのIPアドレス
    $dbname="library_test";
    $user="root";
    $pass="";

 // DBに接続(PDO) SQLインジェクション対策×
    $dsn="$dbtype:dbname=$dbname;host=$sv;charset=utf8";
    $conn=new PDO($dsn,$user,$pass);

    $csql='use library_test';
    $stmt=$conn->exec($csql);

    // SQLの実行
    $stmt=$conn->exec($sql);

    //結果は行数なのでnull or 0でなければ成功とする
    if($stmt != null || $stmt != 0){
        $rtn=true;
    }

    }

    return $rtn;// 結果はbool型
}

// ログインしてない実行のエラー表示
// ログイン中ユーザのuser_nunberを返す関数 FuncCheckSession(旧バージョン)より楽かも？
function FuncCheckSession($session){
    //$session=0は一般ユーザ用(窓口ユーザも利用可)、1は窓口ユーザ用
    $user_number = null;
    $rtn = false;
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(empty($_SESSION['login_user'])){ // セッションが空だったら未ログインとする(error処理もする)
        FuncMakeLoginURL();
    }else{ // 何か入っていればそのuser_numberでログイン済みとする
        $user_number = $_SESSION['login_user'];
        $rtn = true;
    }
    
    if($session==1){//窓口ユーザ用
        $sql='select * from users where user_number = ' . $user_number;
        $stmt = FuncSelectSql($sql);
        $row=$stmt ->fetch();
        if($row['user_type']==1){
        //窓口ユーザの場合の処理
        $rtn = true;
        }else{//一般ユーザの場合
        $rtn = false;
        FuncMakeLoginURL();
        }
    }
    return $user_number;
}


function FuncMakePulldown($code_type){
    // プルダウンHTMLの始まり
    echo '<select name="' . $code_type . '">';
    echo '<option value="">▼選択してください</option>';

    // DBから項目を引っ張ってくる
    $sql="SELECT * FROM code_types WHERE code_type = " . $code_type;
    $stmt = FuncSelectSql($sql);
    while($row=$stmt->fetch()){
        echo '<option value="' . $row['code'] . '">' . $row['code']. ":" . $row['code_name'] . '</option>';
    }

    // プルダウンHTMLの終わり
    echo '</select>';
}

function FuncMakeLoginURL(){
    echo "<p>ログインしてください<br>".
    "<a href='http://10.123.100.102/apps/common/login.php'>ログイン画面へ</a></p>";
    exit();
}
?>