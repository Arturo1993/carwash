<?php
/**
 * Created by PhpStorm.
 * User: Qeti
 * Date: 27.04.2017
 * Time: 21:13
 */

session_start();

if(!isset($_SESSION['id'])) {
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='../index.php'\" />";
}