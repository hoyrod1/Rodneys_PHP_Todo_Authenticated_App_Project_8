<?php
require_once 'bootstrap.php';

$username = test_form_input(request()->get('username'));

$user_info = getUser($username);

if (empty($user_info)) 
{
    $session->getFlashBag()->add('error', 'User was not found');

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../login.php');
    exit;
}

$password = test_form_input(request()->get('password'));

if (!password_verify($password, $user_info['password'])) 
{
    $session->getFlashBag()->add('error', 'Invalid password entered');

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../login.php');
    exit;
}

/** USER LOGIN CREDENTIALS SAVED FOR COOKIE AUTHENTICATION **/
save_user_in_cookie($user_info);
