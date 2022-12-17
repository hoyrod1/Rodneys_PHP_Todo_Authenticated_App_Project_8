<?php
// /** THE is_authenticated FUNCTION IS USED TO VERIFY USERS IS LOGGED IN **/
// function is_authenticated()
// {
//     // USE WHEN SESSION HAS BEEN SET //
//     global $session;
//     return $session->get('auth_logged_in', false);
// }

// /**  
//  * THE require_authorization FUNCTION IS USED TO VERIFY IF THE USER 
//  * IS LOGGED IN & AUTHORIZED TO ACCESS THE PAGE 
//  * **/
// function require_authorization()
// {
//     if (!is_authenticated()) 
//     {
//         global $session;
//         $session->getFlashBag()->add('error', 'Please login or register, you are not authorized');
//         redirect('login.php');
//     }
// }

// /**  THE is_owner FUNCTION RETRIEVES USERS SESSIONS ID **/
// function is_owner()
// {
//     if (!is_authenticated()) 
//     {
//         return false;
//     }
//     // USE WHEN SESSION HAS BEEN SET //
//     global $session;
//     return $session->get('auth_user_id');
// }

// /**  
//  *  THE  get_authenticated_user FUNCTION 
//  *  RETRIEVES LOGGED IN USERS INFORMATION TO UPDATE PASSWORD
//  * **/
// function get_authenticated_user()
// {
//     // USE WHEN SESSION HAS BEEN SET //
//     global $session;
//     $user_name = $session->get('auth_user_name');
//     return use_getUser($user_name);
// }

// /** 
//  * THE save_user_data FUNCTION RETRIEVES AND SETS 
//  * REGISTERED USERS INFORMATION TO A SESSION 
//  * **/
// function save_user_data($user)
// {
//         // SESSION NEEDED TO SET SESSION THE SESSION "getFlashBag()" FUNCTION //
//         global $session;

//         /** USE WHEN SESSION NEED TO BE SET **/
//         $session->set('auth_logged_in', true);
//         $session->set('auth_user_id', (int) $user['id']);
//         $session->set('auth_user_name', $user['username']);

//         $session->getFlashBag()->add('success', "You have been logged in successfully!");
//         redirect('../index.php');
// }