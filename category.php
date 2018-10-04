<?php include "includes/db_connection.php" ?>

<?php include "includes/header.php"; ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php //include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                if(isset($_GET['category'])) {
                    $post_category_id = $_GET['category'];

                    if(isAdmin($_SESSION['username'])) {

                        $stmt1 = mysqli_prepare($connection,"SELECT posts.Id as postId, Title, User_Id, Date, 
                                                                  posts.Image as postImage, Content, username
                                              FROM posts LEFT JOIN users u on posts.User_Id = u.Id WHERE Post_Category_Id = ? ");
                    } else {

                        $stmt2 = mysqli_prepare($connection,"SELECT posts.Id as postId, Title, User_Id, Date, 
                                                                  posts.Image as postImage, Content, username
                                              FROM posts LEFT JOIN users u on posts.User_Id = u.Id WHERE Post_Category_Id = ? AND Status = ? ");

                        $published = 'published';
                    }

                    if(isset($stmt1)) {

                        mysqli_stmt_bind_param($stmt1, "i", $post_category_id);

                        mysqli_stmt_execute($stmt1);


                        mysqli_stmt_bind_result($stmt1, $Id, $Title, $User_Id, $Date, $Image, $Content, $Username);

                        $stmt = $stmt1;

                    } else if(isset($stmt2)) {

                        mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);

                        mysqli_stmt_execute($stmt2);

                        mysqli_stmt_bind_result($stmt2, $Id, $Title, $User_Id, $Date, $Image, $Content, $Username);

                        $stmt = $stmt2;

                    }


                    mysqli_stmt_store_result($stmt);

//                    $select_all_categories_query = mysqli_query($connection, $query);

                    if(mysqli_stmt_num_rows($stmt) === 0) {
                        echo "<h1 class='text-center'>No Posts to show</h1>";
                    } else {


                        while (mysqli_stmt_fetch($stmt) ) {

                            ?>

                            <h1 class="page-header">

                                <small>Secondary Text</small>
                            </h1>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="post.php?p_id=<?php echo $Id; ?>"><?php echo $Title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="author_post.php?author=<?php echo $User_Id; ?>"><?php echo $Username; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $Date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $Image; ?>" alt="">
                            <hr>
                            <p><?php echo $Content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span
                                        class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>

                            <?php
                        }

                        mysqli_stmt_close($stmt);
                    }
                } else {
                        redirect('index.php');
                }
                ?>




            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>