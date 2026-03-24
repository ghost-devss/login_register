<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once "config.php";

// Verifica se é admin
$email_atual = $_SESSION['email'];
$stmt = $conn->prepare("SELECT role FROM users WHERE email = ?");
$stmt->bind_param("s", $email_atual);
$stmt->execute();
$user_logado = $stmt->get_result()->fetch_assoc();

if (!$user_logado || $user_logado['role'] !== 'admin') {
    header("Location: user_page.php");
    exit();
}

$action = $_POST['action'] ?? '';
$id     = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header("Location: admin_page.php");
    exit();
}

// Impede de agir sobre si mesmo
$check = $conn->prepare("SELECT email FROM users WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$alvo = $check->get_result()->fetch_assoc();

if ($alvo && $alvo['email'] === $email_atual) {
    $_SESSION['erro'] = "Você não pode realizar essa ação em si mesmo.";
    header("Location: admin_page.php");
    exit();
}

// Deletar usuário
if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['sucesso'] = "Usuário deletado com sucesso.";
    } else {
        $_SESSION['erro'] = "Erro ao deletar usuário.";
    }
}

// Mudar role
if ($action === 'toggle_role') {
    $role_atual = $_POST['role_atual'] ?? 'user';
    $novo_role  = $role_atual === 'admin' ? 'user' : 'admin';

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $novo_role, $id);
    if ($stmt->execute()) {
        $_SESSION['sucesso'] = "Role alterado para \"$novo_role\" com sucesso.";
    } else {
        $_SESSION['erro'] = "Erro ao alterar o role.";
    }
}

header("Location: admin_page.php");
exit();