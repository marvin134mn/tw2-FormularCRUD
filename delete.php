<?php
require_once 'functions.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?mensaje=' . urlencode('ID no proporcionado') . '&tipo=error');
    exit;
}

$id = $_GET['id'];
$usuario = buscarUsuario($id);

if (!$usuario) {
    header('Location: index.php?mensaje=' . urlencode('Usuario no encontrado') . '&tipo=error');
    exit;
}

eliminarUsuario($id);
header('Location: index.php?mensaje=' . urlencode('Usuario eliminado correctamente'));
exit;
