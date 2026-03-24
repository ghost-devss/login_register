<?php

session_start();

// Verifica se está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once "config.php";

// Busca o usuário logado no banco
$email_atual = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email_atual);
$stmt->execute();
$user_logado = $stmt->get_result()->fetch_assoc();

// Bloqueia acesso se não for admin
if (!$user_logado || $user_logado['role'] !== 'admin') {
    header("Location: user_page.php");
    exit();
}

$name = $user_logado['name'];

// Busca estatísticas
$total   = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$admins  = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='admin'")->fetch_assoc()['total'];
$users   = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='user'")->fetch_assoc()['total'];

// Busca todos os usuários
$todos = $conn->query("SELECT id, name, email, role, photo FROM users ORDER BY role DESC, name ASC");

// Mensagens de feedback
$sucesso = isset($_SESSION['sucesso']) ? $_SESSION['sucesso'] : '';
$erro    = isset($_SESSION['erro'])    ? $_SESSION['erro']    : '';
unset($_SESSION['sucesso'], $_SESSION['erro']);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="blob blob-purple"></div>
    <div class="blob blob-orange"></div>
    <div class="blob blob-pink"></div>

    <header class="site-header">
        <span class="logo">Dashboard</span>
        <nav>
            <a href="user_page.php">Home</a>
            <a href="admin_page.php" class="active">Admin</a>
            <a href="profile.php">Perfil</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </header>

    <main>

        <?php if ($sucesso): ?>
            <div class="alerta alerta-sucesso"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>
        <?php if ($erro): ?>
            <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <!-- Cards de estatísticas -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total de usuários</div>
                <div class="stat-val"><?= $total ?> <span>usuários</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Administradores</div>
                <div class="stat-val"><?= $admins ?> <span>admin</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Usuários comuns</div>
                <div class="stat-val"><?= $users ?> <span>users</span></div>
            </div>
        </div>

        <!-- Tabela de usuários -->
        <div class="table-card">
            <div class="table-head">
                <h2>Gerenciar usuários</h2>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($u = $todos->fetch_assoc()): ?>
                            <?php
                                $partes = explode(' ', trim($u['name']));
                                $ini = '';
                                foreach ($partes as $p) {
                                    if (!empty($p)) { $ini .= strtoupper($p[0]); if (strlen($ini) >= 2) break; }
                                }
                                $e_voce = $u['email'] === $email_atual;
                            ?>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="av">
                                            <?php if (!empty($u['photo']) && file_exists($u['photo'])): ?>
                                                <img src="<?= htmlspecialchars($u['photo']) ?>" alt="foto">
                                            <?php else: ?>
                                                <?= htmlspecialchars($ini) ?>
                                            <?php endif; ?>
                                        </div>
                                        <span><?= htmlspecialchars($u['name']) ?></span>
                                        <?php if ($e_voce): ?>
                                            <span class="voce-badge">você</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="email-cell"><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <span class="badge <?= $u['role'] ?>">
                                        <?= $u['role'] === 'admin' ? 'Admin' : 'User' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!$e_voce): ?>
                                        <div class="acoes">
                                            <!-- Mudar role -->
                                            <form action="admin_action.php" method="post" style="display:inline">
                                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                <input type="hidden" name="action" value="toggle_role">
                                                <input type="hidden" name="role_atual" value="<?= $u['role'] ?>">
                                                <button type="submit" class="btn-role">
                                                    <?= $u['role'] === 'admin' ? 'Tornar user' : 'Tornar admin' ?>
                                                </button>
                                            </form>
                                            <!-- Deletar -->
                                            <form action="admin_action.php" method="post" style="display:inline"
                                                  onsubmit="return confirm('Tem certeza que deseja deletar <?= htmlspecialchars($u['name']) ?>?')">
                                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="btn-del">Deletar</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span class="sem-acao">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>