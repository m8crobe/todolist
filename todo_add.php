<?php
    include "header.php";

    if(!$sess_user_idx){                // 로그인하지 않을 시 인덱스 페이지 이동
        echo "<script>alert('로그인하거나 체험해보기를 선택해주세요.')</script>";
        echo "<script>location.href='index.php';</script>";
    }
    $pro = isset($_REQUEST['pro'])?$_REQUEST['pro']:"I";
    
    $cate_idx = "";
    $category = "";
    $do_idx = isset($_REQUEST['do_idx'])?$_REQUEST['do_idx']:"";
    $user_key = isset($_REQUEST['user_key'])?$_REQUEST['user_key']:"";
    $title = "";
    $content = "";

    if($pro == "I"){
        $select_sql = "SELECT cate_idx, category FROM category WHERE user_idx = '$sess_user_idx' AND user_id = '$sess_user_id' AND user_key='$user_key'";
        
        $find_cate = db_fetch_row($select_sql);
        
        if(!$find_cate){
            echo "<script>alert('잘못된 접근입니다.')</script>";
            echo "<script>window.history.back();</script>";
        }
        else
        {
            $cate_idx = $find_cate['cate_idx'];
            $category = $find_cate['category'];
        }
    }
    else if($pro == "R")
    {
        $sql = "SELECT";
        $sql .= " do_idx, todo.cate_idx, cate.category, title, content, complete, reg_date, up_date";
        $sql .= " FROM todo LEFT JOIN category cate ON cate.cate_idx = todo.cate_idx ";
        $sql .= " WHERE cate.user_idx='$sess_user_idx' and cate.user_id = '$sess_user_id' AND todo.do_idx = '$do_idx'";

        $select_data = db_fetch_row($sql);

        if($select_data){
            $category = $select_data['category'];
            $title = $select_data['title'];
            $content = $select_data['content'];
            $cate_idx = $select_data['cate_idx'];
            $complete = $select_data['complete'];
            $reg_date = $select_data['reg_date'];
            $up_date = $select_data['up_date'];
        }
    }

    if ($pro == "R"){
        $content_attr = 'readonly=true';
        $title_attr = 'readonly=true';
    } else {
        $content_attr = 'placeholder="최대 255byte까지 작성 가능합니다."';
        $title_attr = 'placeholder="최대 65535byte까지 작성 가능합니다."';
    }


?>
<div class="container">
    <h2><?=$category?></h2>
    <div>
        <form action="todo_ok.php" name="todo_form" method="post">
            <input type="hidden" id="pro" name="pro" value="<?=$pro?>">
            <input type="hidden" name="cate_idx" value="<?=$cate_idx?>"><br>
            <input type="hidden" name="do_idx" value="<?=$do_idx?>"><br>
            <label for="title">제목<br><input type="text" id="title" name="title" <?=$title_attr?> value='<?=$title?>' alt="제목입력"></label>
            <br>
            <label>내용</label>
            <br>
            <textarea name="content" id="content" <?=$content_attr?> alt="내용입력"><?=$content?></textarea>
        </form>
        <div class="btn_box">
            <?php if($pro == "I"){ ?>
            <button type="button" onclick="todo_insert()">저장</button>
            <?php } else {?>
            <button type="button" id="insert_btn" onclick="todo_edit();">수정</button>
            <button type="button" onclick="todo_del()">삭제</button>
            <?php } ?>
            <button type="button" onclick="window.history.back();">뒤로가기</button>
        </div>
    </div>
</div>

<style>

</style>

<script>

let pro = document.getElementById("pro");
let frm = document.todo_form;

    function todo_insert(){
        // let pro = document.getElementById("pro");
        // let frm = document.todo_form;

        let conf = confirm("저장하시겠습니까?");
        if(conf){
            pro.value = "I";
            frm.submit();
        }
    }
    function todo_edit(){
        // let pro = document.getElementById("pro");
        // let frm = document.todo_form;

        if(pro.value == "R"){
            $('#title').attr("readonly", false);
            $('#content').attr("readonly", false);
            pro.value = "E";
            title.focus();
        } else if(pro.value == "E"){
            let conf = confirm("수정하시겠습니까?");
            if(conf){
                frm.submit();
            }
        }
    }
    function todo_del(){
        let conf = confirm("삭제하시겠습니까?");
        if(conf){
            pro.value = "D";
            frm.submit();
        }
    }

</script>
<?php
    include "footer.php";
?>