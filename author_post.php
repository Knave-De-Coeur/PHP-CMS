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


            if(isset($_GET['author'])) {
                $post_id = $_GET['author'];

                // inner join
                $query = "SELECT posts.Id as postId, posts.Title, posts.Date, posts.Image, posts.Content, posts.Status, users.username 
                          FROM posts
                          INNER JOIN users ON posts.User_Id = users.Id 
                          WHERE Status = 'published' ORDER BY posts.Id DESC; ";

                $select_all_categories_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $post_id = $row['postId'];
                    $post_title = $row['Title'];
                    $post_date = $row['Date'];
                    $post_image = $row['Image'];
                    $post_content = $row['Content'];

                    $user_username = $row['username'];

                    ?>

                    <h1 class="page-header">

                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        All posts by <?php echo $user_username; ?>
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