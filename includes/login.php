<?php include "db_connection.php"; ?>
<?php session_start(); ?>
<?php include "functions.php"; ?>

<?php

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validate
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username='$username';";

    $query_user_by_username = mysqli_query($connection, $query);

    confirmQuery($query_user_by_username);

    if(mysqli_num_rows($query_user_by_username) < 1) {
        echo "No account with that username was found.";
    } else {

        while($row = mysqli_fetch_assoc($query_user_by_username)) {
            $db_user_id = $row['Id'];
            $db_user_username = $row['username'];
            $db_user_password = $row['password'];
            $db_user_firstname = $row['firstname'];
            $db_user_lastname = $row['lastname'];
            $db_user_role = $row['role'];

        }

        $password = crypt($password, $db_user_password);

        if($username === $db_user_username && $password === $db_user_password) {
            $_SESSION['username'] = $db_user_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['role'] = $db_user_role;

            header("Location: ../admin/index.php");
        } else {
            header("Location: ../index.php");
        }
    }
}