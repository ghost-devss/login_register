<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <header class="site-header">
        <span class="logo">Dashboard</span>
        <nav>
            <a href="user_page.php" class="active">Home</a>
            <a href="admin_page.php">Admin</a>
            <a href="profile.php">Perfil</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </header>
 
    <main>
        <div class="card">
            <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
            <p>This is a <span>user</span> page</p>        
        </div>
    </main>
</body>
</html>