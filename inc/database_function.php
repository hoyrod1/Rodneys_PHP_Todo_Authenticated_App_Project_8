<?php

function getUser($username) 
{
    try 
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) 
    {
        echo "Database connection to select users failed: " . $e->getMessage();
    }
}

function use_getUser($username) 
{
    $users = getUser($username);
    return $users;
}

function saveUser($username, $password) 
{
    global $db;
    if (getUser($username)) 
    {
        $query = "UPDATE users SET password=:password WHERE username=:username";
    } else 
    {
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    }
    try 
    {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return true;
    } catch (PDOException $e) 
    {
        echo "Database connection to insert or update users failed: " . $e->getMessage();
    }
    
}