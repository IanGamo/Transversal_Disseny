<?php
session_start();
 
$host     = 'localhost';
$dbname   = 'race_and_meet';
$db_user  = 'adm1';
$db_pass  = '12345';
 
function insertUser(string $name, string $password, string $email, string $path): bool
{
    global $host, $dbname, $db_user, $db_pass;
 
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $db_user,
            $db_pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
 
    $stmt = $pdo->prepare(
        'INSERT INTO usuarios (name, password, email, path) VALUES (?, ?, ?, ?)'
    );
 
    return $stmt->execute([$name, password_hash($password, PASSWORD_DEFAULT), $email, $path]);
}
 
$error = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
 
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'wrong user';
 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'wrong user';
 
    } elseif (strlen($password) < 6) {
        $error = 'wrong user';
 
    } else {
 
        $imgPath = '';
 
        if (!empty($_FILES['avatar']['name'])) {
            $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $uploadDir = 'uploads/avatars/';
 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
 
            $mimeType = mime_content_type($_FILES['avatar']['tmp_name']);
 
            if (!in_array($mimeType, $allowed)) {
                $error = 'wrong user';
            } elseif ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
                $error = 'wrong user';
            } else {
                $ext      = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('avatar_', true) . '.' . $ext;
                $imgPath  = $uploadDir . $filename;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $imgPath);
            }
        }
 
        if (!$error) {
            $ok = insertUser($name, $password, $email, $imgPath);
 
            if ($ok) {
                // if register OK → logged=true, admin=false
                $_SESSION['logged'] = true;
                $_SESSION['admin']  = false;
                $_SESSION['user']   = ['name' => $name, 'email' => $email, 'path' => $imgPath];
                header('Location: home.php');
                exit;
            } else {
                $error = 'wrong user';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Registro.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
 
        <?php if ($error): ?>
            <div style="color:#ff3131; margin-bottom:15px; font-size:0.9rem; font-weight:bold;">
                 <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
 
        <form method="POST" action="" enctype="multipart/form-data">
 
            <div class="input-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>
 
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
 
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
 
            <div class="input-group">
                <label for="avatar">Foto de perfil</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>
 
            <button type="submit">Register</button>
 
        </form>
    </div>
</body>
</html>