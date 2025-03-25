<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .register-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .login-btn {
            margin-top: 10px;
            background: #007bff;
        }
        .login-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateRegisterForm()">
            <input type="text" name="username" id="username" required placeholder="Username">
            <input type="email" name="email" id="email" required placeholder="Email">
            <input type="password" name="password" id="password" required placeholder="Password">
            <div class="error" id="register-error-message"></div>
            <button type="submit">Register</button>
        </form>
        <button class="login-btn" onclick="location.href='login.php'">Login</button>
    </div>

    <script>
        function validateRegisterForm() {
            let username = document.getElementById('username').value;
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let errorMessage = document.getElementById('register-error-message');
            
            if (username === '' || email === '' || password === '') {
                errorMessage.textContent = 'All fields are required';
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
