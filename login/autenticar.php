<?php
/**
 * AUTENTICAR - CRIMINALÍSTICA PUNO
 * Archivo PHP para autenticación final y creación de sesión
 * Ajustado para la estructura existente del sistema
 */

session_start();

// Configuración de headers para JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Incluir la conexión existente
require_once '../conexion/conexion.php';

try {
    // Verificar datos requeridos
    if (!isset($_POST['usuario']) || !isset($_POST['password']) || 
        !isset($_POST['area']) || !isset($_POST['step'])) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $areaSeleccionada = trim($_POST['area']);
    $step = $_POST['step'];

    // Validar que es el paso 2
    if ($step !== '2') {
        echo json_encode(['success' => false, 'message' => 'Paso de autenticación inválido']);
        exit;
    }

    // Usar la conexión existente
    global $conexion;

    // Verificar nuevamente las credenciales por seguridad
    $stmt = $conexion->prepare("
        SELECT 
            id,
            usuario,
            password,
            nombres,
            apellidos,
            email,
            area,
            cargo,
            estado
        FROM usuarios
        WHERE usuario = ? AND estado = 'activo'
    ");

    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }

    $userData = $resultado->fetch_assoc();

    // Verificar contraseña nuevamente por seguridad
    // Si tu sistema usa password_hash(), usa esta línea:
    $passwordValida = password_verify($password, $userData['password']);
    
    // Si tu sistema usa MD5, descomenta esta línea y comenta la anterior:
    // $passwordValida = (md5($password) === $userData['password']);
    
    // Si tu sistema usa SHA1, descomenta esta línea y comenta la anterior:
    // $passwordValida = (sha1($password) === $userData['password']);
    
    // Si las contraseñas están en texto plano (NO RECOMENDADO), descomenta esta línea:
    // $passwordValida = ($password === $userData['password']);

    if (!$passwordValida) {
        echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
        exit;
    }

    // Verificar que el usuario tiene acceso al área seleccionada
    $areasPermitidas = obtenerAreasPermitidas($userData['area'], $userData['cargo']);
    if (!in_array($areaSeleccionada, $areasPermitidas)) {
        echo json_encode(['success' => false, 'message' => 'No tiene acceso al área seleccionada']);
        exit;
    }

    // Obtener información del área
    $areaInfo = obtenerInformacionArea($areaSeleccionada);

    // Crear sesión
    crearSesionUsuario($userData, $areaInfo);

    // Registrar inicio de sesión exitoso
    registrarInicioSesion($conexion, $userData['id'], $areaSeleccionada);

    // Determinar URL de redirección según el área
    $redirectUrl = determinarUrlRedireccion($areaSeleccionada);

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Autenticación exitosa',
        'redirect_url' => $redirectUrl,
        'user' => [
            'id' => $userData['id'],
            'usuario' => $userData['usuario'],
            'nombre_completo' => trim($userData['nombres'] . ' ' . $userData['apellidos']),
            'email' => $userData['email'],
            'area' => $userData['area'],
            'cargo' => $userData['cargo']
        ],
        'area' => $areaInfo,
        'session_id' => session_id(),
        'csrf_token' => $_SESSION['csrf_token']
    ]);

} catch (Exception $e) {
    error_log("Error en autenticar.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
}

/**
 * Obtener áreas permitidas según el área y cargo del usuario
 */
function obtenerAreasPermitidas($area, $cargo) {
    $areas_disponibles = [];
    
    switch ($area) {
        case 'mesa_de_partes':
            $areas_disponibles = ['mesa_de_partes'];
            if ($cargo === 'jefe_de_unidad') {
                $areas_disponibles[] = 'cerap';
            }
            break;
            
        case 'identificacion':
            $areas_disponibles = ['identificacion'];
            if ($cargo === 'jefe_de_unidad') {
                $areas_disponibles[] = 'grafotecnia';
            }
            break;
            
        case 'grafotecnia':
            $areas_disponibles = ['grafotecnia'];
            if ($cargo === 'jefe_de_unidad') {
                $areas_disponibles[] = 'identificacion';
            }
            break;
            
        case 'area_crime':
            $areas_disponibles = ['cerap', 'mesa_de_partes'];
            break;
            
        case 'secretaria':
            $areas_disponibles = ['mesa_de_partes'];
            break;
            
        case 'balistica':
            $areas_disponibles = ['balistica'];
            break;
            
        case 'antropologia':
            $areas_disponibles = ['antropologia'];
            break;
            
        case 'cerap':
            $areas_disponibles = ['cerap'];
            break;
            
        default:
            $areas_disponibles = ['mesa_de_partes'];
            break;
    }
    
    // Si es jefe de unidad, dar acceso a múltiples áreas
    if ($cargo === 'jefe_de_unidad') {
        $areas_disponibles = array_unique(array_merge($areas_disponibles, [
            'cerap', 'balistica', 'antropologia', 'mesa_de_partes', 'identificacion', 'grafotecnia'
        ]));
    }
    
    // Si es administrador, dar acceso a todas las áreas
    if ($cargo === 'administrador') {
        $areas_disponibles = ['cerap', 'balistica', 'antropologia', 'mesa_de_partes', 'identificacion', 'grafotecnia'];
    }
    
    return $areas_disponibles;
}

/**
 * Obtener información del área seleccionada
 */
function obtenerInformacionArea($codigoArea) {
    $areas = [
        'cerap' => [
            'codigo_area' => 'cerap',
            'nombre_area' => 'CERAP',
            'descripcion' => 'Centro de Registros y Archivos Policiales',
            'responsable' => 'Oficial Superior PNP',
            'ubicacion' => 'Primer Piso - Ala Norte'
        ],
        'balistica' => [
            'codigo_area' => 'balistica',
            'nombre_area' => 'Balística',
            'descripcion' => 'División de Análisis Balístico y Explosivos',
            'responsable' => 'Mayor PNP',
            'ubicacion' => 'Segundo Piso - Laboratorio A'
        ],
        'antropologia' => [
            'codigo_area' => 'antropologia',
            'nombre_area' => 'Antropología',
            'descripcion' => 'División de Antropología Forense',
            'responsable' => 'Capitán PNP',
            'ubicacion' => 'Primer Piso - Laboratorio B'
        ],
        'mesa_de_partes' => [
            'codigo_area' => 'mesa_de_partes',
            'nombre_area' => 'Mesa de Partes',
            'descripcion' => 'Recepción y Trámite Documentario',
            'responsable' => 'Técnico PNP',
            'ubicacion' => 'Planta Baja - Recepción'
        ],
        'identificacion' => [
            'codigo_area' => 'identificacion',
            'nombre_area' => 'Identificación',
            'descripcion' => 'División de Identificación Policial',
            'responsable' => 'Comandante PNP',
            'ubicacion' => 'Segundo Piso - Ala Sur'
        ],
        'grafotecnia' => [
            'codigo_area' => 'grafotecnia',
            'nombre_area' => 'Grafotecnia',
            'descripcion' => 'División de Grafotecnia y Documentoscopía',
            'responsable' => 'Mayor PNP',
            'ubicacion' => 'Tercer Piso - Laboratorio C'
        ]
    ];
    
    return $areas[$codigoArea] ?? [
        'codigo_area' => $codigoArea,
        'nombre_area' => 'Área Desconocida',
        'descripcion' => 'Descripción no disponible',
        'responsable' => 'No asignado',
        'ubicacion' => 'No especificada'
    ];
}

/**
 * Crear sesión de usuario segura
 */
function crearSesionUsuario($userData, $areaInfo) {
    // Regenerar ID de sesión por seguridad
    session_regenerate_id(true);
    
    // Limpiar sesión anterior
    $_SESSION = [];
    
    // Configurar variables de sesión
    $_SESSION['user_authenticated'] = true;
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['usuario'] = $userData['usuario'];
    $_SESSION['nombres'] = $userData['nombres'];
    $_SESSION['apellidos'] = $userData['apellidos'];
    $_SESSION['nombre_completo'] = trim($userData['nombres'] . ' ' . $userData['apellidos']);
    $_SESSION['email'] = $userData['email'];
    $_SESSION['area_usuario'] = $userData['area'];
    $_SESSION['cargo'] = $userData['cargo'];
    
    // Información del área seleccionada
    $_SESSION['area_seleccionada'] = $areaInfo['codigo_area'];
    $_SESSION['area_nombre'] = $areaInfo['nombre_area'];
    $_SESSION['area_descripcion'] = $areaInfo['descripcion'];
    $_SESSION['area_responsable'] = $areaInfo['responsable'];
    $_SESSION['area_ubicacion'] = $areaInfo['ubicacion'];
    
    // Metadatos de sesión
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
    $_SESSION['session_start'] = date('Y-m-d H:i:s');
    
    // Token CSRF para seguridad
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    
    // Configuraciones adicionales
    $_SESSION['timezone'] = 'America/Lima';
    $_SESSION['language'] = 'es';
    
    // Configurar timeout de sesión (30 minutos)
    $_SESSION['timeout'] = time() + (30 * 60);
}

/**
 * Registrar inicio de sesión exitoso en logs
 */
function registrarInicioSesion($conexion, $idUsuario, $areaSeleccionada) {
    try {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
        $sessionId = session_id();
        
        // Crear tabla de logs si no existe
        $conexion->query("
            CREATE TABLE IF NOT EXISTS logs_acceso (
                id_log INT AUTO_INCREMENT PRIMARY KEY,
                id_usuario INT,
                tipo_evento VARCHAR(50),
                ip_origen VARCHAR(45),
                user_agent TEXT,
                detalles TEXT,
                fecha_evento DATETIME DEFAULT CURRENT_TIMESTAMP,
                session_id VARCHAR(128),
                INDEX idx_usuario (id_usuario),
                INDEX idx_fecha (fecha_evento),
                INDEX idx_session (session_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        // Registrar en logs de acceso
        $stmt = $conexion->prepare("
            INSERT INTO logs_acceso (id_usuario, tipo_evento, ip_origen, user_agent, detalles, session_id)
            VALUES (?, 'login_exitoso', ?, ?, ?, ?)
        ");
        
        if ($stmt) {
            $detalles = "Login exitoso - Área: " . $areaSeleccionada . " - Sesión iniciada";
            $stmt->bind_param("issss", $idUsuario, $ip, $userAgent, $detalles, $sessionId);
            $stmt->execute();
            $stmt->close();
        }
        
        // Crear tabla de sesiones activas si no existe
        $conexion->query("
            CREATE TABLE IF NOT EXISTS sesiones_activas (
                id_sesion INT AUTO_INCREMENT PRIMARY KEY,
                id_usuario INT,
                session_id VARCHAR(128) UNIQUE,
                ip_origen VARCHAR(45),
                user_agent TEXT,
                area_seleccionada VARCHAR(50),
                fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
                ultima_actividad DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                fecha_fin DATETIME NULL,
                estado ENUM('activa', 'cerrada', 'expirada') DEFAULT 'activa',
                INDEX idx_usuario (id_usuario),
                INDEX idx_session_id (session_id),
                INDEX idx_estado (estado)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        // Registrar sesión activa
        $stmt = $conexion->prepare("
            INSERT INTO sesiones_activas (id_usuario, session_id, ip_origen, user_agent, area_seleccionada)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                ultima_actividad = CURRENT_TIMESTAMP,
                area_seleccionada = VALUES(area_seleccionada),
                estado = 'activa'
        ");
        
        if ($stmt) {
            $stmt->bind_param("issss", $idUsuario, $sessionId, $ip, $userAgent, $areaSeleccionada);
            $stmt->execute();
            $stmt->close();
        }
        
    } catch (Exception $e) {
        error_log("Error registrando inicio de sesión: " . $e->getMessage());
    }
}

/**
 * Determinar URL de redirección según el área seleccionada
 */
function determinarUrlRedireccion($codigoArea) {
    $urls = [
        'cerap' => '../areas/cerap.php',
        'balistica' => '../areas/balistica.php',
        'antropologia' => '../areas/antropologia.php',
        'mesa_de_partes' => '../areas/mesa_de_partes.php',
        'identificacion' => '../areas/identificacion.php',
        'grafotecnia' => '../areas/grafotecnia.php'
    ];
    
    return $urls[$codigoArea] ?? '../administracion/index.php';
}

/**
 * Validar sesión existente
 */
function validarSesion() {
    if (!isset($_SESSION['user_authenticated']) || !$_SESSION['user_authenticated']) {
        return false;
    }
    
    // Verificar timeout
    if (isset($_SESSION['timeout']) && time() > $_SESSION['timeout']) {
        session_destroy();
        return false;
    }
    
    // Actualizar último acceso
    $_SESSION['last_activity'] = time();
    $_SESSION['timeout'] = time() + (30 * 60); // 30 minutos más
    
    return true;
}

/**
 * Cerrar sesión de forma segura
 */
function cerrarSesion($conexion, $idUsuario = null) {
    try {
        if ($idUsuario && isset($_SESSION['user_id'])) {
            $sessionId = session_id();
            
            // Registrar cierre de sesión
            $stmt = $conexion->prepare("
                INSERT INTO logs_acceso (id_usuario, tipo_evento, ip_origen, user_agent, detalles, session_id)
                VALUES (?, 'logout', ?, ?, 'Sesión cerrada manualmente', ?)
            ");
            
            if ($stmt) {
                $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
                $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';
                $stmt->bind_param("isss", $idUsuario, $ip, $userAgent, $sessionId);
                $stmt->execute();
                $stmt->close();
            }
            
            // Actualizar sesión activa
            $stmt = $conexion->prepare("
                UPDATE sesiones_activas 
                SET fecha_fin = CURRENT_TIMESTAMP, estado = 'cerrada'
                WHERE session_id = ? AND id_usuario = ?
            ");
            
            if ($stmt) {
                $stmt->bind_param("si", $sessionId, $idUsuario);
                $stmt->execute();
                $stmt->close();
            }
        }
        
    } catch (Exception $e) {
        error_log("Error cerrando sesión: " . $e->getMessage());
    }
    
    // Limpiar variables de sesión
    $_SESSION = [];
    
    // Destruir cookie de sesión
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destruir sesión
    session_destroy();
}

/**
 * Obtener información de la sesión actual
 */
function obtenerInfoSesion() {
    if (!validarSesion()) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'] ?? null,
        'usuario' => $_SESSION['usuario'] ?? null,
        'nombre_completo' => $_SESSION['nombre_completo'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'cargo' => $_SESSION['cargo'] ?? null,
        'area_usuario' => $_SESSION['area_usuario'] ?? null,
        'area_seleccionada' => $_SESSION['area_seleccionada'] ?? null,
        'area_nombre' => $_SESSION['area_nombre'] ?? null,
        'login_time' => $_SESSION['login_time'] ?? null,
        'last_activity' => $_SESSION['last_activity'] ?? null,
        'csrf_token' => $_SESSION['csrf_token'] ?? null
    ];
}

/**
 * Verificar permisos para área específica
 */
function verificarPermisoArea($areaRequerida) {
    if (!validarSesion()) {
        return false;
    }
    
    $areaUsuario = $_SESSION['area_usuario'] ?? null;
    $cargo = $_SESSION['cargo'] ?? null;
    $areasPermitidas = obtenerAreasPermitidas($areaUsuario, $cargo);
    
    return in_array($areaRequerida, $areasPermitidas);
}

/**
 * Función de utilidad para sanitizar datos
 */
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Generar token CSRF
 */
function generarCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verificarCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Limpiar sesiones expiradas (llamar periódicamente)
 */
function limpiarSesionesExpiradas($conexion) {
    try {
        // Marcar sesiones como expiradas (más de 30 minutos sin actividad)
        $conexion->query("
            UPDATE sesiones_activas 
            SET fecha_fin = CURRENT_TIMESTAMP, estado = 'expirada'
            WHERE ultima_actividad < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE)
            AND estado = 'activa'
        ");
        
        // Opcional: eliminar sesiones antiguas (más de 24 horas)
        $conexion->query("
            DELETE FROM sesiones_activas 
            WHERE fecha_inicio < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 24 HOUR)
            AND estado IN ('cerrada', 'expirada')
        ");
        
    } catch (Exception $e) {
        error_log("Error limpiando sesiones expiradas: " . $e->getMessage());
    }
}
?>