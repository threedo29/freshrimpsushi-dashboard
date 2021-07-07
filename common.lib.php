<?php
function goto_url($url) {
    $url = str_replace("&amp;", "&", $url);
    echo "<script>location.replace('{$url}');</script>";

    exit;
}

function alert_msg($msg) {
    echo "<script>alert('{$msg}');</script>";
}
?>