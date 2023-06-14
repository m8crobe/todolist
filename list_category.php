<?php
include "header.php";

if(!$sess_user_idx){                // 로그인하지 않을 시 인덱스 페이지 이동
    echo "<script>alert('로그인하거나 체험해보기를 선택해주세요.')</script>";
    echo "<script>location.href='index.php';</script>";
}

// 카테고리 목록
$sql = "SELECT * FROM category where user_idx = '$sess_user_idx' AND user_id = '$sess_user_id' AND user_key<>'1' order by user_seq asc";
$categories = db_fetch_arr($sql);
$cate_cnt = count($categories);
?>

<div class="container">
    <h2>카테고리 관리</h2>
    <form id="category_form" name="category_form" method="post" action="list_category_ok.php">
        <input type="hidden" id="pro" name="pro" value="I">
        <input type="hidden" id="e_pk" name="e_pk" value="">
        <div class="cate">
            <!-- <label for="category_name">카테고리명</label> -->
            <input type="text" id="category_name" name="category_name" placeholder="카테고리 이름을 입력하세요">
            <button type="button" id="submit_btn" onclick="return insert_cate();">등록</button>
        </div>
        <div class="category-list">
            <ul id="sortable">
                <?php
                foreach ($categories as $row)
                {
                    ?>
                <li class='ui-state-default'>
                    <span class='cate_name'><?=$row['category']?></span>
                    <span class='btn_box'><input type='hidden' class='cate_idx' name='cate_idx[]'
                            value=<?=$row['cate_idx']?>>
                        <button type='button' onclick='edit_cate(this)'>수정</button><button type='button'
                            onclick='del_cate(this);'>삭제</button></span>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <button type="button" onclick="change_order()">순서변경</button>

        <!-- 삭제 알림창 띄우기 -->
        <div id="del_confirm" class="confirm_box">
            <p><span id="del_cate_name"></span>의 데이터는 미분류로 이동됩니다.</p>
            <p>삭제하시겠습니까?</p>
            <label>
                <input type="checkbox" id="checkbox" name="all_del_check" value="true"> 데이터 함께 삭제
            </label>
            <div class="btn_box">
                <button type="button" onclick="del_confirm()">삭제</button>
                <button type="button" onclick="del_cancle()">취소</button>
            </div>
        </div>
    </form>
</div>


<script>
function check_name() {
    let category_name = document.getElementById("category_name");
    if (category_name.value == "") {
        alert("카테고리 이름을 입력해주세요.");
        return false;
    }
    return true;
}

function insert_cate() {
    let pro = document.getElementById("pro");
    let frm = document.category_form;
    if (!check_name()) {
        return false;
    }
    frm.submit();
}

// function del_cate(This){
//     let pro = document.getElementById("pro");
//     let e_pk = document.getElementById("e_pk");
//     let frm = document.category_form;
//     pro.value = "D";
//     e_pk.value = $(This).closest('li').find(".cate_idx").val();

//     frm.submit();
// }

//////////////////////////////
function del_cate(This) {
    let pro = document.getElementById("pro");
    let e_pk = document.getElementById("e_pk");
    let del_cate_name = document.getElementById("del_cate_name");
    // let frm = document.category_form;
    pro.value = "D";
    e_pk.value = $(This).closest('li').find(".cate_idx").val();
    del_cate_name.innerHTML = $(This).closest('li').find(".cate_name").html();

    // 확인창 띄우기
    var thisOffset = $(This).offset();
    var del_confirm = $('#del_confirm');
    var del_confirmW = del_confirm.width() - 250;
    var del_confirmH = del_confirm.height() / 2;
    del_confirm.css({
        'left': thisOffset.left - del_confirmW,
        'top': thisOffset.top - del_confirmH
    });
    del_confirm.show();

}

function del_confirm() {
    let frm = document.category_form;
    frm.submit();
}

function del_cancle() {
    location.reload();
}

function edit_cate(This) {
    let pro = document.getElementById("pro");
    let frm = document.category_form;
    let e_pk = document.getElementById("e_pk");
    let category_name = document.getElementById("category_name");
    category_name.value = $(This).closest('li').find(".cate_name").html();
    document.getElementById("submit_btn").innerHTML = "수정";
    pro.value = "E";
    e_pk.value = $(This).closest('li').find(".cate_idx").val();
}

function change_order() {
    let conf = confirm("순서를 변경하시겠습니까?");
    if(conf){
        let pro = document.getElementById("pro");
        let frm = document.category_form;
        pro.value = "O";
        frm.submit();
    }
}
$(function() {
    $("#sortable").sortable({
        revert: true
    });
    $("#draggable").draggable({
        connectToSortable: "#sortable",
        helper: "clone",
        revert: "invalid"
    });
    $("#sortable, #draggable").disableSelection();
});
</script>


<?php
include "footer.php";
?>