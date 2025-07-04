<?php
header('Content-Type: application/json; charset=utf-8');

try {
    // Incluir la conexión
    require_once '../conexion/conexion.php';

    // Verificar que la conexión existe
    if (!isset($GLOBALS['conexion'])) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        exit;
    }

    $mysqli = $GLOBALS['conexion'];
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }
    
    $usuario_id = $_POST['id'] ?? '';
    
    if (empty($usuario_id)) {
        echo json_encode(['success' => false, 'message' => 'ID de usuario requerido']);
        exit;
    }
    
    // Verificar que el usuario existe
    $stmt = $mysqli->prepare("SELECT CONCAT(nombres, ' ', apellidos) as nombre_completo FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    
    if (!$usuario) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }
    
    // Eliminar usuario
    $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $result = $stmt->execute();
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario: ' . $mysqli->error]);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

exit;
?>