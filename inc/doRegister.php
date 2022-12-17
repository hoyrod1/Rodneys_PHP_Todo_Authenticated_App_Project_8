<?php
require_once 'bootstrap.php';

$username = test_form_input(request()->get('username'));
$password = test_form_input(request()->get('password'));
$confirmPassword = test_form_input(request()->get('confirm_password'));

if ($password != $confirmPassword) 
{
   $session->getFlashBag()->add('error', 'Password does not match');

   /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
   redirect('../register.php');
   exit;
}

$user = getUser($username);

if (!empty($user)) 
{
   $session->getFlashBag()->add('error', 'The username already exist');

   /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
   redirect('../register.php');
   exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$new_user = saveUser($username, $hashed);

$session->getFlashBag()->add('success', "Your account has been created");

/** REDISTERED USERS CREDENTIALS SAVED FOR COOKIE AUTHENTICATION **/
save_user_in_cookie($user);