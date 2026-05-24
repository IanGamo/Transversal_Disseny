<?php
session_start();
require_once '../Controller/UserController.php';

if (empty($_SESSION['logged'])) {
    header('Location: Login.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_own_account'])) {
    $ctrl   = new UserController();
    $result = $ctrl->deleteOwnAccount();
    if ($result === true) {
        header('Location: Login.php?cuenta=eliminada');
        exit;
    }
    $error = $result;
}

$userName  = htmlspecialchars($_SESSION['usuario_name']  ?? '');
$userEmail = htmlspecialchars($_SESSION['usuario_email'] ?? '');
$userRol   = htmlspecialchars($_SESSION['usuario_rol']   ?? '');
$userPath  = $_SESSION['usuario_path'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Race&amp;Meet</title>
    <link rel="stylesheet" href="../src/css/Profile.css">
    <style>
        .baja-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #2a2a2a;
        }
        .btn-delete-account {
            background: transparent;
            border: none;
            color: #555;
            font-size: 0.82rem;
            cursor: pointer;
            text-decoration: underline;
        }
        .btn-delete-account:hover { color: #ff3131; }
        .btn-admin {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: #b22222;
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .btn-admin:hover { background: #8b0000; }

        /* MODAL — todo inline para evitar problemas de caché */
        #modalBaja {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.82);
            z-index: 99999;
        }
        #modalBaja .modal-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #1a1a1a;
            border: 1px solid #2e2e2e;
            border-radius: 16px;
            padding: 36px 28px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.7);
        }
        #modalBaja .modal-icon  { font-size: 2.6rem; margin-bottom: 14px; }
        #modalBaja .modal-title { color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: 12px; }
        #modalBaja .modal-body  { color: #888; font-size: 0.88rem; line-height: 1.7; margin-bottom: 26px; }
        #modalBaja .modal-body strong { color: #fff; }
        #modalBaja .modal-btns  { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        #modalBaja .modal-btns form { display: contents; }
        #modalBaja .btn-cancel  {
            padding: 10px 22px; border-radius: 8px;
            border: 1px solid #3a3a3a; background: #2a2a2a;
            color: #ccc; font-weight: 700; cursor: pointer;
        }
        #modalBaja .btn-cancel:hover { background: #333; color: #fff; }
        #modalBaja .btn-confirm {
            padding: 10px 22px; border-radius: 8px;
            border: none; background: #ff3131;
            color: #fff; font-weight: 700; cursor: pointer;
        }
        #modalBaja .btn-confirm:hover { background: #cc0000; }
    </style>
</head>
<body>

    <div class="profile-container">

        <?php if ($userPath && file_exists($userPath)): ?>
            <img src="<?= htmlspecialchars($userPath) ?>" alt="Avatar" class="profile-avatar">
        <?php else: ?>
            <div class="profile-avatar-placeholder">👤</div>
        <?php endif; ?>

        <div class="profile-name"><?= $userName ?></div>
        <div class="profile-rol"><?= $userRol ?></div>

        <div class="profile-info">
            <p>Email: <span><?= $userEmail ?></span></p>
            <p>Rol: <span><?= ucfirst($userRol) ?></span></p>
        </div>

        <?php if ($error): ?>
            <div style="color:#ff3131;font-size:.88rem;font-weight:bold;margin-bottom:16px;">
                ✗ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="profile-actions">
            <a href="Home.php">
                <button class="btn-home">← Volver al inicio</button>
            </a>
            <?php if ($userRol === 'admin'): ?>
            <a href="eliminar_usuario.php">
                <button class="btn-admin">🗑 Gestionar usuarios</button>
            </a>
            <?php endif; ?>
            <form method="POST" action="Login.php">
                <button type="submit" name="Logout" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>

        <div class="baja-section">
            <button class="btn-delete-account" onclick="document.getElementById('modalBaja').style.display='block'">
                Darme de baja
            </button>
        </div>

    </div>

    <!-- Modal darse de baja -->
    <div id="modalBaja" onclick="if(event.target===this)this.style.display='none'">
        <div class="modal-inner">
            <div class="modal-icon">⚠️</div>
            <h2 class="modal-title">¿Eliminar tu cuenta?</h2>
            <p class="modal-body">
                Se borrarán tu cuenta y tu avatar de forma permanente.<br>
                <strong>Esta acción no se puede deshacer.</strong>
            </p>
            <div class="modal-btns">
                <button class="btn-cancel" onclick="document.getElementById('modalBaja').style.display='none'">
                    Cancelar
                </button>
                <form method="POST" action="">
                    <input type="hidden" name="delete_own_account" value="1">
                    <button type="submit" class="btn-confirm">Sí, eliminar mi cuenta</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') document.getElementById('modalBaja').style.display = 'none';
        });
    </script>

</body>
</html>