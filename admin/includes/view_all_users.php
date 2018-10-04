<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:50
 */

if(isset($_GET['delete'])) {

    if(isset($_SESSION['user_role'])) {

        if($_SESSION['user_role'] == 'admin') {

            $user_id = mysqli_real_escape_string($connection, $_GET['delete']);

            $query = "DELETE FROM users WHERE Id = " . $user_id;
            $query_delete_user_by_id = mysqli_query($connection, $query);
            confirmQuery($query_delete_user_by_id);

            header("Location: users.php");
        }
    }

}

if(isset($_GET['change_to_admin']))
{
    $user_id = $_GET['change_to_admin'];

    $query = "UPDATE users SET role = 'admin' WHERE Id = $user_id; ";

    $query_upadate_user_to_admin = mysqli_query($connection, $query);

    confirmQuery($query_upadate_user_to_admin);
}
else if (isset($_GET['change_to_sub']))
{
    $user_id = $_GET['change_to_sub'];

    $query = "UPDATE users SET role = 'subscriber' WHERE Id = $user_id; ";

    $query_upadate_user_to_subscriber = mysqli_query($connection, $query);

    confirmQuery($query_upadate_user_to_subscriber);
}

?>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Image</th>
        <th>Admin</th>
        <th>Subscriber</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php

    GetAllUsersAndOutputRow();

    ?>
    </tbody>
</table>