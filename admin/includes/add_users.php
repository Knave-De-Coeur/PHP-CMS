<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:57
 */
if(isset($_POST['create_user'])) {
    $user_username     = escape($_POST['username']);
    $user_firstname    = $_POST['first_name'];
    $user_lastname     = addslashes($_POST['last_name']);
    $user_role         = $_POST['user_role'];
    $user_email        = $_POST['email'];
    $user_password     = $_POST['password'];

    $user_image        = $_FILES['user_image']['name'];
    $user_image_temp   = $_FILES['user_image']['tmp_name'];

    // 10 because we're already in admin
    $user_password      = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );

    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "INSERT INTO users (firstname, lastname, username, role, Image, email, password)
              VALUES ('$user_firstname', '$user_lastname', '$user_username', '$user_role', '$user_image', '$user_email', '$user_password'); ";


    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

    $the_last_inserted_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>User Created! <a href='users.php?source=edit_user&u_id=$the_last_inserted_id'>Edit User</a> -Or- <a href='users.php'>Edit Other Users</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">



    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="first_name">
    </div>

    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" name="last_name">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">User Role</option>
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file"  name="user_image">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password">
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>


</form>