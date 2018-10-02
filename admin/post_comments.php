<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin!
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                </div>
                <?php

                if(isset($_GET['id'])) {
                    $post_id = mysqli_real_escape_string($connection, $_GET['id']);
                }

                    if(isset($_GET['delete'])) {
                        $comment_id = $_GET['delete'];
                        $query = "DELETE FROM comments WHERE Id = " . $comment_id;

                        $query_unapprove_comment = mysqli_query($connection, $query);

                        confirmQuery($query_unapprove_comment);

                        header("Location: post_comments.php?id=" . $post_id . "");
                    }

                    if(isset($_GET['edit'])) {
                        $comment_id = $_GET['edit'];
                        $comment_status = $_GET['status'];
                        $query = "UPDATE comments SET Status='$comment_status' WHERE Id = $comment_id; ";

                        $query_unapprove_comment = mysqli_query($connection, $query);

                        confirmQuery($query_unapprove_comment);

                        header("Location: post_comments.php?id=" . $post_id);
                    }



                ?>

                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>In Response to</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Un-approve</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    GetCommentsAndOutputRow($post_id);

                    ?>
                    </tbody>
                </table>


            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>
