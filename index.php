<?php
    include "header.php";

if($jb_login){
?>
<div class="container">
    <h2>main</h2>
</div>
<?php } else { ?>
<div class="container">
    <iframe name="iframe" src="login.php" class="login_frame"></iframe>
</div>
<?php }
include "footer.php";
?>