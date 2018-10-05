<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 24/09/2018
 * Time: 13:39
 */

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim(strip_tags($string)));
}

function confirmQuery($queryResult) {
    global $connection;
    if(!$queryResult) {
        die("Query failed: " . mysqli_error($connection));
    }
}

function redirect($location) {
    header("Location: " . $location);
    exit;
}

function query($query) {

    global $connection;

    return mysqli_query($connection, $query);
}

function ifItIsMethod($method=null) {

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }

    return false;

}

// users and login
function accountExists($column, $value) {
    global $connection;
    $query = "SELECT * FROM users WHERE $column = '$value'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function registerUser($username, $email, $password) {
    global $connection;


    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'subscriber'); ";
    $insert_new_registered_user = mysqli_query($connection, $query);
    confirmQuery($insert_new_registered_user);

}

function loginUser($username, $password) {
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username='$username';";

    $query_user_by_username = mysqli_query($connection, $query);

    confirmQuery($query_user_by_username);

    if(mysqli_num_rows($query_user_by_username) > 0) {
        while ($row = mysqli_fetch_assoc($query_user_by_username)) {
            $db_user_username = $row['username'];
            $db_user_password = $row['password'];
            $db_user_firstname = $row['firstname'];
            $db_user_lastname = $row['lastname'];
            $db_user_role = $row['role'];

        }

        if (password_verify($password, $db_user_password)) {
            $_SESSION['username'] = $db_user_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['role'] = $db_user_role;

            return true;
        }
    }

    // if we make it here there's a problem
    return false;
}



function isLoggedIn() {

    if(isset($_SESSION['role'])) {
        return true;
    }

    return false;

}

function loggedInUserId() {

    if(isLoggedIn()) {

       $result = query("SELECT * FROM users WHERE username ='" . $_SESSION['username'] ."'");
       $user = mysqli_fetch_assoc($result);

       $something = mysqli_num_rows($result) >= 1 ? $user['Id'] : false;

        return $something;
    }

    return false;
}


function checkIfUserIsLoggedInAndRedirect($redirectLocation=null) {

    if(isLoggedIn()) {
        redirect($redirectLocation);
    }

}

function isAdmin($username = '') {
    global $connection;

    $query = "SELECT Role FROM users WHERE username = '$username'; ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_array($result);

    if($row['Role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

// likes

function userLikedThisPost($post_id = 0) {

    $result = query("SELECT * FROM likes WHERE User_Id=" . loggedInUserId() . " AND Post_Id={$post_id}");

    return mysqli_num_rows($result) >= 1 ? true : false;

}

function getPostLikes($post_id) {

    $result = query("SELECT * FROM likes WHERE Post_Id = {$post_id}");
    confirmQuery($result);

    return mysqli_num_rows($result);

}

// images

function imagePlaceholder($image = '') {
    if(!$image || empty($image)) {
        return 'image_1.jpg';
    } else {
        return $image;
    }
}

