<?php
require_once 'bootstrap.php';
require_authorization();

$currentPassword = request()->get('current_password');
$confirmPassword = request()->get('confirm_password');
$newPassword     = request()->get('password');

if ($newPassword != $confirmPassword) 
{
    $session->getFlashBag()->add('error', 'New Passwords do not match, please try again');
    redirect('../account.php');
    exit;
}

$user = get_authenticated_user();

if (!$user) 
{
    $session->getFlashBag()->add('error', 'There was an error, try again. If this continue to happen please log out and log back in');
    redirect('../account.php');
    exit;
}

if (!password_verify($currentPassword, $user['password'])) 
{
    $session->getFlashBag()->add('error', 'You entered the incorrect current password');
    redirect('../account.php');
    exit;
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$check_password_update = saveUser($user['username'], $hashedPassword);

if (!$check_password_update) 
{
    $session->getFlashBag()->add('error', 'Something went wrong, could not update password. Please try again.');
    redirect('../account.php');
    exit;
}

$session->getFlashBag()->add('success', 'Password updated successfully.');
redirect('../index.php');

