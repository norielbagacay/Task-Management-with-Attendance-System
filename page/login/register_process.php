<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include '../../db/connection.php';
    // Fetch registration data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'] ?? null; // Optional middle name
    $lastName = $_POST['last_name'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contact_number'];

    // Check if username already exists
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);
    if ($checkUsernameResult->num_rows > 0) {
        $error = "Username already exists!";
        header("Location: ../login/register.php?error=$error");
        exit();
    }

    // Insert registration data into the database
    $insertQuery = "INSERT INTO users (username, password, first_name, middle_name, last_name, address, contact_number) VALUES ('$username', '$password', '$firstName', '$middleName', '$lastName', '$address', '$contactNumber')";
    if ($conn->query($insertQuery) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: ../login/login.php");
        exit();
    } else {
        // Registration failed, redirect back to registration page with error message
        $error = "Registration failed. Please try again later.";
        header("Location: ../login/register.php?error=$error");
        exit();
    }
}
?>
