<?php
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

try {
    // $db = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password);
    $db = new PDO('sqlite:'.__DIR__.'/todo.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch ( PDOException $e ) {
    echo 'Error connecting to the Database: ' . $e->getMessage();
    exit;
}
/*
 * Set access to components from \Symfony\Component\HttpFoundation\
 * 1. Session
 * 2. Request
 * 3. Redirect
 */

// 1. session \Symfony\Component\HttpFoundation\Session
$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();

// 2. request \Symfony\Component\HttpFoundation\Request
function request() 
{
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

/*** 
* 3a. redirect \Symfony\Component\HttpFoundation\Response 
*     "FOR MORE THAN ONE NAME AND VLAUE COOKIE" STORED IN A ARRAY 
***/
function redirect($path, $cookies_info = [])
{
    $response = \Symfony\Component\HttpFoundation\Response::create(null, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => $path]);
    if (key_exists('cookies', $cookies_info)) 
    {
        foreach($cookies_info['cookies'] as $cookie)
        {
            $response->headers->setCookie($cookie);
        }
    }
    $response->send();
    exit;
}