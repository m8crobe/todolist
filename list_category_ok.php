<?php
    include "config/inc_head.php";
    include "config/db_connection.php";

// 카테고리 관련 프로세스

$pro = isset($_POST['pro'])?$_POST['pro']:"";
$category_name = isset($_POST['category_name'])?$_POST['category_name']:"";
$e_pk = isset($_POST['e_pk'])?$_POST['e_pk']:"";


if($pro == "I"){                        // 추가

    //--- 카테고리 정렬 순서 제일 큰 값 찾기
    $seq_qry = "SELECT user_seq FROM category WHERE user_idx='$sess_user_idx' order by user_seq desc LIMIT 1";
    $seq_row = db_fetch_row($seq_qry);
    $user_seq = $seq_row['user_seq'];
    $key_qry = "SELECT user_key FROM category WHERE user_idx='$sess_user_idx' order by user_key desc LIMIT 1";
    $key_row = db_fetch_row($key_qry);
    $user_key = $key_row['user_key'];

    $arr = array(
        "category"=>$category_name,
        "user_seq"=>$user_seq+1,
        "user_key"=>$user_key+1,
        "user_idx"=>$sess_user_idx,
        "user_id"=>$sess_user_id
    );
    db_insert("category", $arr);

} else if ($pro == "E"){                // 수정

    $edit_arr = array(
        "category"=>$category_name,
    );

    $edit_pk = array(
        "cate_idx"=>$e_pk
    );
    db_update("category", $edit_arr, $edit_pk);

} else if ($pro == "D"){                // 삭제

    $all_del_check = isset($_POST['all_del_check'])?$_POST['all_del_check']:"";

    $del_arr= array(
        "cate_idx"=>$e_pk
    );
    db_delete("category", $del_arr);

    if($all_del_check){
        
    }
    else
    {

    }


} else if ($pro == "O") {               // 순서변경
    $qry = "SELECT * FROM category where user_idx = '$sess_user_idx' AND user_id = '$sess_user_id' AND user_key<>'1' order by user_seq asc";
    $arr = db_fetch_arr($qry);
    $cate_idx = "";
    for($i=0; $i<count($_POST['cate_idx']); $i++){
        $order_pk = array(
            "cate_idx" => $_POST['cate_idx'][$i]
        );
        $order_arr = array(
            "user_seq" => ($i+1),
        );
        db_update("category", $order_arr , $order_pk);
    }
}


Header("Location:list_category.php");
?>