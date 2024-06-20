<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basit kullanıcı adı ve şifre kontrolü
    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['timeout'] = time();
        header('Location: admin.php');
    } else {
        $error = "Invalid username or password";
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
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-self: center;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .home-button {
            background-color: #2196F3;
            margin-top: 20px;
        }

        .home-button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if(isset($error)) { echo $error; } ?>
    <button class="home-button" onclick="window.location.href='index.php'">Anasayfa</button>
</div>
</body>
</html>
