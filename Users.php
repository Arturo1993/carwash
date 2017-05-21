<?php
session_start();
include ('connect.php');
/**
 * Created by PhpStorm.
 * User: nikom
 * Date: 4/14/2017
 * Time: 12:53 PM
 */

if(isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] != "" && $_POST['password']) {
    $user = $_POST['login'];
    $pass = $_POST['password'];
}

$user_query = mysqli_prepare($mysql, "SELECT idUsers, UserName, name, surname, Branchid FROM users WHERE UserName=? AND Password=?")or die( mysqli_error($mysql) );
mysqli_stmt_bind_param($user_query, "ss", $user, $pass);
mysqli_stmt_execute($user_query);
mysqli_stmt_bind_result($user_query, $id, $name, $first_name, $last_name, $branch_id);
mysqli_stmt_fetch($user_query);

if($name != "" && $name == $user) {
    $_SESSION['id'] = $id;
    $_SESSION['user'] = $name;
    $_SESSION['name'] = $first_name;
    $_SESSION['surname'] = $last_name;
    $_SESSION['branch_id'] = $branch_id;
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='AdminLTE-master/index2.php'\" />";
}else{
    $_SESSION['id'] = '';
    $_SESSION['user'] = 'no user';
    $_SESSION['name'] = '';
    $_SESSION['surname'] = '';
    $_SESSION['branch_id'] = '';
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}

if(isset($_POST['logout']))
{
    unset($_SESSION['id']);
    unset($_SESSION['user']);
    unset($_SESSION['name']);
    unset($_SESSION['surname']);
    unset($_SESSION['branch_id']);
    session_destroy();
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='index.php'\" />";
}