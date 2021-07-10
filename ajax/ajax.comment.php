<?php
include_once("_common.php");
include_once("__db_config.php");

if ($_GET['action'] == "getComment") {
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        if (isset($_POST['cmt_idx'])) {
            $cmt_idx = $_POST['cmt_idx'];
        } else {
            $cmt_idx = 0;
        }

        if($cmt_idx == 0)
        {
            $query1 = "SELECT *
                       FROM `comment`
                       WHERE `is_deleted` = 0
                       ORDER BY `datetime` DESC;";
            $result1 = mysqli_query($connect_db, $query1);

            $rows = array();

            while ($row = mysqli_fetch_array($result1)) {
                if ($row['parent_cmt_idx'] == -1) {
                    array_push($rows, array(
                        "cmt_idx" => $row['cmt_idx'],
                        "board_idx" => $row['board_idx'],
                        "board_slug" => $row['board_slug'],
                        "board_title" => $row['board_title'],
                        "parent_cmt_idx" => $row['parent_cmt_idx'],
                        "child_cnt" => $row['child_cnt'],
                        "child" => array(),
                        "author" => $row['author'],
                        "content" => $row['content'],
                        "datetime" => $row['datetime'],
                        "modify_datetime" => $row['modify_datetime'],
                        "is_deleted" => $row['is_deleted']
                    ));
                }
            }

            $cnt = count($rows);
            for ($i = 0; $i < $cnt; $i++) {
                if ($rows[$i]['child_cnt'] != 0) {
                    $query2 = "SELECT *
                            FROM `comment`
                            WHERE `parent_cmt_idx` = {$rows[$i]['cmt_idx']} AND `is_deleted` = 0
                            ORDER BY `datetime` ASC";
                    $result2 = mysqli_query($connect_db, $query2);

                    while ($row = mysqli_fetch_array($result2)) {
                        array_push($rows[$i]['child'], array(
                            "cmt_idx" => $row['cmt_idx'],
                            "board_idx" => $row['board_idx'],
                            "board_slug" => $row['board_slug'],
                            "board_title" => $row['board_title'],
                            "parent_cmt_idx" => $row['parent_cmt_idx'],
                            "child_cnt" => $row['child_cnt'],
                            "author" => $row['author'],
                            "content" => $row['content'],
                            "datetime" => $row['datetime'],
                            "modify_datetime" => $row['modify_datetime'],
                            "is_deleted" => $row['is_deleted']
                        ));
                    }
                }
            }

            mysqli_close($connect_db);
            echo json_encode(array("msg" => true, "rows" => $rows));
        } else {
            $query1 = "SELECT *
                       FROM `comment`
                       WHERE `is_deleted` = 0 AND `cmt_idx` = {$cmt_idx}
                       ORDER BY `datetime` DESC;";
            $result1 = mysqli_query($connect_db, $query1);
            
            $rows = array();

            while ($row = mysqli_fetch_array($result1)) {
                array_push($rows, array(
                    "cmt_idx" => $row['cmt_idx'],
                    "board_idx" => $row['board_idx'],
                    "board_slug" => $row['board_slug'],
                    "board_title" => $row['board_title'],
                    "parent_cmt_idx" => $row['parent_cmt_idx'],
                    "child_cnt" => $row['child_cnt'],
                    "child" => array(),
                    "author" => $row['author'],
                    "content" => $row['content'],
                    "datetime" => $row['datetime'],
                    "modify_datetime" => $row['modify_datetime'],
                    "is_deleted" => $row['is_deleted']
                ));
            }

            mysqli_close($connect_db);
            echo json_encode(array("msg" => true, "rows" => $rows));
        }
    }
}
else if ($_GET['action'] == "deleteComment") {
    if(isset($_POST['cmt_idx'])) {
        $cmt_idx = $_POST['cmt_idx'];
    }
    
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    
    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        $query1 = "UPDATE `comment`
                   SET `is_deleted` = '1'
                   WHERE `cmt_idx` = {$cmt_idx} OR `parent_cmt_idx` = {$cmt_idx};";
        mysqli_query($connect_db, $query1);
        
        mysqli_close($connect_db);
        echo json_encode(array("msg" => true));
    }
}
else if ($_GET['action'] == "writeReComment") {
    if (isset($_POST['admin_id'])) {
        $admin_id = $_POST['admin_id'];
    }
    if (isset($_POST['cmt_idx'])) {
        $cmt_idx = $_POST['cmt_idx'];
    }
    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $content = str_replace("\\", "\\\\", $content);
    }
    $rows1 = array();
    $db_database = "dashboard";
    
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    
    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        $query1 = "SELECT *
                   FROM `admin`
                   WHERE `admin_id` = '{$admin_id}';";
        $result1 = mysqli_query($connect_db, $query1);
        
        while($row = mysqli_fetch_array($result1)) {
            array_push($rows1, array(
                "admin_id" => $row['admin_id'],
                "admin_password" => $row['admin_password'],
                "admin_name" => $row['admin_name']
            ));
        }
        
        mysqli_close($connect_db);
    }
    
    $db_database = "hugo_freshrimpsushi";
    
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    
    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        $query2 = "SELECT *
                   FROM `comment`
                   WHERE `cmt_idx` = {$cmt_idx};";
        $result2 = mysqli_query($connect_db, $query2);
        
        $rows2 = array();
        
        while($row = mysqli_fetch_array($result2)) {
            array_push($rows2, array(
                "cmt_idx" => $row['cmt_idx'],
                "board_idx" => $row['board_idx'],
                "board_slug" => $row['board_slug'],
                "board_title" => $row['board_title'],
                "parent_cmt_idx" => $row['parent_cmt_idx'],
                "child_cnt" => $row['child_cnt'],
                "author" => $row['author'],
                "password" => $row['password'],
                "content" => $row['content'],
                "datetime" => $row['datetime'],
                "modify_datetime" => $row['modify_datetime'],
                "is_deleted" => $row['is_deleted']
            ));
        }
        
        $query3 = "INSERT INTO `comment` (`board_idx`, `board_slug`, `board_title`, `parent_cmt_idx`, `author`, `password`, `content`)
                   VALUE ('{$rows2[0]['board_idx']}', \"{$rows2[0]['board_slug']}\", \"{$rows2[0]['board_title']}\", '{$cmt_idx}', '{$rows1[0]["admin_name"]}', '{$rows1[0]["admin_password"]}', '{$content}');";
        mysqli_query($connect_db, $query3);
        
        $query4 = "UPDATE `comment`
                   SET `child_cnt` = `child_cnt` + 1
                   WHERE `cmt_idx` = {$cmt_idx}";
        mysqli_query($connect_db, $query4);
        
        mysqli_close($connect_db);
        echo json_encode(array("msg" => true, "rows1" => $rows1, "rows2" => $rows2, "query1" => $query1, "query2" => $query2, "query3" => $query3, "query4" => $query4));
    }
}
else if ($_GET['action'] == "modifyComment") {
    if (isset($_POST['cmt_idx'])) {
        $cmt_idx = $_POST['cmt_idx'];
    }
    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $content = str_replace("\\", "\\\\", $content);
    }
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
    
    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        $query1 = "UPDATE `comment`
                   SET `content` = '{$content}', `modify_datetime` = NOW()
                   WHERE `cmt_idx` = {$cmt_idx};";
        mysqli_query($connect_db, $query1);

        mysqli_close($connect_db);
        echo json_encode(array("msg" => true));
    }
}
else if($_GET['action'] == "getAllComment") {
    $connect_db = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    if (mysqli_connect_errno()) {
        echo "MySQL 연결에 실패하였습니다 : " . mysqli_connect_error();
    } else {
        $query1 = "SELECT *
                   FROM `comment`
                   WHERE `is_deleted` = 0
                   ORDER BY `datetime` DESC;";
        $result1 = mysqli_query($connect_db, $query1);

        $rows = array();

        while ($row = mysqli_fetch_array($result1)) {
            if ($row['parent_cmt_idx'] == -1) {
                array_push($rows, array(
                    "cmt_idx" => $row['cmt_idx'],
                    "board_idx" => $row['board_idx'],
                    "board_slug" => $row['board_slug'],
                    "board_title" => $row['board_title'],
                    "parent_cmt_idx" => $row['parent_cmt_idx'],
                    "child_cnt" => $row['child_cnt'],
                    "child" => array(),
                    "author" => $row['author'],
                    "content" => $row['content'],
                    "datetime" => $row['datetime'],
                    "modify_datetime" => $row['modify_datetime'],
                    "is_deleted" => $row['is_deleted']
                ));
            }
        }

        $cnt = count($rows);
        for ($i = 0; $i < $cnt; $i++) {
            if ($rows[$i]['child_cnt'] != 0) {
                $query2 = "SELECT *
                           FROM `comment`
                           WHERE `parent_cmt_idx` = {$rows[$i]['cmt_idx']} AND `is_deleted` = 0
                           ORDER BY `datetime` ASC";
                $result2 = mysqli_query($connect_db, $query2);

                while ($row = mysqli_fetch_array($result2)) {
                    array_push($rows[$i]['child'], array(
                        "cmt_idx" => $row['cmt_idx'],
                        "board_idx" => $row['board_idx'],
                        "board_slug" => $row['board_slug'],
                        "board_title" => $row['board_title'],
                        "parent_cmt_idx" => $row['parent_cmt_idx'],
                        "child_cnt" => $row['child_cnt'],
                        "author" => $row['author'],
                        "content" => $row['content'],
                        "datetime" => $row['datetime'],
                        "modify_datetime" => $row['modify_datetime'],
                        "is_deleted" => $row['is_deleted']
                    ));
                }
            }
        }

        mysqli_close($connect_db);
        echo json_encode(array("msg" => true, "rows" => $rows));
    }
}

?>