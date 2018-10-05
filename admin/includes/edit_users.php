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
        $user_email        = $row['email'];
        $user_password     = $row['password'];
        $user_image        = $row['image'];
    }


    if(isset($_POST['update_user']))
    {
        $user_username     = addslashes($_POST['username']);
        $user_firstname    = $_POST['first_name'];
        $user_lastname     = addslashes($_POST['last_name']);
        $user_email        = $_POST['email'];
        $user_password     = $_POST['password'];

        $user_image        = $_FILES['user_image']['name'];
        $user_image_temp   = $_FILES['user_image']['tmp_name'];


        move_uploaded_file($user_image_temp, "../images/$user_image");

        if(!empty($user_password)) {
            $query_password = "SELECT password FROM users WHERE Id = $user_id; ";
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);

            $row = mysqli_fetch_array($get_user_query);

            $db_user_password = $row['password'];

            if($db_user_password != $user_password) {

                $hashed_pasword = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
            }

            $query = "UPDATE users SET firstname='$user_firstname', lastname='$user_lastname', username = '$user_username',
                                    email='$user_email',image='$user_image', password='$hashed_pasword'
                  WHERE Id = $user_id; ";

            $update_user_query = mysqli_query($connection, $query);

            confirmQuery($update_user_query);

            echo "<p class='bg-success'>User Updated! <a href='users.php'>Edit Other Users</a></p>";
        } else {
            echo "<p class='bg-warning'>Pasword Cannot be empty!</p>";
        }

    }
} else {
    header("Location: index.php");
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
        <input autocomplete="off" type="password" class="form-control" name="password">
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