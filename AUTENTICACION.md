# 🔐 Sistema de Autenticación PHP - La Huanuqueñita

## 📋 Descripción
Sistema de login y autenticación desarrollado en **PHP** con restricciones de seguridad para el restaurante "La Huanuqueñita".

## 🗂️ Archivos Principales

### 1. **index.php** (Login)
- ✅ Formulario POST seguro
- ✅ Validación HTML5 (minlength, required)
- ✅ Manejo de sesiones
- ✅ Visualización de errores

### 2. **validar_login.php** (Lógica de Autenticación)
Implementa **11 restricciones principales**:

1. ✅ Verificar método POST
2. ✅ Verificar existencia de campos
3. ✅ Limpiar espacios en blanco (trim)
4. ✅ Validar campos no vacíos
5. ✅ Longitud mínima usuario (3 caracteres)
6. ✅ Longitud mínima contraseña (4 caracteres)
7. ✅ Longitud máxima usuario (50 caracteres)
8. ✅ Longitud máxima contraseña (100 caracteres)
9. ✅ Buscar usuario en base de datos
10. ✅ Validar contraseña correcta
11. ✅ Crear sesión y redirigir

### 3. **panel.php** (Página Protegida)
- ✅ Verificación de sesión activa
- ✅ Redirección automática si no está autenticado
- ✅ Timeout de sesión (30 minutos)
- ✅ Visualización de datos del usuario
- ✅ Botón de cerrar sesión
- ✅ Destrucción segura de sesión

## 🔑 Credenciales de Prueba

| Usuario  | Contraseña   | Nombre          | Rol       |
|----------|--------------|-----------------|-----------|
| admin    | 1234         | Administrador   | admin     |
| gerente  | password123  | Gerente General | gerente   |
| empleado | emp123       | Empleado        | empleado  |

## 💡 Prácticas Implementadas

✅ **Condicionales** - if, elseif, else  
✅ **Bucles** - foreach para buscar usuarios  
✅ **Arrays** - almacenamiento de usuarios  
✅ **Funciones PHP** - isset(), trim(), strlen(), htmlspecialchars()  
✅ **Sesiones** - $_SESSION para mantener datos del usuario  
✅ **Sanitización** - htmlspecialchars() para evitar XSS  
✅ **Validación de entrada** - múltiples checks en cada campo  
✅ **Redirecciones** - header() para control de flujo  
✅ **Control de flujo** - exit() para detener ejecución  

## 🚀 Cómo Usar

1. Asegúrate de tener PHP instalado en tu servidor
2. Coloca estos archivos en la raíz del proyecto
3. Accede a `http://localhost/index.php` (o tu dominio)
4. Ingresa las credenciales de prueba
5. Si es correcto, verás el panel de usuario

## ⚙️ Configuración Recomendada

Para un entorno de **producción**:

1. **Hash de contraseñas** - Usar `password_hash()` en lugar de almacenarlas en texto plano
2. **Base de datos** - Reemplazar array de usuarios con conexión a MySQL
3. **HTTPS** - Usar conexión segura
4. **CSRF Protection** - Implementar tokens anti-CSRF
5. **Rate Limiting** - Limitar intentos de login
6. **Logs** - Registrar intentos fallidos

## 📝 Ejemplo Avanzado (Bonus)

Para mejorar la seguridad, puedes usar:

```php
// Hash seguro de contraseña
$hash_password = password_hash($password, PASSWORD_BCRYPT);

// Verificación de contraseña
if (password_verify($password, $hash_password)) {
    // Contraseña correcta
}
```

## 🐛 Resolución de Problemas

**Problema:** Las sesiones no funcionan
- **Solución:** Asegúrate de llamar a `session_start()` antes de cualquier salida HTML

**Problema:** Los archivos .html no se cargan desde panel.php
- **Solución:** Reemplaza los archivos .html con .php o crea archivos PHP que carguen los HTML

## 📚 Recursos Adicionales

- [PHP Sessions](https://www.php.net/manual/es/book.session.php)
- [Seguridad en PHP](https://www.php.net/manual/es/security.php)
- [Validación de entrada](https://owasp.org/www-community/attacks/xss/)

---

**Desarrollado con PHP** ✨
