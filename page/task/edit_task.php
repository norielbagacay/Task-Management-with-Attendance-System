<?php
include 'db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $task_id = $_POST['task_id'];
    $title = $_POST['edit_task_title'];
    $description = $_POST['edit_task_description'];
    $status = $_POST['edit_task_status']; 
    $priority = $_POST['edit_task_priority'];

    // Update task in the database with status
    $sql = "UPDATE tasks SET title='$title', description='$description', status='$status', priority='$priority' WHERE id='$task_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Task updated successfully
        header("Location: ?pg=task"); // Redirect back to the task list
        exit();
    } else {
        // Error updating task
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
