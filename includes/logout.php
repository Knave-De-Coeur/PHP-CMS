<?php
/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 26/09/2018
 * Time: 14:59
 */
session_start(); ?>

<?php

$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;

header("Location: ../index.php");

?>
