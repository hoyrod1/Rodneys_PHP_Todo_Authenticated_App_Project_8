<?php
require_once 'bootstrap.php';

$session->getFlashBag()->add('success', 'You are logged out');;

/** SET COOKIE "auth_user_info" WITH EXPIRED COOKIE TIME TO LOG OUT THE USER **/
$expired_cookie = time() - 3600;
$cookie = set_userInfo_cookie('auth_user_info', $expired_cookie);

/** REDIRECT IF COOKIE SET AS A JSON OBJECT **/
redirect('../login.php', ['cookies' => [$cookie]]);