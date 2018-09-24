<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 24/09/2018
 * Time: 13:39
 */

function confirmQuery($queryResult) {
    global $connection;
    if(!$queryResult) {
        die("Query failed: " . mysqli_error($connection));
    }
}