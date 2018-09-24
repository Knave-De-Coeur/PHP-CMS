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
                    $query = "SELECT * FROM posts WHERE Status = 'published' ORDER BY Id DESC;";
                    $select_al_published_categories_query = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_al_published_categories_query) > 0) {

                        while($row = mysqli_fetch_assoc($select_al_published_categories_query)) {
                            $post_id = $row['Id'];
                            $post_title = $row['Title'];
                            $post_author = $row['Author'];
                            $post_date = $row['Date'];
                            $post_image = $row['Image'];
                            $post_content = substr($row['Content'], 0, 50);
                            $post_status = $row['Status'];




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
                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
                            }
                        } else {
                            echo "<h1>No Posts to show</h1>";
                        }
                ?>




            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>