<?php
require_once 'bootstrap.php';

$username = test_form_input(request()->get('username'));

$user_info = getUser($username);

if (empty($user_info)) 
{
    $session->getFlashBag()->add('error', 'User was not found');
    redirect('../login.php');
    exit;
}

$password = test_form_input(request()->get('password'));

if (!password_verify($password, $user_info['password'])) 
{
    $session->getFlashBag()->add('error', 'Invalid password entered');
    redirect('../login.php');
    exit;
}

/** USER LOGIN CREDENTIALS SAVED FOR SESSION AUTHENTICATION **/
save_user_data($user_info);

/* TO DOO */
//USER LOGIN CREDENTIALS SAVED FOR COOKIE AUTHENTICATION
