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

                if(isset($_GET['category'])) {
                    $post_category_id = $_GET['category'];

                    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                        $query = "SELECT * FROM posts WHERE Post_Category_Id = $post_category_id; ";
                    } else {
                        $query = "SELECT * FROM posts WHERE Post_Category_Id = $post_category_id AND Status = 'published'; ";
                    }


                    $select_all_categories_query = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_all_categories_query) < 1) {
                        echo "<h1 class='text-center'>No Posts to show</h1>";
                    } else {


                        while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                            $post_id = $row['Id'];
                            $post_title = $row['Title'];
                            $post_author = $row['Author'];
                            $post_date = $row['Date'];
                            $post_image = $row['Image'];
                            $post_content = substr($row['Content'], 0, 50);

                            ?>

                            <h1 class="page-header">

                                <small>Secondary Text</small>
                            </h1>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $post_author; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span
                                        class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>

                            <?php
                        }
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