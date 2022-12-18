<?php
/** THE is_authenticated FUNCTION IS USED TO VERIFY USERS IS LOGGED IN **/
function is_authenticated()
{
    // USE WHEN COOKIE HAS BEEN SET //
    return $username = decode_auth_cookie();    
}

/**  
 * THE require_authorization FUNCTION IS USED TO VERIFY IF THE USER 
 * IS LOGGED IN & AUTHORIZED TO ACCESS THE PAGE 
 * **/
function require_authorization()
{
    if (!is_authenticated()) 
    {
        global $session;
        $session->getFlashBag()->add('error', 'Please login or register, you are not authorized');
        /** REDIRECT FOR ONE COOKIE NAME AND VALUE **/
        redirect('login.php');
    }
}

/**  THE is_owner FUNCTION RETRIEVES USERS SESSIONS ID **/
function is_owner()
{
    if (!is_authenticated()) 
    {
        return false;
    }
    //**  USE WHEN COOKIE HAS BEEN SET **//
    return $username = decode_auth_cookie('auth_user_id');        
}

/**  
 *  THE  get_authenticated_user FUNCTION 
 *  RETRIEVES LOGGED IN USERS INFORMATION TO UPDATE PASSWORD
 * **/
function get_authenticated_user()
{
    //**  USE WHEN COOKIE HAS BEEN SET **//
    $user_name = decode_auth_cookie('auth_user_name');
    return use_getUser($user_name);    
}

//---------------------------------------------------------------------------------------------------------------------------//

/** 
 * IN THIS "save_user_data" FUNCTION RETRIEVES, ENCODES AND SETS  
 * REGISTERED USERS AND USER LOGIN INFORMATION TO A COOKIE USOMG THE "json_encode()" function
 * THAT CAN STORE MORE THAN ONE NAME AND VALUE IN A JSON OBJECT
 * FOR THE SYMFONY REDIRECT
 * **/

 function save_user_in_cookie($user)
{
    // SESSION NEEDED TO SET SESSION THE SESSION "getFlashBag()" FUNCTION //
    global $session;

    $session->getFlashBag()->add('success', "You have been logged in successfully!");
    
    /** 
    * CREATE A JWT (Json Web Token) TO STORE USER DATA AS JSON A OBJECT
    * THAT IS SIGNED WITH A SECRET KEY TO MAKE SURE IT CANNOT BE CHANGED
    **/
    $exp_time = time() + 3600;
    $jwt = Firebase\JWT\JWT::encode(
        [
            'iss' => request()->getBaseUrl(),
            'sub' => (int) $user['id'],
            'exp' => $exp_time,
            'iat' => time(),
            'nbf' => time(),
            'auth_user_name' => $user['username']
        ], getenv("SECRET_KEY"), 'HS256');

    $cookie_info = set_userInfo_cookie($jwt, $exp_time);

    redirect('../index.php', ['cookies' => [$cookie_info]]);        
}
/** 
 * IN THIS "save_usersId_cookie" FUNCTION 
 * A COOKIE IS SET AND RETURNED THAT CAN STORE MORE THAN ONE NAME AND VALUE
 * IN A JSON OBJECT FOR THE SYMFONY REDIRECT
 **/
function set_userInfo_cookie($user_info, $exp_time)
{
    $domain = 'localhost';
    $cookie_info = new Symfony\Component\HttpFoundation\Cookie('auth_user_info', $user_info, $exp_time, '/', $domain, false, true);
    return $cookie_info;
}
/** 
 * IN THE "decode_auth_cookie" FUNCTION 
 * THE COOKIE NAME AND VALUE IS EXTRACTED
 * USOMG THE "json_decode()" function
 **/
function decode_auth_cookie($cookie_key = null)
{
    // $cookie = json_decode(request()->cookies->get('auth_user_info'));
    try{
        Firebase\JWT\JWT::$leeway=1;
        $cookie = Firebase\JWT\JWT::decode(request()->cookies->get('auth_user_info'), getenv("SECRET_KEY"), ['HS256']);
    }catch(Exception $e)
    {
        return false;
    }

    if ($cookie_key === null) 
    {
        return $cookie;
    }

    if($cookie_key == 'auth_user_id')
    {
        $cookie_key = 'sub';
    }

    if (!isset($cookie->$cookie_key)) 
    {
        return false;
    }
    
    return $cookie->$cookie_key;
}
//---------------------------------------------------------------------------------------------------------------------------//