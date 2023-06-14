<?php
    session_start();

    $jb_login = FALSE;
    $test_login = FALSE;
    $sess_user_idx = "";
    $sess_user_id = "";
    
    if (isset($_SESSION['user_idx'])) {
        $sess_user_idx = $_SESSION['user_idx'];
        $sess_user_id = $_SESSION['user_id'];
        $jb_login = TRUE;
    }

    if (isset($_SESSION['test_login'])){
        $test_login = TRUE;
    }

?>