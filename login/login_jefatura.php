<?php
session_start();

// Configuración de la base de datos
$host = 'mysql';
$dbname = 'criminalistica_db';
$username = 'root';
$password = 'clave123';

// Función para conectar a la base de datos
function conectarDB() {
    global $host, $dbname, $username, $password;
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error de conexión a BD: " . $e->getMessage());
        return false;
    }
}

// Configuración de áreas administrativas
$areas_config = [
    'jefatura' => [
        'nombre' => 'Jefatura',
        'descripcion' => 'Panel de Jefatura - Gestión Superior',
        'color_primario' => '#1e40af',
        'color_secundario' => '#1e3a8a',
        'icono' => 'fas fa-user-tie',
        'redirect' => '../administracion/jefatura.php'
    ],
    'mesa_de_partes' => [
        'nombre' => 'Mesa de Partes',
        'descripcion' => 'Gestión de Documentos y Correspondencia',
        'color_primario' => '#059669',
        'color_secundario' => '#047857',
        'icono' => 'fas fa-inbox',
        'redirect' => '../administracion/mesa_de_partes.php'
    ],
    'administracion' => [
        'nombre' => 'Administración',
        'descripcion' => 'Gestión Administrativa y Recursos',
        'color_primario' => '#7c3aed',
        'color_secundario' => '#6d28d9',
        'icono' => 'fas fa-cogs',
        'redirect' => '../administracion/administracion.php'
    ]
];

// Función para mostrar notificación de usuario incorrecto
function mostrarNotificacionUsuarioIncorrecto($usuario = '', $area = '', $mensaje = '') {
    global $areas_config;
    
    $config = $areas_config[$area] ?? $areas_config['jefatura'];
    
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Usuario No Encontrado - {$config['nombre']}</title>";
    echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, {$config['color_primario']} 0%, {$config['color_secundario']} 50%, #0f2027 100%); margin: 0; padding: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }";
    echo ".error-container { background: rgba(255,255,255,0.95); padding: 3rem; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(239, 68, 68, 0.3); max-width: 450px; width: 90%; }";
    echo ".header { text-align: center; margin-bottom: 2rem; }";
    echo ".area-badge { background: {$config['color_primario']}; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; margin-bottom: 1rem; display: inline-block; }";
    echo ".error-icon { font-size: 3rem; color: #dc2626; margin-bottom: 1rem; animation: shake 0.5s ease-in-out; }";
    echo ".title { color: #dc2626; font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: bold; }";
    echo ".subtitle { color: #6b7280; font-size: 1rem; }";
    echo ".error-message { background: #fef2f2; color: #dc2626; padding: 1.5rem; border-radius: 10px; margin: 1.5rem 0; border-left: 4px solid #dc2626; }";
    echo ".error-details { background: #fef3c7; color: #d97706; padding: 1rem; border-radius: 8px; margin: 1rem 0; font-size: 0.9rem; }";
    echo ".btn-group { display: flex; gap: 1rem; margin-top: 2rem; }";
    echo ".btn { flex: 1; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; text-align: center; display: inline-block; }";
    echo ".btn-primary { background: {$config['color_primario']}; color: white; }";
    echo ".btn-primary:hover { background: {$config['color_secundario']}; transform: translateY(-1px); }";
    echo ".security-info { background: #f3f4f6; padding: 1rem; border-radius: 8px; font-size: 0.85rem; color: #4b5563; margin-top: 1rem; }";
    echo "@keyframes shake { 0%, 100% { transform: translateX(0); } 10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); } 20%, 40%, 60%, 80% { transform: translateX(5px); } }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    
    echo "<div class='error-container'>";
    echo "<div class='header'>";
    echo "<div class='area-badge'><i class='{$config['icono']}'></i> {$config['nombre']}</div>";
    echo "<div class='error-icon'><i class='fas fa-user-times'></i></div>";
    echo "<h1 class='title'>Usuario No Encontrado</h1>";
    echo "<p class='subtitle'>El usuario ingresado no existe en el sistema</p>";
    echo "</div>";
    
    echo "<div class='error-message'>";
    echo "<i class='fas fa-exclamation-circle'></i> ";
    echo $mensaje ?: "El usuario ingresado no está registrado en el área de {$config['nombre']}.";
    echo "</div>";
    
    if (!empty($usuario)) {
        echo "<div class='error-details'>";
        echo "<strong>Usuario ingresado:</strong> " . htmlspecialchars($usuario);
        echo "<br><small>Verifica que el usuario esté correctamente escrito</small>";
        echo "</div>";
    }
    
    echo "<div class='btn-group'>";
    echo "<a href='../index.php' class='btn btn-primary'>";
    echo "<i class='fas fa-arrow-left'></i> Volver al Login";
    echo "</a>";
    echo "</div>";
    
    echo "<div class='security-info'>";
    echo "<i class='fas fa-shield-alt'></i> Por seguridad, solo usuarios autorizados pueden acceder al sistema de {$config['nombre']}.";
    echo "</div>";
    
    echo "</div>";
    
    echo "</body>";
    echo "</html>";
}

