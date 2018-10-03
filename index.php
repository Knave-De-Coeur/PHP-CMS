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
                    $per_page = 2;

                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }

                    if($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    $post_query_count = "SELECT * FROM posts; ";
                    $find_count = mysqli_query($connection, $post_query_count);
                    $pageCount = mysqli_num_rows($find_count);

                    $pageCount = ceil($pageCount / $per_page);

                    // inner join between psot and user
                    $query = "SELECT posts.Id as postId, users.Id as userId, posts.Title, posts.Date, posts.Image, posts.Content, posts.Status, users.username 
                              FROM posts
                              LEFT JOIN users ON posts.User_Id = users.Id 
                              WHERE Status = 'published' ORDER BY posts.Id DESC LIMIT $page_1, $per_page;";
                    $select_al_published_categories_query = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_al_published_categories_query) > 0) {

                        while($row = mysqli_fetch_assoc($select_al_published_categories_query)) {
                            $post_id = $row['postId'];
                            $post_title = $row['Title'];
                            $post_user = $row['userId'];
                            $post_date = $row['Date'];
                            $post_image = $row['Image'];
                            $post_content = substr($row['Content'], 0, 50);
                            $post_status = $row['Status'];

                            $user_username = $row['username'];




                ?>

                <h1 class="page-header">
                    <?php echo $pageCount; ?>
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <?php

                if(!empty($user_username)) {
                    ?>

                    <p class="lead">
                        by <a href="author_post.php?author=<?php echo $post_user; ?>"><?php echo $user_username; ?></a>
                    </p>

                    <?php
                }

                ?>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        </a>
                <hr>
                <p><?php echo $post_content; ?></p>

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

    <ul class="pager">

        <?php

        for($i = 1; $i <= $pageCount; $i++) {
            if($i == $page) {
                echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
            } else {
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
            }
        }

        ?>
    </ul>

<?php include "includes/footer.php"; ?>