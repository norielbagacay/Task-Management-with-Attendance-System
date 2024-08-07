<?php
include '../db/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    
    // Assuming you have a session variable storing the logged-in user's ID
    session_start();
    $user_id = $_SESSION['user_id'];

    // Insert new task into the database, associating it with the logged-in user
    $sql = "INSERT INTO tasks (title, description, created_at, updated_at, priority, user_id) VALUES ('$title', '$description', NOW(), NOW(),'$priority', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the main page after adding the task
        header("Location:?pg=task");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
    