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
            <a href="user_page.php">Home</a>
            <a href="admin_page.php">Admin</a>
            <a href="profile.php" class="active">Perfil</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </header>
 
    <main>
        <div class="card">
            <div class="badge-pill">Perfil do Usuário</div>

            <h1>
                Olá,<br>
                <span><?= htmlspecialchars($name) ?></span>
            </h1>

            <p>Esta é a sua área de perfil. Aqui você pode ver seus dados de conta.</p>

            <div class="info-card">
                <div class="avatar"><?= htmlspecialchars($initials) ?></div>
                <div class="info-card-text">
                    <div class="info-card-name">Nome: <?= htmlspecialchars($name) ?></div>
                    <div class="info-card-sub">Email: <?= htmlspecialchars($_SESSION['email']) ?></div>
                    <div class="info-card-sub">Função: <?= htmlspecialchars($_SESSION['role'] ?? 'Usuário') ?></div>
                </div>
                <span class="badge-user"><?= htmlspecialchars(strtoupper($_SESSION['role'] ?? 'USER')) ?></span>
            </div>

            <a href="user_page.php" class="btn-glass">Voltar para o painel</a>
        </div>
    </main>
 
</body>
</html>