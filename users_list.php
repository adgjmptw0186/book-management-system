<?php
$user = [0];
if (isset($_POST['search'])) {
    require('../common/utility.php');
    FuncCheckSession(1);

    $_SESSION['user_number'] = $_POST['user_number'];
    $_SESSION['user_name'] = $_POST['user_name'];
    $_SESSION['sex_type'] = $_POST['sex_type'];
    $_SESSION['school_year'] = $_POST['school_year'];
    $_SESSION['PASSWORD'] = $_POST['PASSWORD'];

    $user_number = $_SESSION['user_number'];
    $user_name = $_SESSION['user_name'];
    $sex_type = $_SESSION['sex_type'];
    $school_year = $_SESSION['school_year'];
    $PASSWORD = $_SESSION['PASSWORD'];


    if (!isset($_POST['sortType1']) || (isset($_POST['sortType1']) && $_POST['sortType1']) == "user_number")
        $sortType1 = 'user_number';
    if (isset($_POST['sortType1']) && $_POST['sortType1'] == "user_name")
        $sortType1 = 'user_name';
    if (isset($_POST['sortType1']) && $_POST['sortType1'] == "sex_type")
        $sortType1 = 'sex_type';
    if (isset($_POST['sortType1']) && $_POST['sortType1'] == "school_year")
        $sortType1 = 'school_year';
    if (isset($_POST['sortType1']) && $_POST['sortType1'] == "PASSWORD")
        $sortType1 = 'PASSWORD';

    if (!isset($_POST['sortType2']) || (isset($_POST['sortType2']) && $_POST['sortType2']) == "asc") {
        $sortType2 = 'ASC';
    }
    if (isset($_POST['sortType2']) && $_POST['sortType2'] == "desc") {
        $sortType2 = 'DESC';
    }


    $search_sql_array = array();
    if (trim($user_number) != "") {
        $search_sql_array[] = "user_number LIKE '%" . $user_number . "%'";
    }
    if (trim($user_name) != "") {
        $search_sql_array[] = "user_name LIKE '%" . $user_name . "%'";
    }
    if (trim($sex_type) != "") {
        $search_sql_array[] = "sex_type='" . $sex_type . "'";
    }
    if (trim($school_year) != "") {
        $search_sql_array[] = "school_year='" . $school_year . "'";
    }
    if (trim($PASSWORD) != "") {
        $search_sql_array[] = "PASSWORD LIKE '%" . $PASSWORD . "%'";
    }

    $users_sql = "SELECT user_number,user_name,sex_type,school_year,PASSWORD FROM users WHERE ";
    if (count($search_sql_array) > 0) {
        $users_sql .= implode("AND ", $search_sql_array);
    }
    $users_sql .= "ORDER BY " . $sortType1 . " " . $sortType2;
    $user = FuncSelectSql($users_sql);
}
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/users_list.css">
    <title>利用者検索</title>
</head>

<body class="UL_body">
    <h1>利用者検索</h1>
    <script type="textt/javascript" src="../js/user-search.js"></script>
    <!--jsファイルの呼び出し-->
    <form method="post">
        <table class="UL_body">
            <tbody>
                <tr>
                    <th>利用者番号</th>
                    <td><input type="text" name="user_number" size="30" /></td>
                </tr>
                <tr>
                    <th>氏名</th>
                    <td><input type="text" maxlengttyh="30" name="user_name" size="30"></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>
                        <select type="search" name="sex_type" style="width: 100%">
                            <!--<option selected disabled hidden style="display: none" value=""></option>-->
                            <option value=""></option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>学年</th>
                    <td>
                        <select type="search" name="school_year" style="width: 100%">
                            <option value=""></option>
                            <option>1年</option>
                            <option>2年</option>
                            <option>3年</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="text" name="PASSWORD" size="30"></td>
                </tr>
                <tr>
                    <th>ソート順</th>
                    <td style="display:flex;">
                        <select name="sortType1" style="width:49%;margin-right:2%">
                            <option selected disabled hidden style="display: none" value=""></option>
                            <option value="user_numer">利用者番号</option>
                            <option value="user_name">氏名</option>
                            <option value="sex_type">性別</option>
                            <option value="school_year">学年</option>
                            <option value="PASSWORD">パスワード</option>
                        </select>

                        <select name="sortType2" style="width:49%">
                            <option selected disabled hidden style="display: none" value=""></option>
                            <option value="asc">昇順</option>
                            <option value="desc">降順</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <td></td>
        <td>
            <button class="UL_button" type="submit" name="search">検索</button>
            <!--<script>
                var button = document.getElementById("button");
                button.addEventListener("click",function(e){
                    e.preventDefault();
                    var user_ID = document.getElementById("user_ID").value;
                });
            </script>-->
        </td>

        <table class="UL_table">
            <tr>
                <th class="UL_th">利用者番号</th>
                <th class="UL_th">氏名</th>
                <th class="UL_th">性別</th>
                <th class="UL_th">学年</th>
                <th class="UL_th">パスワード</th>
                <th class="UL_th">詳細</th>
            </tr>
            <?php
            $counter = 0;
            foreach ($user as $books):
                if ($counter >= 10) {
                    //警告アラート
                    $counter11 = "<script type='text/javascript'> alert('表示可能件数を超えています。');</script>";
                    echo $counter11;
                    

                    break;
                }
                echo "<tr>";
                ?>

                <tr>
                    <td class="UL_td">
                        <?php $user_number = $books['user_number']; ?>
                        <?php echo $books['user_number']; ?>
                    </td>
                    <td class="UL_td">
                        <?php echo $books['user_name']; ?>
                    </td>
                    <td class="UL_td">
                        <?php echo $books['sex_type']; ?>
                    </td>
                    <td class="UL_td">
                        <?php echo $books['school_year']; ?>
                    </td>
                    <td class="UL_td">
                        <?php echo $books['PASSWORD']; ?>
                    </td>
                    <td class="UL_td"><a
                            onclick="var ok=confirm('この利用者の詳細へいきますか？');if (ok) location.href='/apps/user-management/usage_history.php?user_number=<?= $books['user_number'] ?>'; return false;">この利用者の詳細画面へ</a>
                    </td>
                </tr>
            <?php 
                $counter++;
                endforeach
             ?>
        </table>

        <?php echo "表示件数",$counter; ?>


        <div style="display:flex;justify-content:end;width:90vw">
            <input class="UL_button" type="reset" value="クリア" onclick="return confirm('本当に入力内容を消去しますか？');" />
        </div>
        <?php
        //接続設定
        $dbtype = "mysql";
        $sv = "localhost";
        $dbname = "library_test";
        $user = "root";
        $pass = "";
        ?>

    </form>
</body>

</html>