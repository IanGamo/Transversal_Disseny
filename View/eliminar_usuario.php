<?php
session_start();
require_once '../Controller/UserController.php';

// Solo admins pueden acceder
if (empty($_SESSION['logged'])) {
    header('Location: Login.php');
    exit;
}

if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
    header('Location: Profile.php');
    exit;
}

$ctrl    = new UserController();
$success = null;
$error   = null;

// Procesar eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $result = $ctrl->deleteUser();

    if ($result === true) {
        $success = "Usuario eliminado correctamente.";
    } else {
        $error = $result;
    }
}

// Obtener lista de usuarios estándar
$usuarios = $ctrl->listStandardUsers();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Race&amp;Meet</title>
    <link rel="stylesheet" href="../src/css/eliminar_usuario.css">
</head>
<body>

<div class="admin-wrapper">

    <!-- Cabecera -->
    <div class="admin-header">
        <div class="admin-header__left">
            <span class="admin-badge">Admin</span>
            <h1 class="admin-title">Gestión de Usuarios</h1>
        </div>
        <a href="Profile.php" class="btn btn--ghost">← Volver al perfil</a>
    </div>

    <!-- Mensajes de estado -->
    <?php if ($success): ?>
        <div class="alert alert--success">
            ✓ <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert--error">
            ✗ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Contador -->
    <div class="user-count">
        <span class="user-count__number"><?= count($usuarios) ?></span>
        usuario<?= count($usuarios) !== 1 ? 's' : '' ?> estándar registrado<?= count($usuarios) !== 1 ? 's' : '' ?>
    </div>

    <!-- Lista de usuarios -->
    <?php if (empty($usuarios)): ?>
        <div class="empty-state">
            <div class="empty-state__icon">👤</div>
            <p>No hay usuarios estándar registrados.</p>
        </div>
    <?php else: ?>
        <div class="user-grid">
            <?php foreach ($usuarios as $user): ?>
                <div class="user-card">

                    <!-- Avatar -->
                    <div class="user-card__avatar">
                        <?php if (!empty($user['path']) && file_exists($user['path'])): ?>
                            <img src="<?= htmlspecialchars($user['path']) ?>"
                                 alt="Avatar de <?= htmlspecialchars($user['name']) ?>">
                        <?php else: ?>
                            <span class="avatar-placeholder">
                                <?= mb_strtoupper(mb_substr($user['name'], 0, 1)) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="user-card__info">
                        <div class="user-card__name">
                            <?= htmlspecialchars($user['name']) ?>
                        </div>
                        <div class="user-card__email">
                            <?= htmlspecialchars($user['email']) ?>
                        </div>
                        <?php if (!empty($user['created_at'])): ?>
                            <div class="user-card__date">
                                Registro: <?= htmlspecialchars(
                                    date('d/m/Y', strtotime($user['created_at']))
                                ) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Acción eliminar -->
                    <div class="user-card__actions">
                        <button
                            class="btn btn--danger"
                            data-id="<?= (int) $user['id'] ?>"
                            data-name="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>"
                            onclick="confirmarEliminacion(this)">
                            🗑 Eliminar
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Modal de confirmación -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal__icon">⚠️</div>
        <h2 class="modal__title">¿Eliminar usuario?</h2>
        <p class="modal__body">
            Vas a eliminar a <strong id="modalUserName"></strong>.<br>
            Esta acción <strong>no se puede deshacer</strong>.<br>
            También se eliminará su avatar del servidor.
        </p>
        <div class="modal__actions">
            <button class="btn btn--ghost" onclick="cerrarModal()">Cancelar</button>
            <form method="POST" action="" id="deleteForm">
                <input type="hidden" name="user_id" id="deleteUserId">
                <button type="submit" class="btn btn--danger">Sí, eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmarEliminacion(btn) {
        const id   = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');

        document.getElementById('modalUserName').textContent = name;
        document.getElementById('deleteUserId').value        = id;
        document.getElementById('modalOverlay').classList.add('active');
    }

    function cerrarModal() {
        document.getElementById('modalOverlay').classList.remove('active');
    }

    // Cerrar al hacer clic fuera del modal
    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cerrarModal();
    });
</script>

</body>
</html>