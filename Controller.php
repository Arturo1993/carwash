<?php
/**
 *
 * Created by PhpStorm.
 * User: nikom
 * Date: 4/14/2017
 * Time: 1:07 PM
 * controller failebshi gavaertiane me
 */

include ("Users.php");


$user_object = new Users();

$post_login = "user";
$post_pass = "123";


$value = $user_object->user_name($post_login,$post_pass);
echo $value;
