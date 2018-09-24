<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 11/09/2018
 * Time: 12:50
 */

if(isset($_GET['delete'])) {
    $comment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE Id = " . $comment_id;

    $query_unapprove_comment = mysqli_query($connection, $query);

    confirmQuery($query_unapprove_comment);

    header("Location: comments.php");
}

if(isset($_GET['edit'])) {
    $comment_id = $_GET['edit'];
    $comment_status = $_GET['status'];
    $query = "UPDATE comments SET Status='$comment_status' WHERE Id = $comment_id; ";

    $query_unapprove_comment = mysqli_query($connection, $query);

    confirmQuery($query_unapprove_comment);

    header("Location: comments.php");
}

?>

<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Un-approve</th>
        <th>Delete</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    GetAllCommentsAndOutputRow();

    ?>
    </tbody>
</table>
