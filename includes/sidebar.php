<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 06/09/2018
 * Time: 15:05
 */
?>



<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>

        </form><!-- search form -->
        <!-- /.input-group -->
    </div>

    <!-- Login Form Well -->
    <div class="well">
        <?php 
        
        if(isset($_SESSION['role'])) {
            ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary"><strong>Log Out</strong></a>
            <?php
        } else {
            ?>
            <h4>Login</h4>
            <form  method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit

                    </button>
                </span>
                </div>
                <div class="form-group">
                    <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                </div>
            </form><!-- login form -->
            <?php
        }
        
        ?> 
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
<!--                    --><?php

                    $query = "SELECT * FROM categories LIMIT 3";
                    $select_categories_sidebar_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_categories_sidebar_query)) {
                        $cat_id = $row['Id'];
                        $cat_title = $row['Title'];
                        echo "<li ><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }

//                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "includes/widget.php"; ?>

</div>

