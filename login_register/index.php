<?php

session_start();

$errors = [
    'login'    => $_SESSION['login_error']    ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="blob blob-purple"></div>
    <div class="blob blob-orange"></div>
    <div class="blob blob-pink"></div>

    <div class="wrapper">
        <div class="card">

            <!-- Logo -->
            <div class="logo-area">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div class="form-title" id="form-title">
                    <?= $activeForm === 'login' ? 'Bem-vindo de volta' : 'Criar conta' ?>
                </div>
                <div class="form-sub" id="form-sub">
                    <?= $activeForm === 'login' ? 'Entre na sua conta para continuar' : 'Preencha os dados para se registrar' ?>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab <?= $activeForm === 'login'    ? 'active' : '' ?>"
                        onclick="showForm('login')">Entrar</button>
                <button class="tab <?= $activeForm === 'register' ? 'active' : '' ?>"
                        onclick="showForm('register')">Registrar</button>
            </div>

            <!-- Form Login -->
            <div class="form <?= $activeForm === 'login' ? 'show' : '' ?>" id="login">

                <?php if ($errors['login']): ?>
                    <div class="alerta alerta-erro"><?= htmlspecialchars($errors['login']) ?></div>
                <?php endif; ?>

                <form action="login_register.php" method="post">
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="seu@email.com" required>
                    </div>
                    <div class="field">
                        <label>Senha</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="login" class="btn">Entrar</button>
                </form>

                <div class="switch">
                    Não tem conta? <a onclick="showForm('register')">Registrar</a>
                </div>
            </div>

            <!-- Form Registro -->
            <div class="form <?= $activeForm === 'register' ? 'show' : '' ?>" id="register">

                <?php if ($errors['register']): ?>
                    <div class="alerta alerta-erro"><?= htmlspecialchars($errors['register']) ?></div>
                <?php endif; ?>

                <form action="login_register.php" method="post">
                    <div class="field">
                        <label>Nome</label>
                        <input type="text" name="name" placeholder="Seu nome completo" required>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="seu@email.com" required>
                    </div>
                    <div class="field">
                        <label>Senha</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="field">
                        <label>Perfil</label>
                        <select name="role" required>
                            <option value="">Selecione o perfil</option>
                            <option value="user">Usuário</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="register" class="btn">Criar conta</button>
                </form>

                <div class="switch">
                    Já tem conta? <a onclick="showForm('login')">Entrar</a>
                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>