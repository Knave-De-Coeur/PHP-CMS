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


            if(isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];
                $post_author = $_GET['author'];

                $query = "SELECT * FROM posts WHERE Author = '$post_author' AND Status = 'published'; ";
                $select_all_categories_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $post_id = $row['Id'];
                    $post_title = $row['Title'];
                    $post_date = $row['Date'];
                    $post_image = $row['Image'];
                    $post_content = $row['Content'];

                    ?>

                    <h1 class="page-header">

                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        All posts by <?php echo $post_author; ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>

                    <hr>

                    <?php
                }
            }

            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
    </div>
    <!-- /.row -->

<?php include "includes/footer.php"; ?>