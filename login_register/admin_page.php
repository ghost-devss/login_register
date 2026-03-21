<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="site-header">
        <span class="logo">Dashboard</span>
        <nav>
            <a href="user_page.php">Home</a>
            <a href="admin_page.php" class="active">Admin</a>
            <a href="profile.php">Perfil</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </header>

    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>admin</span> page</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

</body>
</html>