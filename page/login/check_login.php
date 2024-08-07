<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../db/connection.php';
 
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user is an admin
    $admin_sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $admin_result = $conn->query($admin_sql);

    if ($admin_result->num_rows > 0) {
        // Admin login successful
        $admin = $admin_result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: ../admin_dashboard.php");
        exit();
    }

    // Check if the user is a regular user
    $user_sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $user_result = $conn->query($user_sql);

    if ($user_result->num_rows > 0) {
        // Regular user login successful
        $user = $user_result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../dashboard.php?pg=dashboard");
        exit();
    } else {
        $error = "Invalid username or password!";
        header("Location: login.php?error=$error");
        exit();
    }
}
?>
