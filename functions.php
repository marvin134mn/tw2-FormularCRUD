<?php

define('DB_FILE', __DIR__ . '/db.json');

function leerUsuarios(): array {
    if (!file_exists(DB_FILE)) {
        return [];
    }
    $contenido = file_get_contents(DB_FILE);
    return json_decode($contenido, true) ?? [];
}

function guardarUsuarios(array $usuarios): bool {
    return file_put_contents(DB_FILE, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

function buscarUsuario(string $id): ?array {
    $usuarios = leerUsuarios();
    foreach ($usuarios as $usuario) {
        if ($usuario['id'] === $id) {
            return $usuario;
        }
    }
    return null;
}

function crearUsuario(array $datos): array {
    $usuarios = leerUsuarios();
    $usuario = [
        'id' => uniqid(),
        'nombre' => trim($datos['nombre']),
        'apellido' => trim($datos['apellido']),
        'correo' => trim($datos['correo']),
        'carnet' => trim($datos['carnet'])
    ];
    $usuarios[] = $usuario;
    guardarUsuarios($usuarios);
    return $usuario;
}

function actualizarUsuario(string $id, array $datos): bool {
    $usuarios = leerUsuarios();
    foreach ($usuarios as &$usuario) {
        if ($usuario['id'] === $id) {
            $usuario['nombre'] = trim($datos['nombre']);
            $usuario['apellido'] = trim($datos['apellido']);
            $usuario['correo'] = trim($datos['correo']);
            $usuario['carnet'] = trim($datos['carnet']);
            return guardarUsuarios($usuarios);
        }
    }
    return false;
}

function eliminarUsuario(string $id): bool {
    $usuarios = leerUsuarios();
    $usuarios = array_filter($usuarios, fn($u) => $u['id'] !== $id);
    return guardarUsuarios(array_values($usuarios));
}

function validarDatos(array $datos): array {
    $errores = [];
    
    if (empty(trim($datos['nombre']))) {
        $errores['nombre'] = 'El nombre es requerido';
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', trim($datos['nombre']))) {
        $errores['nombre'] = 'El nombre debe tener 2-50 caracteres (solo letras)';
    }
    
    if (empty(trim($datos['apellido']))) {
        $errores['apellido'] = 'El apellido es requerido';
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/', trim($datos['apellido']))) {
        $errores['apellido'] = 'El apellido debe tener 2-50 caracteres (solo letras)';
    }
    
    if (empty(trim($datos['correo']))) {
        $errores['correo'] = 'El correo es requerido';
    } elseif (!filter_var(trim($datos['correo']), FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'El correo no es válido';
    }
    
    if (empty(trim($datos['carnet']))) {
        $errores['carnet'] = 'El carnet de identidad es requerido';
    } elseif (!preg_match('/^[0-9]{6,12}$/', trim($datos['carnet']))) {
        $errores['carnet'] = 'El carnet debe tener 6-12 dígitos numéricos';
    }
    
    return $errores;
}
