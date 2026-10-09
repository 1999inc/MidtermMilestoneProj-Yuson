<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: protected/dashboard.php');
    exit();
}

require_once __DIR__ . '/actions/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = register($username, $password);
    if ($user['status'] === true) {
        echo 'Registration successful!';
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
        ];
        header('Location: protected/dashboard.php');
        exit();
    } else {
        echo 'Registration failed. Username may already exist.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <h1>Register</h1>
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Register">
    </form>
    <button type="button" onclick="window.location.href='login.php'">Login</button>
</body>
</html>