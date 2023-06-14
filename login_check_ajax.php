<?php
    include "config/inc_head.php";
    include "config/db_connection.php";
    $login_gbn = isset($_POST['login_gbn'])?$_POST['login_gbn']:"login";

if($login_gbn == "reg")             // 회원가입시
{
    $id = isset($_POST['reg_id'])?$_POST['reg_id']:"";

    $escaped_id = mysqli_real_escape_string($connect, $id);  // ID 값 이스케이프 처리

    $sql = "SELECT * FROM user WHERE user_id = '".$escaped_id."'";

    $row = db_fetch_arr($sql);
    $exist = count($row);

    if($exist>0){
        echo "N";
    } else {
        echo "Y";
    }
}
else                                // 로그인 시도시
{
    $id = $_POST['login_id'];
    $pw = $_POST['login_pw'];

    $login_sql = "SELECT * FROM user WHERE USER_ID = '$id' AND user_pw = '$pw'";
    $login_user = db_fetch_row($login_sql);

    if($login_user){
        echo "Y";
    }
    else {
        echo "N";
    }
}
?>