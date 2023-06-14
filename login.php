<?php
    include "config/inc_head.php";
    include "config/version.php";
?>
<script src="js/jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="css/login_frame.css?ver=<?=$ver?>">
<div id="login">
    <!-- <span class="close-button">&times;</span> -->
    <table id="login_table">
        <form action="login_ok.php" method="post" name="login_form" target="myframe">
            <input type="hidden" name="login_gbn" value="login">
            <tr>
                <td colspan="2" class="h3"><h3>로그인</h3></td>
            </tr>
            <tr>
                <td><input type="text" id="login_id" name="login_id" placeholder="*아이디"></td>
            </tr>
            <tr>
                <td><input type="text" id="login_pw" name="login_pw" placeholder="*비밀번호"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="id_msg"></div> <!-- 로그인 메시지를 표시할 영역 -->
                </td>
            </tr>
            <tr class="btn_box">
                <td colspan="2">
                    <button type="button" onclick="login_check();">로그인</button>
                    <button type="button" onclick="location.href='reg.php';">회원가입</button>
                </td>
            </tr>
        </form>
    </table>
</div>

<script>

function login_check() {
    let id = $('#login_id').val();
    let pw = $('#login_pw').val();

    let frm = document.login_form;
    if (!login_input_check()) {
        return false;
    }
    //AJAX 요청 보내기
    $.ajax({
        type: 'POST',
        url: 'login_check_ajax.php',
        data: {
            login_id: id,
            login_pw: pw,
            login_gbn : 'login'
        },
        success: function(response) {
            console.log(response);
            if (response == "N") {
                $('#id_msg').html("<span style='color:red;'>아이디 혹은 비밀번호가 맞지 않습니다.</span>"); // 결과를 id_msg div에 표시
                $('#login_id').focus();
            } else if (response == "Y") {
                frm.submit();
            }
        }
    });
}

function login_input_check(){
    let id = $('#login_id');
    let pw = $('#login_pw');

    if (id.val() == "") {
        $('#id_msg').html("<span style='color:red;'>아이디를 입력해주세요.</span>");
        id.focus();
        return false;
    }
    if (pw.val() == "") {
        $('#id_msg').html("<span style='color:red;'>비밀번호를 입력해주세요.</span>");
        pw.focus();
        return false;
    }
    return true;
}

</script>
