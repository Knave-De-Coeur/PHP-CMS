<?php include "db_connection.php";?>
<?php include "functions.php";?>

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
            $db_id = $row['Id'];
            echo $db_id;
        }

    }
}