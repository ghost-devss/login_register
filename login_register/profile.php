<?php
 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
 
require_once "config.php";
 
$email_atual = $_SESSION['email'];
 
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email_atual);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
 
$name  = $user['name'];
$email = $user['email'];
$role  = $user['role'];
$photo = !empty($user['photo']) ? $user['photo'] : null;
 
$initials = '';
$parts = explode(' ', trim($name));
foreach ($parts as $part) {
    if (!empty($part)) {
        $initials .= strtoupper($part[0]);
        if (strlen($initials) >= 2) break;
    }
}
if (empty($initials)) $initials = '?';
 
$sucesso = isset($_SESSION['sucesso']) ? $_SESSION['sucesso'] : '';
$erro    = isset($_SESSION['erro'])    ? $_SESSION['erro']    : '';
unset($_SESSION['sucesso'], $_SESSION['erro']);
 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
 
    <div class="blob blob-purple"></div>
    <div class="blob blob-orange"></div>
    <div class="blob blob-pink"></div>
 
    <header class="site-header">
        <span class="logo">Dashboard</span>
        <nav>
            <a href="user_page.php">Home</a>
            <?php if ($role === 'admin'): ?>
                <a href="admin_page.php">Admin</a>
            <?php endif; ?>
            <a href="profile.php" class="active">Perfil</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </header>
 
    <main>
 
        <div class="sidebar">
            <div class="avatar-wrap">
 
                <form action="update_profile.php" method="post" enctype="multipart/form-data" id="photo-form">
                    <label for="photo-input" class="avatar-circle">
                        <?php if ($photo && file_exists($photo)): ?>
                            <img src="<?= htmlspecialchars($photo) ?>" alt="Foto">
                        <?php else: ?>
                            <span><?= htmlspecialchars($initials) ?></span>
                        <?php endif; ?>
                        <div class="avatar-overlay">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </div>
                        <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none"
                               onchange="document.getElementById('photo-form').submit()">
                    </label>
                </form>
 
                <div class="avatar-name"><?= htmlspecialchars($name) ?></div>
                <div class="avatar-role"><?= $role === 'admin' ? 'Administrador' : 'Usuário' ?></div>
                <label for="photo-input" class="change-photo-btn">+ Alterar foto</label>
            </div>
        </div>
 
        <div class="form-card">
 
            <?php if ($sucesso): ?>
                <div class="alerta alerta-sucesso"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>
            <?php if ($erro): ?>
                <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
 
            <form action="update_profile.php" method="post">
 
                <div class="form-title">Editar perfil</div>
 
                <div class="section-label">Informações pessoais</div>
 
                <div class="field-row">
                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" id="name" name="name"
                               value="<?= htmlspecialchars($name) ?>" required>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               value="<?= htmlspecialchars($email) ?>" required>
                    </div>
                </div>
 
                <div class="divider"></div>
                <div class="section-label">Segurança</div>
 
                <?php if ($role === 'admin'): ?>
                    <div class="field-row">
                        <div class="field">
                            <label for="password">Nova senha</label>
                            <input type="password" id="password" name="password" placeholder="••••••••">
                        </div>
                        <div class="field">
                            <label for="password_confirm">Confirmar senha</label>
                            <input type="password" id="password_confirm" name="password_confirm" placeholder="••••••••">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="field">
                        <label>Senha</label>
                        <input type="password" disabled placeholder="••••••••">
                        <span class="field-hint">Apenas administradores podem alterar a senha</span>
                    </div>
                <?php endif; ?>
 
                <div class="btn-row">
                    <a href="user_page.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" name="update_profile" class="btn-save">Salvar alterações</button>
                </div>
 
            </form>
        </div>
    </main>
 