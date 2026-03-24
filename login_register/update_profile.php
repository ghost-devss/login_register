<?php
 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
 
require_once "config.php";
 
$email_atual = $_SESSION['email'];
$role        = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';
 
// ── Atualizar nome e email ──
if (isset($_POST['update_profile'])) {
 
    $novo_nome  = trim($_POST['name']);
    $novo_email = trim($_POST['email']);
 
    if (empty($novo_nome) || empty($novo_email)) {
        $_SESSION['erro'] = "Nome e email são obrigatórios.";
        header("Location: profile.php");
        exit();
    }
 
    // Verifica se o novo email já pertence a outro usuário
    if ($novo_email !== $email_atual) {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND email != ?");
        $check->bind_param("ss", $novo_email, $email_atual);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $_SESSION['erro'] = "Este email já está em uso.";
            header("Location: profile.php");
            exit();
        }
    }
 
    // Admin pode alterar a senha
    if ($role === 'admin' && !empty($_POST['password'])) {
        $nova_senha = $_POST['password'];
        $confirmar  = $_POST['password_confirm'];
 
        if ($nova_senha !== $confirmar) {
            $_SESSION['erro'] = "As senhas não coincidem.";
            header("Location: profile.php");
            exit();
        }
 
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE email = ?");
        $stmt->bind_param("ssss", $novo_nome, $novo_email, $hash, $email_atual);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE email = ?");
        $stmt->bind_param("sss", $novo_nome, $novo_email, $email_atual);
    }
 
    if ($stmt->execute()) {
        $_SESSION['name']    = $novo_nome;
        $_SESSION['email']   = $novo_email;
        $_SESSION['sucesso'] = "Perfil atualizado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao salvar. Tente novamente.";
    }
 
    header("Location: profile.php");
    exit();
}
 
// ── Upload de foto ──
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
 
    $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mime       = mime_content_type($_FILES['photo']['tmp_name']);
 
    if (!in_array($mime, $permitidos)) {
        $_SESSION['erro'] = "Formato inválido. Use JPG, PNG, GIF ou WEBP.";
        header("Location: profile.php");
        exit();
    }
 
    if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
        $_SESSION['erro'] = "A imagem deve ter no máximo 2MB.";
        header("Location: profile.php");
        exit();
    }
 
    if (!is_dir('uploads')) mkdir('uploads', 0755, true);
 
    $ext      = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = 'uploads/' . md5($email_atual . time()) . '.' . $ext;
 
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filename)) {
        $stmt = $conn->prepare("UPDATE users SET photo = ? WHERE email = ?");
        $stmt->bind_param("ss", $filename, $email_atual);
        $stmt->execute();
        $_SESSION['sucesso'] = "Foto atualizada com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao salvar a imagem.";
    }
 
    header("Location: profile.php");
    exit();
}
 
header("Location: profile.php");
exit();
 