<?php
require_once 'bootstrap.php';
require_authorization();

$currentPassword = request()->get('current_password');
$confirmPassword = request()->get('confirm_password');
$newPassword     = request()->get('password');

if ($newPassword != $confirmPassword) 
{
    $session->getFlashBag()->add('error', 'New Passwords do not match, please try again');
    $expired_cookie = time() - 3600;
    $cookie = set_userInfo_cookie('error', $expired_cookie);

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../account.php', $cookie);
    exit;
}

$user = get_authenticated_user();

if (!$user) 
{
    $session->getFlashBag()->add('error', 'There was an error, try again. If this continue to happen please log out and log back in');
    $expired_cookie = time() - 3600;
    $cookie = set_userInfo_cookie('error', $expired_cookie);

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../account.php', $cookie);
    exit;
}

if (!password_verify($currentPassword, $user['password'])) 
{
    $session->getFlashBag()->add('error', 'You entered the incorrect current password');
    $expired_cookie = time() - 3600;
    $cookie = set_userInfo_cookie('error', $expired_cookie);

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../account.php', $cookie);
    exit;
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$check_password_update = saveUser($user['username'], $hashedPassword);

if (!$check_password_update) 
{
    $session->getFlashBag()->add('error', 'Something went wrong, could not update password. Please try again.');
    $expired_cookie = time() - 3600;
    $cookie = set_userInfo_cookie('error', $expired_cookie);;

    /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
    redirect('../account.php', $cookie);
    exit;
}

$session->getFlashBag()->add('success', 'Password updated successfully.');
$expired_cookie = time() - 3600;
$cookie = set_userInfo_cookie('error', $expired_cookie);;

/** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
redirect('../account.php', $cookie);

