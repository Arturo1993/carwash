<?php

session_start();

if(!isset($_SESSION['id'])) {
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}