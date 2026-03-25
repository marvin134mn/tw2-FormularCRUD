<?php
require_once 'functions.php';

$usuarios = leerUsuarios();
$mensaje = $_GET['mensaje'] ?? '';
$tipo = $_GET['tipo'] ?? 'success';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Usuarios</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo) ?>">
                <?= htmlspecialchars(urldecode($mensaje)) ?>
            </div>
        <?php endif; ?>
        
        <a href="form.php" class="btn btn-primary">+ Nuevo Usuario</a>
        
        <?php if (empty($usuarios)): ?>
            <p class="empty">No hay usuarios registrados.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Carnet</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
                            <td><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td><?= htmlspecialchars($usuario['carnet']) ?></td>
                            <td class="actions">
                                <a href="form.php?id=<?= urlencode($usuario['id']) ?>" class="btn btn-edit">Editar</a>
                                <a href="delete.php?id=<?= urlencode($usuario['id']) ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
