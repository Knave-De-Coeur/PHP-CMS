<?php include "includes/admin_header.php"; ?>

<?php

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '$username'; ";

    $query_user_username = mysqli_query($connection, $query);

    confirmQuery($query_user_username);

    while($row = mysqli_fetch_assoc($query_user_username)) {
        $user_id = $row['Id'];
        $user_username = $row['username'];
        $user_password = $row['password'];
        $user_firstname = $row['firstname'];
        $user_lastname = $row['lastname'];
        $user_role = $row['role'];
        $user_email = $row['email'];
        $user_image = $row['image'];
    }
}

if(isset($_POST['update_user'])) {
    $user_username     = addslashes($_POST['username']);
    $user_firstname    = $_POST['first_name'];
    $user_lastname     = addslashes($_POST['last_name']);
    $user_role         = $_POST['user_role'];
    $user_email        = $_POST['email'];
    $user_password     = $_POST['password'];

    $user_image        = $_FILES['user_image']['name'];
    $user_image_temp   = $_FILES['user_image']['tmp_name'];


    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "UPDATE users SET firstname='$user_firstname', lastname='$user_lastname', username = '$user_username',
                                email='$user_email', role='$user_role',image='$user_image'
              WHERE username = '$username'; ";

    $update_user_query = mysqli_query($connection, $query);

    confirmQuery($update_user_query);

}

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin!
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $user_firstname; ?>">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $user_lastname; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user_email; ?>">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $user_username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" value="<?php echo $user_password; ?>">
                        </div>

                        <div class="form-group">
                            <label for="user_role">Role</label>
                            <select name="user_role" id="">
                                <option value="subscriber"><?php echo $user_role; ?></option>

                                <?php

                                if($user_role == 'admin')
                                {
                                    echo "<option value='subscriber'>subscriber</option>";
                                }
                                else
                                {
                                    echo "<option value='admin'>admin</option>";
                                }

                                ?>
                            </select>
                        </div>

                        <!--    <div class="form-group">-->
                        <!--        <select name="post_status" id="">-->
                        <!--            <option value="draft">Post Status</option>-->
                        <!--            <option value="published">Published</option>-->
                        <!--            <option value="draft">Draft</option>-->
                        <!--        </select>-->
                        <!--    </div>-->



                        <div class="form-group">
                            <img width="100" src="../images/<?php echo $user_image; ?>" alt="">
                            <label for="user_image">Post Image</label>
                            <input type="file"  name="user_image">
                        </div>



                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                        </div>


                    </form>


                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>
