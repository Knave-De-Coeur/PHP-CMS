<?php include "includes/db_connection.php" ?>

<?php include "includes/header.php"; ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php


            if(isset($_GET['p_id']))
            {
                $post_id = $_GET['p_id'];

                $view_query = "UPDATE posts SET View_Count = View_Count + 1 WHERE Id = $post_id; ";
                $send_query = mysqli_query($connection, $view_query);
                confirmQuery($send_query);

                $query = "SELECT * FROM posts WHERE Id = $post_id; ";
                $select_all_categories_query = mysqli_query($connection, $query);
                confirmQuery($send_query);

                while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $post_id = $row['Id'];
                    $post_title = $row['Title'];
                    $post_author = $row['User_Id'];
                    $post_date = $row['Date'];
                    $post_image = $row['Image'];
                    $post_tags = $row['Tags'];
                    $post_content = $row['Content'];
                    $post_views = $row['View_Count'];

            ?>

                <h1 class="page-header">

                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

                <?php
                }

            ?>

            <!-- Blog Comments -->

            <?php

            if (isset($_POST['create_comment'])) {
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_email)) {
                    $query = "INSERT INTO comments (Post_Id, Author, Email, Content, Date, Status) VALUES 
                              ($post_id, '$comment_author', '$comment_email', '$comment_content', now(), 'unapproved'); ";

                    $query_insert_comment = mysqli_query($connection, $query);

                    confirmQuery($query_insert_comment);


//                    $query = "UPDATE posts SET Comment_Count = Comment_Count + 1 WHERE Id = $post_id";
//                    $update_comment_count = mysqli_query($connection, $query);
//                    confirmQuery($update_comment_count);
                } else {
                    echo "<script>alert('Fields cannot be empty')</script>";
                }
            }

            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="Comment">Your Comment</label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <?php

                $query = "SELECT * FROM comments WHERE Post_Id = $post_id AND Status = 'approved' ORDER BY Id DESC; ";

                $query_approved_post_comments = mysqli_query($connection, $query);

                confirmQuery($query_approved_post_comments);

                while($row = mysqli_fetch_assoc($query_approved_post_comments)){
                    $comment_Id = $row['Id'];
                    $comment_content = $row['Content'];
                    $comment_author = $row['Author'];
                    $comment_date = $row['Date'];
                    $comment_status = $row['Status'];
                    $comment_email = $row['Email'];
                    ?>

                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                <small><?php echo $comment_date; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>
                        </div>
                    </div>

                    <?php
                }
            } else {
                header("Location: index.php");
            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->

    <hr>

<?php include "includes/footer.php"; ?>