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
    
    // Obtener todos los usuarios
    $sql = "SELECT id, nombres, apellidos, CONCAT(nombres, ' ', apellidos) as nombre_completo, 
                   usuario, area, cargo, estado, dni, email, telefono, fecha_registro 
            FROM usuarios 
            ORDER BY fecha_registro DESC";
    
    $result = $mysqli->query($sql);
    
    if ($result) {
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        
        echo json_encode([
            'success' => true,
            'usuarios' => $usuarios,
            'total' => count($usuarios)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error en la consulta: ' . $mysqli->error
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

exit;
?>