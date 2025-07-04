<?php
session_start();

// Header JSON OBLIGATORIO (movido antes del require)
header('Content-Type: application/json; charset=utf-8');

try {
    // Incluir la conexión
    require_once '../conexion/conexion.php';

    if (!isset($GLOBALS['conexion'])) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        exit;
    }

    $pdo = $GLOBALS['conexion'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Obtener datos
    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $area = $_POST['area'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones básicas
    if (empty($nombres) || empty($apellidos) || empty($dni) || empty($email) || empty($area) || empty($cargo) || empty($usuario) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }

    if (!preg_match('/^[0-9]{8}$/', $dni)) {
        echo json_encode(['success' => false, 'message' => 'El DNI debe tener 8 dígitos']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email no válido']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
        exit;
    }

    // Verificar duplicados - CORREGIDO: usar fetch() en lugar de fetchColumn()
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE dni = ? OR email = ? OR usuario = ?");
    $stmt->execute([$dni, $email, $usuario]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Ya existe un usuario con ese DNI, email o nombre de usuario']);
        exit;
    }

    // Insertar usuario
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombres, apellidos, dni, telefono, email, direccion, area, cargo, usuario, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $nombres, $apellidos, $dni, $telefono, $email, 
        $direccion, $area, $cargo, $usuario, $hashedPassword
    ]);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'data' => [
                'usuario' => $usuario,
                'nombre_completo' => $nombres . ' ' . $apellidos
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar usuario']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

exit;
?>