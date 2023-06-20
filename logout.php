<?php
    include "config/inc_head.php";
?>
<div>
    <input type="hidden" id="test_logout" value="">
    <?php
    $logout_msg = "";

    if ($jb_login && $test_login == false) {
        session_destroy();
        $logout_msg = '로그아웃 하였습니다.';
        
    } else if ($jb_login && $test_login == true){
        
        session_destroy();
            $logout_msg = '로그아웃 하였습니다.';
            // $logout_msg = '입력하셨던 데이터는 모두 삭제되었습니다.';
    }else {
        $logout_msg = '로그인 상태가 아닙니다.';
    }
    
    echo "<script>alert('$logout_msg'); </script>";
    echo "<script>location.href='index.php';</script>";
    ?>
</div>
