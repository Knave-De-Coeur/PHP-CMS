<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 06/09/2018
 * Time: 15:03
 */
?>


<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Start Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_title = $row['Title'];
                    $cat_id = $row['Id'];

                    $category_class = "";

                    $registration_class = "";

                    $contact_class = "";

                    $pageName = basename($_SERVER['SCRIPT_NAME']);

                    $registration = 'registration.php';
                    $contact = 'contact.php';
                    $login = 'login.php';

                    if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if ($pageName == $registration) {
                        $registration_class = 'active';
                    } else if ($pageName == $contact) {
                        $contact_class = 'active';
                    }

                    echo "<li class='$category_class'><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }

                ?>

                <?php if(isLoggedIn()): ?>

                    <li><a href='admin/index.php'>Admin</a></li>
                    <li><a href='includes/logout.php'>Logout</a></li>


                <?php else: ?>

                    <li><a href='login.php'>Login</a></li>


                <?php endif; ?>


                <?php

                if(isset($_GET['p_id'])) {
                    $post_Id = $_GET['p_id'];
                    echo "<li><a href='admin/posts.php?source=edit_post&p_id=$post_Id'>Edit Post</a></li>";
                }

                echo "<li class='$registration_class'><a href='registration.php'>Register</a></li>";
                ?>
                <li class="<?php echo $contact_class; ?>"><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
