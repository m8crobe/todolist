<?php
    include "config/inc_head.php";
    include "config/db_connection.php";



    $pro = $_POST['pro'];
    $do_idx = isset($_POST['do_idx'])?$_POST['do_idx']:"";
    $cate_idx = isset($_POST['cate_idx'])?$_POST['cate_idx']:"";
    $title = isset($_POST['title'])?$_POST['title']:"";
    $content = isset($_POST['content'])?$_POST['content']:"";
    $location = "todo_list.php";
    $msg = "";

    if($pro == "I"){
        $insert_arr = array(
            "cate_idx" => $cate_idx,
            "user_idx" => $sess_user_idx,
            "user_id" => $sess_user_id,
            "title" => $title,
            "content" => $content,
        );

        db_insert("todo", $insert_arr);

        $msg = "저장되었습니다.";

    } else if ($pro == "E"){


    } else if ($pro == "D"){

        $del_arr = array(
            "user_idx" => $sess_user_idx,
            "user_id" => $sess_user_id,
            "do_idx" => $do_idx,
            "cate_idx" => $cate_idx
        );
        
        db_delete("todo", $del_arr);

        $msg = "삭제되었습니다.";
        
    } else {
        $msg = "액션값이 올바르지 않습니다.";
        $location = "window.history.back()";
    }
    echo "<script>alert('$msg'); </script>";
    echo "<script>location.href='$location';</script>";

?>