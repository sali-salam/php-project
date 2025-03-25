<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
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
        .register-btn {
            margin-top: 10px;
            background: #007bff;
        }
        .register-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateForm()">
            <input type="email" name="email" id="email" required placeholder="Email">
            <input type="password" name="password" id="password" required placeholder="Password">
            <div class="error" id="error-message"></div>
            <button type="submit">Login</button>
        </form>
        <button class="register-btn" onclick="location.href='register.php'">Register</button>
    </div>

    <script>
        function validateForm() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let errorMessage = document.getElementById('error-message');
            
            if (email === '' || password === '') {
                errorMessage.textContent = 'Both fields are required';
                return false;
            }
            return true;
        }
    </script>
</body>
</html>