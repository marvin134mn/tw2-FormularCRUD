<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$errores = validarDatos($_POST);

if (!empty($errores)) {
    session_start();
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = $_POST;
    header('Location: form.php' . (isset($_POST['id']) && $_POST['id'] ? '?id=' . urlencode($_POST['id']) : ''));
    exit;
}

if (isset($_POST['id']) && $_POST['id']) {
    actualizarUsuario($_POST['id'], $_POST);
    header('Location: index.php?mensaje=' . urlencode('Usuario actualizado correctamente'));
} else {
    crearUsuario($_POST);
    header('Location: index.php?mensaje=' . urlencode('Usuario creado correctamente'));
}
exit;
