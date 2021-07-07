<?php
include_once("_common.php");
include_once("_db_config.php");

if(isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];
}
if(isset($_POST['admin_password1'])) {
    $admin_password1 = $_POST['admin_password1'];
}
if(isset($_POST['admin_password2'])) {
    $admin_password2 = $_POST['admin_password2'];
}
if(isset($_POST['admin_name'])) {
    $admin_name = $_POST['admin_name'];
}

if($admin_password1 != $admin_password2) {
    echo "<script>alert('암호를 확인해주세요.');</script>";
    echo "<script>location.replace('".DASHBOARD_URL."/login.php');</script>";
    return;
} else {
    $admin_password = password_hash($admin_password1, PASSWORD_DEFAULT);
}

$connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (mysqli_connect_errno()) {
    echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
} else {
    $query1 = "SELECT *
               FROM `admin`
               WHERE `admin_id` = '{$admin_id}';";
    $result1 = mysqli_query($connect_db, $query1);
    $cnt = mysqli_num_rows($result1);

    if($cnt > 0) {
        echo "<script>alert('이미 존재하는 아이디입니다.');</script>";
        echo "<script>location.replace('" . DASHBOARD_URL . "/login.php');</script>";
    } else {
        $query2 = "INSERT INTO `admin` (`admin_id`, `admin_password`, `admin_name`)
                   VALUES ('{$admin_id}', '{$admin_password}', '{$admin_name}');";
        mysqli_query($connect_db, $query2);

        echo "<script>alert('가입이 완료되었습니다.');</script>";
        echo "<script>location.replace('" . DASHBOARD_URL . "/login.php');</script>";
    }
    mysqli_close($connect_db);
}

?>