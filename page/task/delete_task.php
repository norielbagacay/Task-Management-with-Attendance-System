<?php

include 'db/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tasksToDelete']) && !empty($_POST['tasksToDelete'])) {
        $taskIds = explode(',', $_POST['tasksToDelete']);
        $sql = "DELETE FROM tasks WHERE id IN (";
        foreach ($taskIds as $taskId) {
            $sql .= $taskId . ",";
        }
        $sql = rtrim($sql, ",") . ")";

        if ($conn->query($sql) === TRUE) {
            echo "Tasks deleted successfully.";
        } else {
            // Error deleting tasks
            echo "Error deleting tasks: " . $conn->error;
        }
    } else {
        echo "No tasks to delete provided.";
    }
} else {

    echo "Invalid request method.";
}
$conn->close();

// Redirect back to task.php
echo '<script>window.location.href = "?pg=task";</script>';
?>
