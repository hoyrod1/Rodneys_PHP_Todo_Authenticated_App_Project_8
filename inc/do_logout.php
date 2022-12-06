<?php
require_once 'bootstrap.php';

/** USE WHEN SESSION HAS BEEN SET **/
$session->remove('auth_logged_in');
$session->remove('auth_user_id');

$session->getFlashBag()->add('success', 'You are logged out');

redirect('../login.php');