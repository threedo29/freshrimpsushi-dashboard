<?php
include_once("_common.php");
include_once("_db_config.php");

if(isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];
}
if(isset($_POST['admin_password'])) {
    $admin_password = $_POST['admin_password'];
}

$connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (mysqli_connect_errno()) {
    echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
} else {
    $query = "SELECT *
              FROM `admin`
              WHERE `admin_id` = '{$admin_id}';";
    $result = mysqli_query($connect_db, $query);

    $rows = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($rows, array(
            "admin_password" => $row["admin_password"],
            "admin_name" => $row["admin_name"]
        ));
    }

    if (password_verify($admin_password, $rows[0]["admin_password"])) {
        $query2 = "UPDATE `admin`
                   SET `last_access` = NOW()
                   WHERE `admin_id` = '{$admin_id}';";
        mysqli_query($connect_db, $query2);
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $rows[0]["admin_name"];
        echo "<script>location.replace('". DASHBOARD_URL ."');</script>";
    } else {
        echo "<script>alert('아이디/비밀번호를 확인해주세요.');</script>";
        echo "<script>location.replace('". DASHBOARD_URL ."/login.php');</script>";
    }
    mysqli_close($connect_db);
}

?>