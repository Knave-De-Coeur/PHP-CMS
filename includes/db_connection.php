<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 06/09/2018
 * Time: 14:36
 */

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'cms';

foreach ($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connection) {
    die("Error: Problem connecting to db, " . mysqli_error($connection));
}