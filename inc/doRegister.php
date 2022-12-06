<?php
require_once 'bootstrap.php';

$username = test_form_input(request()->get('username'));
$password = test_form_input(request()->get('password'));
$confirmPassword = test_form_input(request()->get('confirm_password'));

if ($password != $confirmPassword) 
{
   $session->getFlashBag()->add('error', 'Password does not match');
   redirect('../register.php');
   exit;
}

$user = getUser($username);

if (!empty($user)) 
{
   $session->getFlashBag()->add('error', 'The username already exist');
   redirect('../register.php');
   exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$new_user = saveUser($username, $hashed);

$session->getFlashBag()->add('success', "Your account has been created");

save_user_data($user);