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
    <title>User Page</title>
    <link rel="stylesheet" href="user.css">
    
</head>
<body style="background: #fff;">
    <div class="box-header">
        <h2>Welcome to the User Dashboard</h2>
        <ul>
            <li><a href="user_page.php">Home</a></li>
            <li><a href="admin_page.php">Admin</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="profile.php">Profile</a></li>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </ul>
    </div>
    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
        <p>This is a <span>user</span> page</p>
        
    </div>

</body>
</html>