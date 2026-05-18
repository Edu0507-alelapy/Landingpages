<?php
/**
 * validar_login.php
 * 
 * Sistema de validación de login con múltiples restricciones
 * Implementa 11 validaciones diferentes usando condicionales
 */

// Iniciamos sesión
session_start();

// Array de usuarios válidos (en producción, usar base de datos)
$usuarios_validos = [
    [
        'usuario' => 'admin',
        'password' => '1234',
        'nombre' => 'Administrador',
        'rol' => 'admin'
    ],
    [
        'usuario' => 'gerente',
        'password' => 'password123',
        'nombre' => 'Gerente General',
        'rol' => 'gerente'
    ],
    [
        'usuario' => 'empleado',
        'password' => 'emp123',
        'nombre' => 'Empleado',
        'rol' => 'empleado'
    ]
];

// RESTRICCIÓN 1: Verificar que el método de envío sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Método de solicitud inválido.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 2: Verificar que los campos existan
if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Campos faltantes en la solicitud.";
    header("Location: index.php");
    exit();
}

// Obtener valores y limpiar espacios en blanco (RESTRICCIÓN 3)
$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

// RESTRICCIÓN 4: Verificar que los campos no estén vacíos
if (empty($usuario)) {
    $_SESSION['error'] = "El usuario no puede estar vacío.";
    header("Location: index.php");
    exit();
}

if (empty($password)) {
    $_SESSION['error'] = "La contraseña no puede estar vacía.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 5: Verificar longitud mínima del usuario (3 caracteres)
if (strlen($usuario) < 3) {
    $_SESSION['error'] = "El usuario debe tener mínimo 3 caracteres.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 6: Verificar longitud mínima de contraseña (4 caracteres)
if (strlen($password) < 4) {
    $_SESSION['error'] = "La contraseña debe tener mínimo 4 caracteres.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 7: Verificar longitud máxima del usuario (50 caracteres)
if (strlen($usuario) > 50) {
    $_SESSION['error'] = "El usuario no puede exceder 50 caracteres.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 8: Verificar longitud máxima de contraseña (100 caracteres)
if (strlen($password) > 100) {
    $_SESSION['error'] = "La contraseña no puede exceder 100 caracteres.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 9 y 10: Buscar usuario en la base de datos y validar contraseña
$usuario_encontrado = false;
$usuario_valido = false;
$usuario_datos = null;

// Recorrer array de usuarios (RESTRICCIÓN 9 con foreach)
foreach ($usuarios_validos as $usr) {
    // Comparar usuario
    if ($usr['usuario'] === $usuario) {
        $usuario_encontrado = true;
        
        // Verificar contraseña (RESTRICCIÓN 10)
        if ($usr['password'] === $password) {
            $usuario_valido = true;
            $usuario_datos = $usr;
            break; // Salir del bucle al encontrar coincidencia
        }
    }
}

// Manejar usuario no encontrado
if (!$usuario_encontrado) {
    $_SESSION['error'] = "El usuario no existe en el sistema.";
    header("Location: index.php");
    exit();
}

// Manejar contraseña incorrecta
if (!$usuario_valido) {
    $_SESSION['error'] = "La contraseña es incorrecta.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN 11: Si llegamos aquí, el login es válido - Crear sesión
$_SESSION['usuario'] = $usuario_datos['usuario'];
$_SESSION['nombre'] = $usuario_datos['nombre'];
$_SESSION['rol'] = $usuario_datos['rol'];
$_SESSION['inicio_sesion'] = time(); // Guardamos timestamp para timeout

// Redireccionar al panel de usuario
header("Location: panel.php");
exit();
?>
