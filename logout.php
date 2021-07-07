<?php
include_once("common.php");

session_unset();
session_destroy();

echo "<script>alert('로그아웃 하셨습니다.');</script>";
echo "<script>location.replace('" . DASHBOARD_URL . "/login.php');</script>";

?>