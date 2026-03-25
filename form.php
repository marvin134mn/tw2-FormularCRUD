<?php
require_once 'functions.php';

session_start();
$usuario = null;
$errores = $_SESSION['errores'] ?? [];
$datos = $_SESSION['datos'] ?? [];

unset($_SESSION['errores'], $_SESSION['datos']);

if (isset($_GET['id'])) {
    $usuario = buscarUsuario($_GET['id']);
    if (!$usuario) {
        header('Location: index.php?mensaje=' . urlencode('Usuario no encontrado') . '&tipo=error');
        exit;
    }
}

if ($datos) {
    $usuario = [
        'id' => $datos['id'] ?? null,
        'nombre' => $datos['nombre'] ?? '',
        'apellido' => $datos['apellido'] ?? '',
        'correo' => $datos['correo'] ?? '',
        'carnet' => $datos['carnet'] ?? ''
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $usuario && $usuario['id'] ? 'Editar' : 'Crear' ?> Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?= $usuario && $usuario['id'] ? 'Editar' : 'Nuevo' ?> Usuario</h1>
        
        <form method="POST" action="save.php">
            <?php if ($usuario && $usuario['id']): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" required>
                <?php if (isset($errores['nombre'])): ?>
                    <span class="error"><?= htmlspecialchars($errores['nombre']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>" required>
                <?php if (isset($errores['apellido'])): ?>
                    <span class="error"><?= htmlspecialchars($errores['apellido']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>" required>
                <?php if (isset($errores['correo'])): ?>
                    <span class="error"><?= htmlspecialchars($errores['correo']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="carnet">Carnet de Identidad:</label>
                <input type="text" id="carnet" name="carnet" value="<?= htmlspecialchars($usuario['carnet'] ?? '') ?>" required>
                <?php if (isset($errores['carnet'])): ?>
                    <span class="error"><?= htmlspecialchars($errores['carnet']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