// Función para mostrar formulario de reintento de contraseña
function mostrarFormularioReintento($usuario, $nombreCompleto, $cargo, $area, $error = '') {
    global $areas_config;
    
    $config = $areas_config[$area] ?? $areas_config['jefatura'];
    
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Verificación de Contraseña - {$config['nombre']}</title>";
    echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, {$config['color_primario']} 0%, {$config['color_secundario']} 50%, #0f2027 100%); margin: 0; padding: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }";
    echo ".retry-container { background: rgba(255,255,255,0.95); padding: 3rem; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(239, 68, 68, 0.3); max-width: 450px; width: 90%; }";
    echo ".header { text-align: center; margin-bottom: 2rem; }";
    echo ".area-badge { background: {$config['color_primario']}; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; margin-bottom: 1rem; display: inline-block; }";
    echo ".warning-icon { font-size: 3rem; color: #ef4444; margin-bottom: 1rem; }";
    echo ".title { color: #dc2626; font-size: 1.8rem; margin-bottom: 0.5rem; font-weight: bold; }";
    echo ".subtitle { color: #6b7280; font-size: 1rem; }";
    echo ".user-info { background: #fef3c7; padding: 1.5rem; border-radius: 10px; margin: 1.5rem 0; border-left: 4px solid #f59e0b; }";
    echo ".user-info h3 { color: #d97706; margin-bottom: 0.5rem; font-size: 1.1rem; }";
    echo ".user-info p { color: #92400e; margin: 0.3rem 0; font-size: 0.9rem; }";
    echo ".error-message { background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #ef4444; font-size: 0.9rem; }";
    echo ".form-group { margin-bottom: 1.5rem; }";
    echo ".form-group label { display: block; color: #374151; font-weight: 600; margin-bottom: 0.5rem; }";
    echo ".form-group input { width: 100%; padding: 0.75rem; border: 2px solid #d1d5db; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s; box-sizing: border-box; }";
    echo ".form-group input:focus { outline: none; border-color: {$config['color_primario']}; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }";
    echo ".btn-group { display: flex; gap: 1rem; margin-top: 2rem; }";
    echo ".btn { flex: 1; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; text-align: center; display: inline-block; }";
    echo ".btn-primary { background: {$config['color_primario']}; color: white; }";
    echo ".btn-primary:hover { background: {$config['color_secundario']}; transform: translateY(-1px); }";
    echo ".btn-secondary { background: #6b7280; color: white; }";
    echo ".btn-secondary:hover { background: #4b5563; }";
    echo ".security-info { background: #fef3c7; color: #92400e; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-top: 1rem; text-align: center; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    
    echo "<div class='retry-container'>";
    echo "<div class='header'>";
    echo "<div class='area-badge'><i class='{$config['icono']}'></i> {$config['nombre']}</div>";
    echo "<div class='warning-icon'><i class='fas fa-exclamation-triangle'></i></div>";
    echo "<h1 class='title'>Contraseña Incorrecta</h1>";
    echo "<p class='subtitle'>Por favor, verifica tu contraseña</p>";
    echo "</div>";
    
    if (!empty($error)) {
        echo "<div class='error-message'>";
        echo "<i class='fas fa-times-circle'></i> " . htmlspecialchars($error);
        echo "</div>";
    }
    
    echo "<div class='user-info'>";
    echo "<h3><i class='fas fa-user'></i> Usuario Identificado</h3>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($nombreCompleto) . "</p>";
    echo "<p><strong>Cargo:</strong> " . htmlspecialchars($cargo) . "</p>";
    echo "<p><strong>Usuario:</strong> " . htmlspecialchars($usuario) . "</p>";
    echo "<p><strong>Área:</strong> {$config['nombre']}</p>";
    echo "</div>";
    
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='usuario' value='" . htmlspecialchars($usuario) . "'>";
    echo "<input type='hidden' name='area' value='" . htmlspecialchars($area) . "'>";
    echo "<input type='hidden' name='retry_login' value='1'>";
    
    echo "<div class='form-group'>";
    echo "<label for='password'><i class='fas fa-lock'></i> Contraseña</label>";
    echo "<input type='password' id='password' name='password' required autofocus placeholder='Ingresa tu contraseña'>";
    echo "</div>";
    
    echo "<div class='btn-group'>";
    echo "<button type='submit' class='btn btn-primary'>";
    echo "<i class='fas fa-sign-in-alt'></i> Verificar Contraseña";
    echo "</button>";
    echo "<a href='../index.html' class='btn btn-secondary'>";
    echo "<i class='fas fa-arrow-left'></i> Cancelar";
    echo "</a>";
    echo "</div>";
    
    echo "</form>";
    
    echo "<div class='security-info'>";
    echo "<i class='fas fa-info-circle'></i> Por seguridad, asegúrate de ingresar la contraseña correcta";
    echo "</div>";
    
    echo "</div>";
    
    echo "</body>";
    echo "</html>";
}

