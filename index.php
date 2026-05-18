<?php
// Iniciamos sesión
session_start();

// Verificar si ya existe un mensaje de error o sesión activa
$error_mensaje = "";
if (isset($_SESSION['error'])) {
    $error_mensaje = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - La Huanuqueñita</title>

    <link rel="stylesheet" href="style.css">
    <style>
        .error-mensaje {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            display: none;
        }
        
        .error-mensaje.mostrar {
            display: block;
        }
        
        .success-mensaje {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="login-body">

    <div class="login-box">

        <div class="login-image">
            <img src="480714661_1044878470990859_1347130181764562084_n.jpg" alt="Restaurante">
        </div>

        <div class="login-content">

            <h1>La Huanuqueñita</h1>

            <p>
                Sistema de proyección semanal de compras y ventas.
            </p>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error_mensaje)): ?>
                <div class="error-mensaje mostrar">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error_mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de login -->
            <form action="validar_login.php" method="POST">

                <input 
                    type="text" 
                    name="usuario" 
                    placeholder="Usuario" 
                    required
                    minlength="3"
                >

                <input 
                    type="password" 
                    name="password" 
                    placeholder="Contraseña" 
                    required
                    minlength="4"
                >

                <button type="submit">Ingresar</button>

            </form>

            <p style="font-size: 12px; color: #666; margin-top: 10px;">
                <strong>Demo:</strong> Usuario: admin | Contraseña: 1234
            </p>

        </div>

    </div>

</body>
</html>
