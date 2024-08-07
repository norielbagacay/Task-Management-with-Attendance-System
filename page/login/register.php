<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../../css/register.css">
    <style>
        .close-button {
            float: right;
            cursor: pointer;
            margin-top: -70px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <span class="close-button" onclick="closeForm()">X</span>
        <?php 
        if(isset($_GET['error'])) { 
            $error = $_GET['error']; 
        ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post" action="../login/register_process.php">
            <label for="firstName">First Name:</label>
            <input type="text" name="first_name" required><br>
            <label for="middleName">Middle Name:</label>
            <input type="text" name="middle_name"><br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="last_name" required><br>
            <label for="address">Address:</label>
            <input type="text" name="address" required><br>
            <label for="contactNumber">Contact Number:</label>
            <input type="text" name="contact_number" required><br>
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="../login/login.php">Login</a></p>
    </div>

    <script>
        function closeForm() {
            window.location.href = "../login/login.php";
        }
    </script>
</body>
</html>
