<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php 
        if(isset($_GET['error'])) { 
            $error = $_GET['error']; 
        ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="post" action="../login/check_login.php">
            
        <div class="input-container">
        <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required><br><br>
        </div>
        <div class="input-container">
        <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required><br><br>
        </div>
            <input type="submit" value="Login">
        </form>
        <div class="register-account">
        <p>Don't have an account? <a href="../login/register.php">Register</a></p>
        </div>

    </div>
</body>
</html>
