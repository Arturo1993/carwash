<?php
/**
 * Created by PhpStorm.
 * User: nikom
 * Date: 4/14/2017
 * Time: 1:26 PM
 */
global $mysql;

$mysql = mysqli_connect("localhost","root","", "carwash");
$mysql->set_charset("utf8");

if(!$mysql) {
    echo("Could not connect to the database.");
    exit();
}