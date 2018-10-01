<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:57
 */
if(isset($_GET['u_id'])) {
    $user_id = $_GET['u_id'];

    $query = "SELECT * FROM users WHERE Id = $user_id; ";

    $queryUserById = mysqli_query($connection, $query);

    confirmQuery($queryUserById);

    while($row = mysqli_fetch_assoc($queryUserById)){
        $user_username     = stripslashes($row['username']);
        $user_firstname    = $row['firstname'];
        $user_lastname     = stripslashes($row['lastname']);
        $user_role         = $row['role'];
        $user_email        = $row['email'];
        $user_password     = $row['password'];
        $user_image        = $row['image'];
        $salt              = $row['salt'];
    }

    $user_password = crypt($user_password, $salt);
}

if(isset($_POST['update_user']))
{
    $user_username     = addslashes($_POST['username']);
    $user_firstname    = $_POST['first_name'];
    $user_lastname     = addslashes($_POST['last_name']);
    $user_role         = $_POST['user_role'];
    $user_email        = $_POST['email'];
    $user_password     = $_POST['password'];

    $user_image        = $_FILES['user_image']['name'];
    $user_image_temp   = $_FILES['user_image']['tmp_name'];


    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "SELECT randSalt FROM users";
    $select_randsalt_query = mysqli_query($connection, $query);
    confirmQuery($select_randsalt_query);

    $row = mysqli_fetch_array($select_randsalt_query);
    $salt = $row['randSalt'];

    $hashed_password = crypt($user_password, $salt);

    $query = "UPDATE users SET firstname='$user_firstname', lastname='$user_lastname', username = '$user_username',
                                email='$user_email', role='$user_role',image='$user_image', password='$hashed_password'
              WHERE Id = $user_id; ";

    $update_user_query = mysqli_query($connection, $query);

    confirmQuery($update_user_query);

    echo "<p class='bg-success'>User Updated! <a href='users.php'>Edit Other Posts</a></p>";

}
?>

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
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

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


    <div class="form-group">
        <img width="100" src="../images/<?php echo $user_image; ?>" alt="">
        <label for="user_image">Post Image</label>
        <input type="file"  name="user_image">
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>


</form>