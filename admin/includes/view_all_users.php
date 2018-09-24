<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:50
 */

if(isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE Id = " . $user_id;

    $quer_delete_user_by_id = mysqli_query($connection, $query);

    confirmQuery($quer_delete_user_by_id);

    header("Location: users.php");
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
