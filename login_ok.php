<?php
    include "config/db_connection.php";

    $login_gbn = isset($_POST['login_gbn'])?$_POST['login_gbn']:"login";            // 로그인/회원가입 구분
    $test_login = isset($_REQUEST['test_login']);

    $msg = "";
    $location = "index.php";
    echo $login_gbn;

    if($test_login == "test")           // 테스트 로그인
    {
        // 테스트 세션용 랜덤아이디 생성
        $randomString = bin2hex(random_bytes(6));
        $test_id = 'test_' . $randomString;
        session_start();
        
        $_SESSION['user_idx'] = "2";
        $_SESSION['user_id'] = $test_id;
        $_SESSION['test_login'] = true;

        echo "<script>parent.location.href='$location';</script>";
    }

    if($login_gbn == "login")
    {
        $id = $_POST['login_id'];
        $pw = $_POST['login_pw'];

        $login_sql = "SELECT * FROM user WHERE USER_ID = '$id' AND user_pw = '$pw'";
        $login_user = db_fetch_row($login_sql);

        if($login_user){
            session_start();
            $_SESSION['user_idx'] = $login_user['user_idx'];
            $_SESSION['user_id'] = $login_user['user_id'];

        } else {
            echo "<script>alert('로그인에 실패했습니다. 다시 시도해주세요.'); </script>";
        }
    }
    else if($login_gbn == "reg")
    {
        $insert_arr = array(
            "user_id"=>$_POST['reg_id'],
            "user_pw"=>$_POST['reg_pw'],
        );
        db_insert("user", $insert_arr);
        
        $idx_sql = "SELECT * FROM user WHERE user_id='{$_POST['reg_id']}'";
        $new_user = db_fetch_row($idx_sql);
        $location = "list_category.php";
        
        if($new_user){
            $new_user_idx = $new_user['user_idx'];
            $new_user_id = $new_user['user_id'];

            // 회원가입과 동시에 미분류 카테고리 생성
            $new_user_cate = array(
                "user_key"=>"1",
                "category"=>"미분류",
                "user_seq"=>"0",
                "user_idx"=>$new_user_idx
            );
            db_insert("category", $new_user_cate);

            // 세션실행
            session_start();
            $_SESSION['user_idx'] = $new_user_idx;
            $_SESSION['user_id'] = $new_user_id;

            $msg = "회원가입에 성공하였습니다.";
        } else {
            $msg = "회원가입에 실패하였습니다. 다시 시도해주세요.";
        }
        
        echo "<script>alert('$msg'); </script>";
    }
    else{
        echo "<script>alert('잘못된 접근입니다.'); </script>";
    }

    echo "<script>parent.location.href='$location';</script>";


?>