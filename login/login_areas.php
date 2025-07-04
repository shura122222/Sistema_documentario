<?php
/**
 * PÁGINA PRINCIPAL DE LOGIN - CRIMINALÍSTICA PUNO
 * Sistema de autenticación institucional
 * ✅ CORREGIDO: Login directo sin selección de área previa
 */

///Iniciar sesión
session_start();

// Limpiar sesión si se solicita logout
if (isset($_GET['logout']) || isset($_GET['force_login'])) {
    session_destroy();
    session_start();
}

// Verificar si ya está autenticado
if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true) {
    if (isset($_SESSION['timeout']) && time() <= $_SESSION['timeout']) {
        // Sesión válida
        $areaUsuario = $_SESSION['user_area'] ?? '';

        // Definir URLs por área
        $urls = [
            'cerap' => '../areas/cerap.php',
            'balistica' => '../areas/balistica.php',
            'antropologia' => '../areas/antropologia.php',
            'identificacion' => '../areas/identificacion.php',
            'grafotecnia' => '../areas/grafotecnia.php',
            'inspeccion' => '../areas/inspeccion.php'
        ];

        // Redirigir si el área existe en el mapa
        if (array_key_exists($areaUsuario, $urls)) {
            header("Location: " . $urls[$areaUsuario]);
            exit;
        } else {
            // Área no válida: opcionalmente, forzar logout o mostrar mensaje
            session_destroy();
            header("Location: login.php?error=access_denied&message=" . urlencode("Área no válida o sin permisos."));
            exit;
        }
    } else {
        // Sesión expirada
        session_destroy();
        session_start();
        $sessionExpired = true;
    }
}

// Verificar mensajes de error o estado
$sessionExpired = isset($_GET['expired']) && $_GET['expired'] == '1';
$accessDenied = isset($_GET['error']) && $_GET['error'] == 'access_denied';
$loginMessage = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Configurar zona horaria
date_default_timezone_set('America/Lima');

// Generar token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Documentario - Criminalística Puno</title>
    <meta name="description" content="Sistema de autenticación para el personal de Criminalística Puno - PNP">
    <meta name="keywords" content="PNP, Criminalística, Puno, Sistema Documentario, Autenticación">
    <meta name="author" content="Criminalística Puno - PNP">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/login_areas.css">
</head>
<body>
    <!-- Fondo animado -->
    <div class="animated-background">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Header institucional -->
    <header class="institutional-header">
        <div class="header-content">
            <div class="logo-left">
            <img src="./111.png" alt="Logo Criminalística Puno" class="header-logo">
            </div>
            <div class="header-text">
                <h1>POLICÍA NACIONAL DEL PERÚ</h1>
                <h2>CRIMINALÍSTICA PUNO</h2>
                <p>TRÁMITE DOCUMENTARIO Y MUESTRAS</p>
            </div>
            <div class="logo-right">
                <img src="./111.png" alt="Logo PNP" class="header-logo">
            </div>
        </div>
    </header>

    <!-- Contenedor principal -->
    <main class="main-container">
        <div class="login-panel" id="loginPanel">
            <div class="panel-header">
                <div class="panel-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                    </svg>
                </div>
                <h3>ACCESO AL SISTEMA</h3>
                <p>Ingrese sus credenciales institucionales</p>
                
                <?php if ($sessionExpired): ?>
                <div class="session-expired-warning">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"/>
                    </svg>
                    Su sesión ha expirado. Por favor, inicie sesión nuevamente.
                </div>
                <?php endif; ?>
                
                <?php if ($accessDenied): ?>
                <div class="access-denied-warning">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,7A2,2 0 0,1 14,9A2,2 0 0,1 12,11A2,2 0 0,1 10,9A2,2 0 0,1 12,7M12,17A2,2 0 0,1 10,15A2,2 0 0,1 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17Z"/>
                    </svg>
                    Acceso denegado. No tiene permisos para acceder a esa área.
                </div>
                <?php endif; ?>
                
                <?php if ($loginMessage): ?>
                <div class="info-message">
                    <?php echo $loginMessage; ?>
                </div>
                <?php endif; ?>
            </div>

            <form class="login-form" id="loginForm" method="POST">
                <!-- Token CSRF -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <!-- Campo de email -->
                <div class="input-container">
                    <div class="floating-input">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               autocomplete="email" 
                               maxlength="100"
                               placeholder=" ">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Campo de contraseña -->
                <div class="input-container">
                    <div class="floating-input">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password" 
                               maxlength="100"
                               placeholder=" ">
                        <label for="password">Contraseña</label>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"/>
                            </svg>
                        </div>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar/Ocultar contraseña">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                <path d="M11.83,9L15,12.16C15,12.11 15,12.05 15,12A3,3 0 0,0 12,9C11.94,9 11.89,9 11.83,9M7.53,9.8L9.08,11.35C9.03,11.56 9,11.77 9,12A3,3 0 0,0 12,15C12.22,15 12.44,14.97 12.65,14.92L14.2,16.47C13.53,16.8 12.79,17 12,17A5,5 0 0,1 7,12C7,11.21 7.2,10.47 7.53,9.8M2,4.27L4.28,6.55L4.73,7C3.08,8.3 1.78,10 1,12C2.73,16.39 7,19.5 12,19.5C13.55,19.5 15.03,19.2 16.38,18.66L16.81,19.09L19.73,22L21,20.73L3.27,3M12,7A5,5 0 0,1 17,12C17,12.64 16.87,13.26 16.64,13.82L19.57,16.75C21.07,15.5 22.27,13.86 23,12C21.27,7.61 17,4.5 12,4.5C10.6,4.5 9.26,4.75 8,5.2L10.17,7.35C10.76,7.13 11.37,7 12,7Z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Alerta de Caps Lock -->
                <div class="caps-warning" id="capsWarning">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"/>
                    </svg>
                    Bloq Mayús está activado
                </div>

                <!-- Botón de login -->
                <button type="submit" class="login-button" id="loginButton">
                    <span class="button-content">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10,17V14H3V10H10V7L15,12L10,17M10,2H19A2,2 0 0,1 21,4V20A2,2 0 0,1 19,22H10A2,2 0 0,1 8,20V18H10V20H19V4H10V6H8V4A2,2 0 0,1 10,2Z"/>
                        </svg>
                        <span class="button-text">INGRESAR AL SISTEMA</span>
                    </span>
                    <div class="loading-spinner">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"/>
                        </svg>
                    </div>
                </button>

                <!-- Enlaces adicionales -->
                <div class="form-links">
                    <a href="#" id="forgotPassword">¿Olvidó su contraseña?</a>
                    <a href="#" id="helpLink">Ayuda</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> Policía Nacional del Perú - Criminalística Puno</p>
        </div>
    </footer>

    <!-- Contenedor de notificaciones -->
    <div class="notification-container" id="notifications" role="alert" aria-live="polite"></div>

    <!-- JavaScript -->
    <script src="../js/login_area.js"></script>
    
    <!-- Variables de configuración para JavaScript -->
    <script>
        window.loginConfig = {
            sessionExpired: <?php echo $sessionExpired ? 'true' : 'false'; ?>,
            accessDenied: <?php echo $accessDenied ? 'true' : 'false'; ?>,
            csrfToken: '<?php echo $_SESSION['csrf_token']; ?>',
            serverTime: '<?php echo date('Y-m-d H:i:s'); ?>',
            timezone: 'America/Lima'
        };
    </script>
</body>
</html>