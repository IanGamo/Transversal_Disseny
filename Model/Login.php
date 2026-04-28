<?php
session_start();
 
$host     = 'localhost';
$dbname   = 'race_and_meet';
$username  = 'adm1';
$password  = '12345';
 
function getUserFromDB(string $email, string $password): ?array
{
    global $host, $dbname, $username, $password;
 
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
 
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return null;
}
 
$error = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    if (isset($_POST['Login'])) {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
 
        $user = getUserFromDB($email, $password);
 
        if ($user) {
            $_SESSION['logged'] = true;
            $_SESSION['admin']  = (bool) ($user['admin'] ?? false);
            $_SESSION['user']   = $user;
            header('Location: profile.php');
            exit;
        } else {
            $error = 'wrong user';
        }
    }
 
    if (isset($_POST['Register'])) {
        header('Location: register.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
 
        <?php if ($error): ?>
            <div style="color:#ff3131; margin-bottom:15px; font-size:0.9rem; font-weight:bold;">
                 <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
 
        <form method="POST" action="">
 
            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
 
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
 
            <button type="submit" name="Login">Iniciar Sesión</button>
            <button type="submit" name="Register">¡Regístrate aquí!</button>
 
        </form>
    </div>
</body>
</html>