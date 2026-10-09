<?php
require_once __DIR__ . '/../actions/auth.php';
session_start();
if (isset($_SESSION['user'])) {
    // User is logged in, you can access their information
    $userId = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];
} else {
    // User is not logged in, redirect to login page
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <nav>
        <h1>Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</p>
        <a href="dashboard.php?action=logout">Logout</a>
    </nav>
    <div class="search-bar">
        <form action="dashboard.php" method="get">
            <input type="text" name="search" placeholder="Search recipes...">
            <input type="submit" value="Search">
            <select name="category" id="category">
                // filled out with a get request
            </select>
        </form>
        <button onclick="window.location.href='recipe.php?action=create'">Create Recipe</button>
    </div>
    <div class="recipes">

    </div>
</body>
</html>