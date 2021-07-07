<?php include_once("head.php"); ?>

<?php
if (!isset($_SESSION['admin_id'])) {
    goto_url(DASHBOARD_URL . "/login.php");
}
?>

<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
            <a href="<?php echo DASHBOARD_URL; ?>" class="simple-text logo-normal">생새우초밥집 관리창고</a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item active ">
                    <a class="nav-link" href="./comment.php">
                        <i class="material-icons">library_books</i>
                        <p>포스트댓글</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./main.php">
                        <i class="material-icons">library_books</i>
                        <p>메인페이지댓글</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./categories.php">
                        <i class="material-icons">library_books</i>
                        <p>카테고리댓글</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./404page.php">
                        <i class="material-icons">library_books</i>
                        <p>404페이지댓글</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./all_comment.php">
                        <i class="material-icons">library_books</i>
                        <p>전체댓글</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:;">포스트댓글</a>
                </div>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">Account</p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="<?php echo DASHBOARD_URL . '/logout.php'; ?>">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">전체 댓글</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <colgroup>
                                            <col width="5%">
                                            <col width="7%">
                                            <col width="45%">
                                            <col width="23%">
                                            <col width="*">
                                            <col width="*">
                                        </colgroup>
                                        <thead class=" text-primary">
                                            <th>순번</th>
                                            <th>댓글작성자</th>
                                            <th>내용</th>
                                            <th>글제목</th>
                                            <th>작성일자</th>
                                            <th>바로이동</th>
                                        </thead>
                                        <tbody class="comment-tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let tbl_rows = new Object();

    function goto_url(slug, cmt_idx) {
        console.log(slug);
        console.log(cmt_idx);
        window.open('https://freshrimpsushi.github.io/posts/' + slug + '#comment' + cmt_idx, '_blank');
    }

    function modify_comment(cmt_idx, is_child) {
        let author = $(".comment" + cmt_idx + " .author").html();
        let content = $(".comment" + cmt_idx + " .content p").html();
        let textarea = $(".comment" + cmt_idx + " .content");
        let str = '';
        str += '<input type="hidden" value="' + content + '">';
        str += '<textarea name="comment" value="" placeholder="내용" style="IME-MODE:active;">' + content + '</textarea>';
        str += '<div class="btn_modify" onclick="modify_comment_cancel(' + cmt_idx + ', ' + is_child + ');">취소</div>';
        str += '<div class="btn_modify" onclick="modify_comment_click(' + cmt_idx + ');">수정</div>';
        textarea.html(str);
    }

    function delete_comment(cmt_idx) {
        $.messager.confirm({
            title: "경고",
            msg: "정말 삭제하시겠습니까?",
            fn: function(r) {
                if (r) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo AJAX_URL; ?>/ajax.comment.php?action=deleteComment",
                        data: {
                            cmt_idx: cmt_idx
                        },
                        dataType: "json",
                        success: function(data) {
                            let msg = data['msg'];
                            if (msg) {
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    }

    function re_comment(cmt_idx) {
        let cmt = $('.comment' + cmt_idx).offset();
        $('html, body').animate({
            scrollTop: cmt.top
        }, 400);
        let content = $('.comment' + cmt_idx + ' .content');
        $('.comment' + cmt_idx + ' .content .re-comment-btn').remove();

        let str = "";
        str += '<textarea name="comment" value="" placeholder="내용" style="IME-MODE:active;"></textarea>';
        str += '<div>';
        str += '<div class="re-comment-cancel" onclick="re_comment_cancel(' + cmt_idx + ');">취소</div>';
        str += '<div class="re-comment-click" onclick="re_comment_click(' + cmt_idx + ');">답글</div>';
        str += '</div>';
        content.append(str);
        str = "";
    }

    function re_comment_cancel(cmt_idx) {
        let content = $('.comment' + cmt_idx + ' .content');
        $('.comment' + cmt_idx + ' .content textarea').remove();
        $('.comment' + cmt_idx + ' .content div').remove();
        let str = "";
        str += '<div class="re-comment-btn" onclick="re_comment(' + cmt_idx + ');">답글</div>';
        content.append(str);
        str = "";
    }

    function modify_comment_cancel(cmt_idx, is_child) {
        let textarea = $(".comment" + cmt_idx + " .content");
        let content = $('.comment' + cmt_idx + ' .content input[type=hidden]').val();
        let str = "";
        str += '<p>' + content + '</p>';
        if (!is_child) {
            str += '<div class="re-comment-btn" onclick="re_comment(' + cmt_idx + ');">답글</div>';
        }
        textarea.html(str);
    }

    function modify_comment_click(cmt_idx) {
        $.messager.confirm({
            title: "경고",
            msg: "정말 수정하시겠습니까?",
            fn: function(r) {
                if (r) {
                    let content = $('.comment' + cmt_idx + ' .content textarea').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo AJAX_URL; ?>/ajax.comment.php?action=modifyComment",
                        data: {
                            cmt_idx: cmt_idx,
                            content: content
                        },
                        dataType: "json",
                        success: function(data) {
                            let msg = data['msg'];
                            console.log(msg);
                            if (msg) {
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
    }

    function re_comment_click(cmt_idx) {
        let content = $('.comment' + cmt_idx + ' .content textarea').val();
        let admin_id = "<?php echo $_SESSION['admin_id']; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo AJAX_URL; ?>/ajax.comment.php?action=writeReComment",
            data: {
                cmt_idx: cmt_idx,
                admin_id: admin_id,
                content: content
            },
            dataType: "json",
            success: function(data) {
                let msg = data['msg'];
                console.log(msg);
                if (msg) {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo AJAX_URL; ?>/ajax.comment.php?action=getComment",
            data: {},
            dataType: "json",
            success: function(data) {
                let msg = data['msg'];
                let rows = data['rows'];
                let tbody = $('.comment-tbody');
                let str = "";

                if (msg) {
                    // 원댓글
                    for (let i = 0; i < rows.length; i++) {
                        str += '<tr class="parent comment comment' + rows[i]["cmt_idx"] + '">';
                        str += '<td class="index">' + (i + 1) + '</td>';
                        str += '<td class="author">' + rows[i]["author"] + '</td>';
                        str += '<td class="content"><p>' + rows[i]["content"] + '</p><div class="re-comment-btn" onclick="re_comment(' + rows[i]["cmt_idx"] + ');">답글</div></td>';
                        str += '<td class="board_title">' + rows[i]["board_title"] + '</td>';
                        str += '<td class="datetime">' + rows[i]["datetime"] + '</td>';
                        str += '<td class="url">' + '<div class="url-button" onclick="goto_url(\'' + rows[i]["board_slug"] + '\', ' + rows[i]["cmt_idx"] + ');">이동</div>';
                        str += '<div class="url-button" onclick="delete_comment(' + rows[i]["cmt_idx"] + ');">삭제</div><div class="modify-button" onclick="modify_comment(' + rows[i]["cmt_idx"] + ', 0);">수정</div></td>';
                        str += '</tr>';
                        tbody.append(str);
                        str = "";
                        // 대댓글
                        for (let j = 0; j < rows[i]['child'].length; j++) {
                            str += '<tr class="child comment comment' + rows[i]["child"][j]["cmt_idx"] + '">';
                            str += '<td class="index">' + (i + 1) + '-' + (j + 1) + '</td>';
                            str += '<td class="author">' + rows[i]["child"][j]["author"] + '</td>';
                            str += '<td class="content"><p>' + rows[i]["child"][j]["content"] + '</p></td>';
                            str += '<td class="board_title">' + rows[i]["child"][j]["board_title"] + '</td>';
                            str += '<td class="datetime">' + rows[i]["child"][j]["datetime"] + '</td>';
                            str += '<td class="url">' + '<div class="url-button" onclick="goto_url(\'' + rows[i]["child"][j]["board_slug"] + '\', ' + rows[i]["child"][j]["cmt_idx"] + ');">이동</div>';
                            str += '<div class="url-button" onclick="delete_comment(' + rows[i]["child"][j]["cmt_idx"] + ');">삭제</div><div class="modify-button" onclick="modify_comment(' + rows[i]["child"][j]["cmt_idx"] + ', 1);">수정</div></td>';
                            str += '</tr>';
                            tbody.append(str);
                            str = "";
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
</script>

<?php include_once("footer.php"); ?>