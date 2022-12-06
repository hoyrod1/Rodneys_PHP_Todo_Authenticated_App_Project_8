<?php
require_once 'inc/bootstrap.php';
require_authorization();

$pageTitle = "Task | Time Tracker";
$page = "task";

$user_id = get_authenticated_user();

/** STORED  "task id" IN VARIABLE $task_user_id **/
$task_user_id = request()->get('id');

$task_list = getTask($task_user_id);

if ($task_user_id) 
{
    $task_list = getTask($task_user_id);
}

include 'inc/header.php';
?>

<div class="section page">
    <div class="col-container page-container">
        <div class="col col-70-md col-60-lg col-center">
            
            <?php if (!empty($task_user_id)) : ?>
                <h1 class="actions-header"> Update Task </h1>
            <?php else: ?>  
                <h1 class="actions-header"> Add Task</h1>
            <?php endif ?>
            
            <?php
            if (isset($error_message)) 
            {
                echo "<p class='message'>$error_message</p>";
            }
            ?>
            
            <form class="form-container form-add" method="post" action="inc/actions_tasks.php">
                <table>
                    <tr>
                        <th><label for="task">Task<span class="required">*</span></label></th>
                        <td><input type="text" id="task" name="task" value="<?php echo htmlspecialchars($task_list['task']); ?>" /></td>
                    </tr>
                </table>
                <?php if (!empty($task_list['id'])) : ?>
                    <input type='hidden' name='action' value='update' />
                    <input type='hidden' name='task_id' value="<?php echo $task_list['id'] ?>" />
                    <input type='hidden' name='status' value="<?php echo $task_list['status'] ?>" />
                <?php else: ?>
                    <input type='hidden' name='status' value='0' />
                    <input type='hidden' name='action' value='add' />
                    <input type='hidden' name='user_id' value="<?php echo $user_id['id'] ?>" />
                <?php endif ?>
                
                <input class="button button--primary button--topic-php" type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
