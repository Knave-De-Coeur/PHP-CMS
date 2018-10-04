<?php include "db_connection.php"; ?>
<?php include "functions.php"; ?>
<?php session_start(); ?>

<?php

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    loginUser($username, $password);
}