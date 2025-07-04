<?php
/**
 * VALIDACIÓN DE CREDENCIALES - CRIMINALÍSTICA PUNO
 * ✅ ADAPTADO A TU ESTRUCTURA REAL DE BASE DE DATOS
 */

// Headers JSON PRIMERO
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

// Función para enviar respuesta JSON limpia
function sendJsonResponse($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Debug solo en desarrollo (sin interferir con JSON)
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    ini_set('display_errors', 0); // OFF para no interferir con JSON
    ini_set('log_errors', 1);
    error_reporting(E_ALL);
}

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(['success' => false, 'message' => 'Método no permitido']);
}

try {
    // Iniciar sesión
    session_start();
    
    // Incluir conexión
    require_once '../conexion/conexion.php';
    
    // Verificar conexión
    if (!isset($conexion)) {
        error_log("ERROR: Variable \$conexion no existe");
        sendJsonResponse([
            'success' => false,
            'message' => 'Error de configuración del servidor'
        ]);
    }

    // Obtener datos del formulario
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Log de intento
    error_log("LOGIN ATTEMPT: " . $email);

    // Validaciones básicas
    if (empty($email) || empty($password)) {
        sendJsonResponse([
            'success' => false,
            'message' => 'Email y contraseña son obligatorios'
        ]);
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendJsonResponse([
            'success' => false,
            'message' => 'Formato de email inválido'
        ]);
    }

    // ✅ CONSULTA ADAPTADA A TU ESTRUCTURA
    $stmt = $conexion->prepare("
        SELECT 
            id, 
            email, 
            password, 
            nombres, 
            apellidos, 
            area, 
            cargo, 
            estado,
            usuario
        FROM usuarios 
        WHERE email = ?
    ");
    
    if (!$stmt) {
        error_log("ERROR SQL: " . $conexion->error);
        sendJsonResponse([
            'success' => false,
            'message' => 'Error en la consulta de base de datos'
        ]);
    }

    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        error_log("ERROR EJECUCIÓN: " . $stmt->error);
        sendJsonResponse([
            'success' => false,
            'message' => 'Error al ejecutar la consulta'
        ]);
    }

    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Debug log
    if ($usuario) {
        error_log("USER FOUND: ID=" . $usuario['id'] . ", Area=" . $usuario['area'] . ", Estado=" . $usuario['estado']);
    } else {
        error_log("USER NOT FOUND: " . $email);
    }

    // Verificar si existe el usuario
    if (!$usuario) {
        sendJsonResponse([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
    }

    // ✅ VERIFICAR ESTADO (tu tabla usa 'activo'/'inactivo')
    if ($usuario['estado'] !== 'activo') {
        sendJsonResponse([
            'success' => false,
            'message' => 'Cuenta inactiva. Contacte al administrador.'
        ]);
    }

    // Verificar contraseña
    $password_valid = false;
    
    // Intentar con hash primero
    if (password_verify($password, $usuario['password'])) {
        $password_valid = true;
        error_log("LOGIN: Password verified with hash");
    } 
    // Si falla, intentar comparación directa
    elseif ($password === $usuario['password']) {
        $password_valid = true;
        error_log("LOGIN: Password verified with plain text");
        
        // Actualizar a hash por seguridad
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("si", $hashed_password, $usuario['id']);
            $update_stmt->execute();
            error_log("Password updated to hash for user: " . $usuario['id']);
        }
    }

    if (!$password_valid) {
        error_log("LOGIN FAILED: Invalid password for " . $email);
        sendJsonResponse([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
    }

    // 🔒 SEGREGACIÓN COMPLETA POR ÁREA - CADA ÁREA SOLO PARA SUS USUARIOS
    // Obtener área solicitada desde el referer o parámetro
    $area_solicitada = null;
    
    // Detectar área desde la URL de referencia
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        if (strpos($referer, '/cerap/') !== false || strpos($referer, 'cerap') !== false) {
            $area_solicitada = 'cerap';
        } elseif (strpos($referer, '/antropologia/') !== false || strpos($referer, 'antropologia') !== false) {
            $area_solicitada = 'antropologia';
        } elseif (strpos($referer, '/balistica/') !== false || strpos($referer, 'balistica') !== false) {
            $area_solicitada = 'balistica';
        } elseif (strpos($referer, '/grafotecnia/') !== false || strpos($referer, 'grafotecnia') !== false) {
            $area_solicitada = 'grafotecnia';
        } elseif (strpos($referer, '/identificacion/') !== false || strpos($referer, 'identificacion') !== false) {
            $area_solicitada = 'identificacion';
        } elseif (strpos($referer, '/inspeccion/') !== false || strpos($referer, 'inspeccion') !== false) {
            $area_solicitada = 'inspeccion';
        }
    }
    
    // También permitir área específica por parámetro POST
    if (isset($_POST['area_solicitada'])) {
        $area_solicitada = strtolower(trim($_POST['area_solicitada']));
    }
    
    // 🚨 VALIDACIÓN ESTRICTA: SOLO USUARIOS DEL ÁREA PUEDEN ACCEDER
    if ($area_solicitada) {
        $usuario_area = strtolower(trim($usuario['area']));
        
        if ($usuario_area !== $area_solicitada) {
            error_log("ACCESS DENIED: Usuario área '$usuario_area' intentando acceder a '$area_solicitada'");
            
            // Mensaje específico según el área solicitada
            $areas_nombres = [
                'cerap' => 'CERAP',
                'antropologia' => 'Antropología Forense',
                'balistica' => 'Balística Forense',
                'grafotecnia' => 'Grafotecnia',
                'identificacion' => 'Identificación',
                'inspeccion' => 'Inspección Técnico Policial'
            ];
            
            $nombre_area_usuario = $areas_nombres[$usuario_area] ?? ucfirst($usuario_area);
            $nombre_area_solicitada = $areas_nombres[$area_solicitada] ?? ucfirst($area_solicitada);
            
            sendJsonResponse([
                'success' => false,
                'message' => "⚠️ ACCESO DENEGADO: Este usuario pertenece al área de $nombre_area_usuario, no puede acceder al área de $nombre_area_solicitada. Solo usuarios del área de $nombre_area_solicitada pueden ingresar."
            ]);
        }
        
        // Log de acceso autorizado
        error_log("ACCESS GRANTED: Usuario área '$usuario_area' accediendo correctamente a '$area_solicitada'");
    }

    // ✅ CONSTRUIR NOMBRE COMPLETO desde nombres + apellidos
    $nombre_completo = trim(($usuario['nombres'] ?? '') . ' ' . ($usuario['apellidos'] ?? ''));
    if (empty($nombre_completo)) {
        $nombre_completo = $usuario['usuario'] ?? explode('@', $usuario['email'])[0];
    }

    // Guardar información en la sesión
    $_SESSION['user_id'] = $usuario['id'];
    $_SESSION['user_email'] = $usuario['email'];
    $_SESSION['user_name'] = $nombre_completo;
    $_SESSION['user_area'] = $usuario['area'];
    $_SESSION['user_cargo'] = $usuario['cargo'] ?? 'Sin cargo';
    $_SESSION['user_usuario'] = $usuario['usuario'] ?? '';
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();

    // ✅ RUTAS SOLO PARA ÁREAS PRINCIPALES
    $area = strtolower(trim($usuario['area']));
    
    $urls = [
        'antropologia' => '../areas/antropologia.php',
        'balistica' => '../areas/balistica.php',
        'cerap' => '../areas/cerap.php',
        'grafotecnia' => '../areas/grafotecnia.php',
        'identificacion' => '../areas/identificacion.php',
        'inspeccion' => '../areas/inspeccion.php'
    ];

    $redirectUrl = $urls[$area] ?? '../areas/dashboard.php';
    
    // ✅ CONTROL DE ACCESO: Solo permitir áreas válidas
    if (!isset($urls[$area])) {
        error_log("WARNING: Área no válida para login: '$area'. Usuario: {$usuario['email']}");
        sendJsonResponse([
            'success' => false,
            'message' => 'Su área no tiene acceso al sistema. Contacte al administrador.'
        ]);
    }
    
    // ✅ DEBUG: Log detallado de la redirección
    error_log("REDIRECT DEBUG: Area BD='{$usuario['area']}' | Area procesada='$area' | URL='$redirectUrl'");
    error_log("REDIRECT DEBUG: Áreas válidas: " . implode(', ', array_keys($urls)));
    
    // ✅ VERIFICAR SI EL ARCHIVO EXISTE
    $file_path = $redirectUrl;
    if (strpos($file_path, '../') === 0) {
        $file_path = dirname(__DIR__) . '/' . substr($file_path, 3);
    }
    
    if (!file_exists($file_path)) {
        error_log("ERROR: Archivo no existe: $file_path");
        sendJsonResponse([
            'success' => false,
            'message' => 'Error: Página del área no encontrada. Contacte al administrador.'
        ]);
    }

    // Log exitoso
    error_log("LOGIN SUCCESS: User {$usuario['id']} ({$usuario['email']}) - Area: {$usuario['area']} - Redirect: $redirectUrl");

    // Cerrar statement
    $stmt->close();

    // ✅ RESPUESTA EXITOSA CON DATOS CORRECTOS
    sendJsonResponse([
        'success' => true,
        'message' => 'Acceso autorizado',
        'redirect' => $redirectUrl,
        'user' => [
            'id' => $usuario['id'],
            'name' => $nombre_completo,
            'email' => $usuario['email'],
            'area' => $usuario['area'],
            'cargo' => $usuario['cargo'] ?? 'Sin cargo',
            'usuario' => $usuario['usuario'] ?? ''
        ]
    ]);

} catch (mysqli_sql_exception $e) {
    error_log("SQL EXCEPTION: " . $e->getMessage());
    sendJsonResponse([
        'success' => false,
        'message' => 'Error de base de datos'
    ]);
} catch (Exception $e) {
    error_log("GENERAL EXCEPTION: " . $e->getMessage());
    sendJsonResponse([
        'success' => false,
        'message' => 'Error interno del servidor'
    ]);
} finally {
    // Cerrar conexión si existe
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>