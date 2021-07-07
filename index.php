<?php include_once("head.php"); ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    goto_url(DASHBOARD_URL . "/login.php");
} else {
    goto_url(DASHBOARD_URL . "/comment.php");
}
?>

<?php include_once("footer.php"); ?>