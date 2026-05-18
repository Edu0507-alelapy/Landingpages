<?php
/**
 * panel.php
 * 
 * Página protegida del sistema
 * Solo accesible con sesión activa
 * Implementa timeout y validación de seguridad
 */

// Iniciamos sesión
session_start();

// Definir tiempo máximo de sesión (30 minutos)
$tiempo_maximo = 1800;

// RESTRICCIÓN: Verificar si existe sesión activa
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión primero.";
    header("Location: index.php");
    exit();
}

// RESTRICCIÓN: Verificar timeout de sesión
if (isset($_SESSION['inicio_sesion'])) {
    $tiempo_transcurrido = time() - $_SESSION['inicio_sesion'];
    
    if ($tiempo_transcurrido > $tiempo_maximo) {
        session_destroy();
        $_SESSION['error'] = "Tu sesión ha expirado.";
        header("Location: index.php");
        exit();
    }
}

// Obtener datos de la sesión
$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];

// RESTRICCIÓN: Manejar cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Función para mostrar rol de forma legible
function mostrar_rol($rol) {
    $roles = [
        'admin' => 'Administrador',
        'gerente' => 'Gerente',
        'empleado' => 'Empleado'
    ];
    return isset($roles[$rol]) ? $roles[$rol] : 'Desconocido';
}

// Función para verificar permisos
function tiene_permiso($rol, $accion) {
    $permisos = [
        'admin' => ['ver_panel', 'editar_usuarios', 'ver_reportes', 'configuracion'],
        'gerente' => ['ver_panel', 'ver_reportes', 'editar_platos'],
        'empleado' => ['ver_panel', 'ver_pedidos']
    ];
    return isset($permisos[$rol]) && in_array($accion, $permisos[$rol]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - La Huanuqueñita</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .panel-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .panel-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .panel-header-info h1 {
            margin: 0;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .panel-header-info p {
            margin: 5px 0;
            opacity: 0.9;
        }

        .panel-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .panel-logout:hover {
            background-color: white;
            color: #667eea;
        }

        .panel-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: #667eea;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .card-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 24px;
            color: #333;
            margin-top: 30px;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .info-box strong {
            color: #667eea;
        }

        .restricted {
            color: #999;
            font-style: italic;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .feature-list li:before {
            content: "✓ ";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }

        .feature-list li.restricted:before {
            content: "✗ ";
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="panel-container">
        
        <div class="panel-header">
            <div class="panel-header-info">
                <h1>🍽️ La Huanuqueñita</h1>
                <p><strong>Bienvenido:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Rol:</strong> <?php echo mostrar_rol($rol); ?></p>
            </div>
            <a href="?logout=true" class="panel-logout">Cerrar Sesión</a>
        </div>

        <div class="info-box">
            <strong>Estado de Sesión:</strong> Activa ✓ 
            <br>
            <strong>Tiempo máximo:</strong> 30 minutos
            <br>
            <strong>Hora:</strong> <?php echo date('H:i:s'); ?>
        </div>

        <div class="section-title">📊 Información del Usuario</div>
        <div class="panel-content">
            <div class="card">
                <div class="card-icon">👤</div>
                <h2>Datos del Usuario</h2>
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Rol:</strong> <?php echo mostrar_rol($rol); ?></p>
            </div>

            <div class="card">
                <div class="card-icon">🔐</div>
                <h2>Seguridad</h2>
                <p>Tu sesión está protegida con:</p>
                <ul class="feature-list">
                    <li>Validación de credenciales</li>
                    <li>Timeout automático 30 min</li>
                    <li>Control de sesión</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-icon">ℹ️</div>
                <h2>Sistema</h2>
                <p><strong>Sistema:</strong> La Huanuqueñita</p>
                <p><strong>Versión:</strong> 1.0.0</p>
                <p><strong>Estado:</strong> ✓ En línea</p>
            </div>
        </div>

        <div class="section-title">🎯 Funcionalidades por Rol</div>
        <div class="panel-content">
            <div class="card">
                <div class="card-icon">⚙️</div>
                <h2>Panel de Control</h2>
                <ul class="feature-list">
                    <li <?php if (!tiene_permiso($rol, 'ver_panel')) echo 'class="restricted"'; ?>>
                        Ver Dashboard
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'editar_usuarios')) echo 'class="restricted"'; ?>>
                        Gestionar Usuarios
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'configuracion')) echo 'class="restricted"'; ?>>
                        Configuración
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-icon">📊</div>
                <h2>Reportes</h2>
                <ul class="feature-list">
                    <li <?php if (!tiene_permiso($rol, 'ver_reportes')) echo 'class="restricted"'; ?>>
                        Reportes de Ventas
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'ver_reportes')) echo 'class="restricted"'; ?>>
                        Proyección de Compras
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'editar_platos')) echo 'class="restricted"'; ?>>
                        Gestionar Menú
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-icon">📝</div>
                <h2>Operaciones</h2>
                <ul class="feature-list">
                    <li <?php if (!tiene_permiso($rol, 'ver_pedidos')) echo 'class="restricted"'; ?>>
                        Ver Pedidos
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'editar_platos')) echo 'class="restricted"'; ?>>
                        Editar Platos
                    </li>
                    <li <?php if (!tiene_permiso($rol, 'ver_reportes')) echo 'class="restricted"'; ?>>
                        Historial
                    </li>
                </ul>
            </div>
        </div>

        <div class="info-box" style="margin-top: 40px; text-align: center;">
            <p>Sistema de gestión - La Huanuqueñita © 2026</p>
            <p style="font-size: 12px;">Desarrollado con PHP | Seguridad implementada</p>
        </div>

    </div>

</body>
</html>
