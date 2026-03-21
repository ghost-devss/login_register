<?php
 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
 
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Usuário';
 
$initials = '';
$parts = explode(' ', trim($name));
foreach ($parts as $part) {
    if (!empty($part)) {
        $initials .= strtoupper($part[0]);
        if (strlen($initials) >= 2) break;
    }
}
if (empty($initials)) {
    $initials = '?';
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
 
    <div class="blob blob-purple"></div>
    <div class="blob blob-orange"></div>
    <div class="blob blob-pink"></div>
 
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
            <div class="badge-pill">Página do Usuário</div>
 
            <h1>
                Bem-vindo,<br>
                <span><?= htmlspecialchars($name) ?></span>
            </h1>
 
            <p>Você está logado e pode acessar<br>todas as funcionalidades da plataforma.</p>
 
            <a href="profile.php" class="btn-glass">Ver perfil</a>
 
            <div class="info-card">
                <div class="avatar"><?= htmlspecialchars($initials) ?></div>
                <div class="info-card-text">
                    <div class="info-card-name"><?= htmlspecialchars($name) ?></div>
                    <div class="info-card-sub"><?= htmlspecialchars($_SESSION['email']) ?></div>
                </div>
                <span class="badge-user">Usuário</span>
            </div>
        </div>
    </main>
 
</body>
</html>