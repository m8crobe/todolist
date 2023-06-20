<?php
include "header.php";

if(!$sess_user_idx){                // 로그인하지 않을 시 인덱스 페이지 이동
    echo "<script>alert('로그인하거나 체험해보기를 선택해주세요.')</script>";
    echo "<script>location.href='index.php';</script>";
}

$cate_idx = isset($_REQUEST['cate_idx'])?$_REQUEST['cate_idx']:"";
$user_key = isset($_REQUEST['user_key'])?$_REQUEST['user_key']:"";
$category = isset($_REQUEST['category'])?$_REQUEST['category']:"";
$decode_cate = base64_decode($category);
$user_idx = $sess_user_idx;
$user_id = $sess_user_id;

// 카테고리에 따른 select문

$sql = "SELECT * FROM todo LEFT JOIN category cate ON cate.cate_idx = todo.cate_idx
        WHERE cate.user_idx='$sess_user_idx' AND cate.user_id = '$user_id'";
if($user_key){
    $sql .= "AND cate.user_key='$user_key'";
}
else if($cate_idx){
    $sql .= "AND cate.cate_idx='$cate_idx'";
}

// echo $sql;
$list_rows = db_fetch_arr($sql);

?>
<style>
    .title_box {
        display:flex;
    }
    .title_box h2{
        padding-right:20px;
        width: 350px;
    }
</style>
<div class="container">
    <form id="todo_form" name="todo_form" method="post" action="list_cate_process.php">
    <div class="title_box">
        <h2><?=$decode_cate?></h2>
        <button type="button" onclick="location.href='todo_add.php?user_key=<?=$user_key?>'">추가</button>
        <button>완료목록삭제</button>
        <select>
            <option value="">최신순</option>
            <option value="">오래된순</option>
            <option value="">사용자지정</option>
        </select>
    </div>
        <div class="todo_list">
            <ul id="sortable">
                <?php
                foreach ($list_rows as $row)
                {
                    $comp_check = $row['complete'];
                    $title = $row['title'];
                    $do_idx = $row['do_idx'];
                    ?>
                <a href='todo_add.php?pro=R&do_idx=<?=$do_idx?>'>
                <li class='ui-state-list'><?=$title?></li>
                </a>
                <?php
                }
                ?>
            </ul>
        </div>
    </form>
</div>

<?php
include "footer.php";
?>