// Función para mostrar página de éxito
function mostrarPaginaExito($user, $area) {
    global $areas_config;
    
    $config = $areas_config[$area] ?? $areas_config['jefatura'];
    
    echo "<!DOCTYPE html>";
    echo "<html lang='es'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Acceso Autorizado - {$config['nombre']}</title>";
    echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, {$config['color_primario']} 0%, {$config['color_secundario']} 50%, #0f2027 100%); margin: 0; padding: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }";
    echo ".success-container { background: rgba(255,255,255,0.95); padding: 3rem; border-radius: 20px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(74, 222, 128, 0.3); max-width: 500px; width: 90%; }";
    echo ".area-badge { background: {$config['color_primario']}; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; margin-bottom: 1rem; display: inline-block; }";
    echo ".success-icon { font-size: 4rem; color: #4ade80; margin-bottom: 1rem; animation: bounce 1s ease-in-out; }";
    echo ".success-title { color: #059669; font-size: 2rem; margin-bottom: 1rem; font-weight: bold; }";
    echo ".success-message { color: #374151; font-size: 1.1rem; margin-bottom: 0.5rem; }";
    echo ".user-info { background: #f0f9ff; padding: 1.5rem; border-radius: 10px; margin: 1.5rem 0; border-left: 4px solid #4ade80; }";
    echo ".redirect-info { color: #6b7280; font-size: 0.9rem; margin-top: 1.5rem; }";
    echo ".loading-bar { width: 100%; height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden; margin-top: 1rem; }";
    echo ".loading-progress { height: 100%; background: linear-gradient(90deg, #4ade80, #059669); width: 0%; animation: loading 3s ease-in-out forwards; }";
    echo "@keyframes bounce { 0%, 20%, 60%, 100% { transform: translateY(0); } 40% { transform: translateY(-10px); } 80% { transform: translateY(-5px); } }";
    echo "@keyframes loading { 0% { width: 0%; } 100% { width: 100%; } }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    
    echo "<div class='success-container'>";
    echo "<div class='area-badge'><i class='{$config['icono']}'></i> {$config['nombre']}</div>";
    echo "<div class='success-icon'><i class='fas fa-check-circle'></i></div>";
    echo "<h1 class='success-title'>¡Acceso Autorizado!</h1>";
    echo "<p class='success-message'>Bienvenido al {$config['descripcion']}</p>";
    
    echo "<div class='user-info'>";
    echo "<h3 style='color: #059669; margin-bottom: 0.5rem;'><i class='fas fa-user'></i> Información del Usuario</h3>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($user['nombre_completo']) . "</p>";
    echo "<p><strong>Cargo:</strong> " . htmlspecialchars($user['cargo']) . "</p>";
    echo "<p><strong>Usuario:</strong> " . htmlspecialchars($user['usuario']) . "</p>";
    echo "<p><strong>Área:</strong> {$config['nombre']}</p>";
    echo "</div>";
    
    echo "<div class='redirect-info'>";
    echo "<i class='fas fa-arrow-right'></i> Redirigiendo al Panel de {$config['nombre']}...";
    echo "<div class='loading-bar'><div class='loading-progress'></div></div>";
    echo "</div>";
    
    echo "</div>";
    
    // Script para redirección automática
    echo "<script>";
    echo "setTimeout(function() {";
    echo "    window.location.href = '{$config['redirect']}';";
    echo "}, 3000);"; // 3 segundos
    echo "</script>";
    
    echo "</body>";
    echo "</html>";
}

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener y limpiar datos del formulario
    $inputUsuario = trim($_POST['usuario'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');
    $inputArea = trim($_POST['area'] ?? '');
    $isRetry = isset($_POST['retry_login']) && $_POST['retry_login'] === '1';
    
    // Validar que los campos no estén vacíos
    if (empty($inputUsuario) || empty($inputPassword)) {
        if ($isRetry) {
            // Si es un reintento y falta la contraseña, mostrar error
            $pdo = conectarDB();
            if ($pdo) {
                $stmt = $pdo->prepare("SELECT usuario, nombre_completo, cargo, area FROM usuarios_admin WHERE usuario = ? AND area = ? LIMIT 1");
                $stmt->execute([$inputUsuario, $inputArea]);
                $user = $stmt->fetch();
                if ($user) {
                    mostrarFormularioReintento($user['usuario'], $user['nombre_completo'], $user['cargo'], $user['area'], 'La contraseña es requerida');
                    exit;
                }
            }
        }
        header('Location: ../index.html?error=empty_fields&usuario=' . urlencode($inputUsuario));
        exit;
    }
    
    // Validar área válida
    if (!in_array($inputArea, ['jefatura', 'mesa_de_partes', 'administracion'])) {
        header('Location: ../index.html?error=invalid_area');
        exit;
    }
    
    // Conectar a la base de datos
    $pdo = conectarDB();
    if (!$pdo) {
        header('Location: ../index.html?error=db_connection');
        exit;
    }
    
    try {
        // Buscar usuario en la base de datos
        $stmt = $pdo->prepare("
            SELECT id, usuario, password, area, nombre_completo, cargo, estado, ultimo_acceso 
            FROM usuarios_admin 
            WHERE usuario = ? AND area = ?
            LIMIT 1
        ");
        
        $stmt->execute([$inputUsuario, $inputArea]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Verificar estado del usuario
            if ($user['estado'] !== 'activo') {
                header('Location: ../index.html?error=user_inactive&usuario=' . urlencode($inputUsuario));
                exit;
            }
            
            // Verificar contraseña
            $passwordValida = false;
            
            // Intentar verificar con hash primero
            if (password_verify($inputPassword, $user['password'])) {
                $passwordValida = true;
            } 
            // Si no funciona con hash, verificar texto plano
            elseif ($inputPassword === $user['password']) {
                $passwordValida = true;
                
                // Hashear la contraseña para futuras validaciones
                $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE usuarios_admin SET password = ? WHERE id = ?");
                $updateStmt->execute([$hashedPassword, $user['id']]);
            }
            
            if ($passwordValida) {
                // LOGIN EXITOSO
                
                // Crear variables de sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['nombre_completo'] = $user['nombre_completo'];
                $_SESSION['cargo'] = $user['cargo'];
                $_SESSION['area'] = $user['area'];
                $_SESSION['login_time'] = time();
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
                $_SESSION['last_activity'] = time();
                
                // Actualizar último acceso
                $updateStmt = $pdo->prepare("UPDATE usuarios_admin SET ultimo_acceso = NOW() WHERE id = ?");
                $updateStmt->execute([$user['id']]);
                
                // Mostrar página de éxito con redirección automática
                mostrarPaginaExito($user, $user['area']);
                exit;
                
            } else {
                // CONTRASEÑA INCORRECTA - Mostrar formulario de reintento
                $errorMessage = $isRetry ? 'Contraseña incorrecta. Inténtalo nuevamente.' : 'La contraseña ingresada es incorrecta.';
                mostrarFormularioReintento($user['usuario'], $user['nombre_completo'], $user['cargo'], $user['area'], $errorMessage);
                exit;
            }
            
        } else {
            // USUARIO NO ENCONTRADO
            $config = $areas_config[$inputArea] ?? $areas_config['jefatura'];
            mostrarNotificacionUsuarioIncorrecto($inputUsuario, $inputArea, "El usuario \"" . htmlspecialchars($inputUsuario) . "\" no está registrado en el área de {$config['nombre']}. Por favor, ingrese un usuario válido.");
            exit;
        }
        
    } catch (PDOException $e) {
        error_log("Error de consulta BD: " . $e->getMessage());
        header('Location: ../index.html?error=db_connection');
        exit;
    }
    
} else {
    // Si no es POST, redireccionar al inicio
    header('Location: ../index.html');
    exit;
}
?>