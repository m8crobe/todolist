<?php
    include "config/inc_head.php";
    include "config/db_connection.php";
    include "config/version.php";

    if($jb_login){
        $sess_gbn = "로그아웃";
        $sess_href = "logout.php";
    } else {
        $sess_gbn = "로그인";
        $sess_href = "index.php";
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>TODOLIST</title>
    <script src="js/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="css/style.css?ver=<?=$ver?>">
    <script src="js/code.jquery.com_ui_1.13.2_jquery-ui.js"></script>
</head>

<style>

</style>
<body>
    <header>
        <h1>TODOLIST</h1>
        <?php if($jb_login){ ?>
                <div class="sess_id"><?=$sess_user_id?>님 반갑습니다.</div>
        <?php }?>
        <div class="category-management">
            
            <ul>
                
                <li><a href="<?=$sess_href?>"><?=$sess_gbn?></a></li>
                <?php
                    if(!$jb_login){
                    ?>
                        <!-- 로그인 세션이 없을 시 체험해보기 메뉴 띄워주기 -->
                        <li><a href="login_ok.php?test_login=test">체험해보기</a></li>
                    <?php
                    }
                ?>
                <li><a href="list_category.php">카테고리 관리</a></li>
            </ul>
        </div>
    </header>
    <aside>
        <ul class="category-menu">
            <?php

            if($sess_user_idx){
            // 카테고리 목록
                $query = "SELECT * FROM category WHERE user_idx='$sess_user_idx'  AND user_id = '$sess_user_id' AND user_key<>'1' order by user_seq asc";
                $result = db_fetch_arr($query);

                // 카테고리 메뉴 생성
        
                foreach ($result as $row){
                    $category = $row['category'];
                    $encode_cate = base64_encode($category);
                    echo "<li><a href='todo_list.php?user_key=".$row['user_key']."&category=".$encode_cate."'>".$row['category']."</a></li>";
                }

                $etc_qry = "SELECT * FROM todo where cate_idx='1'";
                $etc = db_fetch_arr($etc_qry);
                $etc_cnt = count($etc);
                if($etc_cnt>0){
                    echo "<li><a href=''>미분류</a></li>";
                }
            }
            ?>
        </ul>
    </aside>
    <main>