<?php
    include "config/inc_head.php";
    include "config/version.php";
    include "config/db_connection.php";
?>
<script src="js/jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="css/login_frame.css?ver=<?=$ver?>">
<div id="reg">
    <!-- <span class="close-button">&times;</span> -->
    <table id="reg_table">
        <form action="login_ok.php" method="post" name="reg_form" target="myframe">
            <input type="hidden" name="id_check" value="">
            <input type="hidden" name="login_gbn" value="reg">
            <tr>
                <td colspan="2" class="h3">
                    <h3>회원가입</h3>
                </td>
            </tr>
            <tr>
                <td><input type="text" id="reg_id" name="reg_id" placeholder="*아이디(4~20)"></td>
            </tr>
            <tr>
                <td><input type="password" id="reg_pw" name="reg_pw" placeholder="*비밀번호(3~40)"></td>
            </tr>
            <tr>
                <td><input type="password" id="reg_pw2" name="reg_pw2" placeholder="*비밀번호 재입력"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="id_msg"></div> <!-- 아이디 중복 메시지를 표시할 영역 -->
                </td>
            </tr>
            <tr class="btn_box">
                <td colspan="2">
                    <button type="button" onclick="reg_check();">가입하기</button>
                    <button type="button" onclick="window.history.back()">뒤로가기</button>
                </td>
            </tr>
        </form>
    </table>
</div>
<script>
function reg_check() {
    let id = $('#reg_id').val(); // 입력된 ID 값 가져오기
    let frm = document.reg_form;
    if (!reg_input_check()) {
        return false;
    }
    //AJAX 요청 보내기
    $.ajax({
        type: 'POST',
        url: 'login_check_ajax.php',
        data: {
            reg_id: id,
            login_gbn : 'reg'
        },
        success: function(response) {
            console.log(response);
            if (response == "N") {
                $('#id_msg').html("<span style='color:red;'>이미 존재하는 아이디입니다.</span>"); // 결과를 id_msg div에 표시
                $('#reg_id').focus();
            } else if (response == "Y") {
                frm.submit();
            }
        }
    });
}

function reg_input_check() {
    let id = $('#reg_id');
    let pw1 = $('#reg_pw');
    let pw2 = $('#reg_pw2');
    let idvalcheck = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{4,20}$/;                 // 영문자로 시작하며, 영문자와 숫자가 각 한글자씩 필수 (4~20)
    let pwvalcheck = /^(?!.*["\'])([a-zA-Z0-9!@#$%^&*~.,?_]{3,40})$/;                // "이나 ' 를 제외한 영문/숫자/특문 포함 가능 (3~40)

    if (id.val() == "") {
        $('#id_msg').html("<span style='color:red;'>아이디를 입력해주세요.</span>");
        id.focus();
        return false;
    }
    if (!idvalcheck.test(id.val())) {
        $('#id_msg').html("<span style='color:red;'>아이디는 영소문자와 숫자를 조합한 4~20자입니다.</span>");
        id.focus();
        return false;
    }
    if (pw1.val() == "") {
        $('#id_msg').html("<span style='color:red;'>비밀번호를 입력해주세요.</span>");
        pw1.focus();
        return false;
    }
    if (!pwvalcheck.test(pw1.val())) {
        $('#id_msg').html("<span style='color:red;'>비밀번호에 사용 가능한 특수문자는 !@#$%^&*`~.,?_ 입니다.</span>");
        pw1.focus();
        return false;
    }
    if (pw2.val() == "") {
        $('#id_msg').html("<span style='color:red;'>비밀번호를 입력해주세요.</span>");
        pw2.focus();
        return false;
    }
    if (pw1.val() != pw2.val()) {
        $('#id_msg').html("<span style='color:red;'>비밀번호를 확인하세요.</span>");
        pw2.focus();
        return false;
    }
    return true;
}
</script>