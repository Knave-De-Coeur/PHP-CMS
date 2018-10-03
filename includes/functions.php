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