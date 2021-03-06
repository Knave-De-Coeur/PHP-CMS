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

                if (isset($_POST['submit'])) {
                    $searchValue = $_POST['search'];

                    $query = "SELECT * FROM posts WHERE Tags LIKE '%$searchValue%'; ";

                    $searchQuery = mysqli_query($connection, $query);

                    if (!$searchQuery) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($searchQuery);

                    if ($count == 0) {
                        echo "<h3> No Result </h3>";
                    } else {
                        while ($row = mysqli_fetch_assoc($searchQuery)) {
                            $post_title = $row['Title'];
                            $post_author = $row['Author'];
                            $post_date = $row['Date'];
                            $post_image = $row['Image'];
                            $post_content = $row['Content'];

                            ?>

                            <h1 class="page-header">

                                <small>Secondary Text</small>
                            </h1>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="#"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $post_author; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span
                                        class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>

                            <?php
                        }
                    }
                }
                ?>




            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>