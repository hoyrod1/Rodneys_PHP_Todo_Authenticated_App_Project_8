<?php
//task functions

function getTasks($where = null)
{
    $user_id = is_owner();
    global $db;
    
    if (!empty($where)) 
    {
        $query = "SELECT * FROM tasks WHERE $where AND user_id = $user_id ORDER BY id";
    }else
    {
        $query = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY id";
    }
    
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $tasks = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $tasks;
}
function getIncompleteTasks()
{
    return getTasks('status=0');
}
function getCompleteTasks()
{
    return getTasks('status=1');
}
function getTask($task_id)
{
    global $db;

    try {
        $statement = $db->prepare('SELECT id, task, status, user_id FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $task;
}
function createTask($data)
{
    global $db;

    try {
        $statement = $db->prepare('INSERT INTO tasks (task, status, user_id) VALUES (:task, :status, :user_id)');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('user_id', $data['user_id']);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($db->lastInsertId());
}
function updateTask($data)
{
    global $db;

    try {
        getTask($data['task_id']);
        $statement = $db->prepare('UPDATE tasks SET task=:task, status=:status WHERE id=:id');
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function updateStatus($data)
{
    global $db;

    try {
        getTask($data['task_id']);
        $statement = $db->prepare('UPDATE tasks SET status=:status WHERE id=:id');
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['task_id']);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return getTask($data['task_id']);
}
function deleteTask($task_id)
{
    global $db;

    try {
        getTask($task_id);
        $statement = $db->prepare('DELETE FROM tasks WHERE id=:id');
        $statement->bindParam('id', $task_id);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}
