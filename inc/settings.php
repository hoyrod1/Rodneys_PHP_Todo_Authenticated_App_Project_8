<?php
/*
 * CREDENTIALS TO SET UP MYSQL DATABASE CONNECTION
 */
// $servername = 'localhost';
// $username = 'root';
// $password = '';
// $dbname = 'todo_project_8';

try {
    // $db = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password);
    $db = new PDO('sqlite:'.__DIR__.'/todo.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //sqlite QUERY TO CREATE users TABLE
    // $sql = "CREATE TABLE IF NOT EXISTS users (
    //     id INTEGER PRIMARY KEY,
    //     username TEXT NOT NULL,
    //     password TEXT NOT NULL
    //     )";

    // $sql = "ALTER TABLE tasks ADD COLUMN user_id INTEGER";
    // $sql = "ALTER TABLE tasks DROP COLUMN user_id";
    // $db->exec($sql);
    // echo "<h1>Table tasks Altered successfully</h1>";

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

// 3. redirect \Symfony\Component\HttpFoundation\Response
function redirect($path) 
{
    $response = \Symfony\Component\HttpFoundation\Response::create(null, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => $path]);
    $response->send();
    exit;
}