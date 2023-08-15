<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <title>ログイン画面</title>
    </head>

    
    <?php
    session_start();//ログイン認証開始
    header("Cache-Control: no-store");
    $error_message = "";
    if(isset($_POST["login"])){//ログインボタンを押したら
        if(!empty($_POST["user_number"]) && !empty($_POST["password"] )){//利用者番号とパスワードが入力されているか判断
            $user_number = $_POST["user_number"];//入力されたものを$user_numberに入れている。
            $user_pass = $_POST["password"];
            
            require_once 'utility.php';

            $sql=" select * from users where user_number =". $user_number .
            " and password ='". $user_pass . "'";//データベースから抜き出し
            $stmt = FuncSelectSql($sql);//utility.phpのFuncSelectSqlを呼出している

            if($row = $stmt -> fetch()){//利用者番号に対してパスワードが合っているか判断
                $user_numberT = $row['user_number'];//正しい利用者番号をuser_numberTに入れ込む
                $user_passT = $row['password'];

                if($user_numberT == $user_number && $user_passT == $user_pass){//ログインが成功
                    $_SESSION['login_user'] = $user_numberT;//セッション作成
                    if($row['user_type'] == 1){//管理者ユーザだった場合
                        header('Location:menu.php');
                    }else{//一般ユーザーの場合
                        header('Location:../book-management/books_list.php');
                    }
                }else{
                    echo "<p align='center'>利用者番号,もしくはパスワードが間違っています。</p>";//データベースに利用者番号があるが、パスワードが違う
                }
            }else{
                echo"<p align='center'>利用者番号,もしくはパスワードが間違っています</p>";//データベースにない利用者番号が入る
            }
        
        }
        
    }
    
    ?>
    <body>
        <h1 >図書館ログイン画面</h1>
        <form method="post" action="" >
        <p>利用者番号</p>
        <th><input type="text"required name="user_number" size="30" value = "" ></th>

        <p>パスワード</p>
        <th><input type="password"required name="password" size="30" ></th>

        <P></p>
        <tr>
            <td colspan="2"><input type="submit" name="login" value="ログイン"></td>
        </tr></body>
</html>