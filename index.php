<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criminalística Puno - Sistema de Gestión Documentaria</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="titles-container">
                <h1 class="main-title">CRIMINALÍSTICA - PUNO</h1>
            </div>
            <p class="subtitle">SISTEMA DE GESTIÓN DOCUMENTARIA</p>
            <div class="logos-container">
                <div class="logo">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="logo">
                    <i class="fas fa-microscope"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="buttons-container">
            <button class="action-button admin-button" onclick="openAdminModal()">
                <i class="fas fa-user-shield"></i>
                <span>ADMINISTRADOR</span>
            </button>
            
            <button class="action-button areas-button" onclick="openAreasModal()">
                <i class="fas fa-building"></i>
                <span>INICIO ÁREAS</span>
            </button>
            
            <button class="action-button manual-button" onclick="openManual()">
                <i class="fas fa-book"></i>
                <span>MANUAL DE USO</span>
            </button>
        </div>
    </main>

    <!-- Modal de Administrador -->
    <div id="adminModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-user-shield"></i> Seleccione Área Administrativa</h2>
                <span class="close" onclick="closeModal('adminModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="areas-grid">
                    <div class="area-card" onclick="openLoginModal('jefatura')">
                        <i class="fas fa-crown"></i>
                        <h3>Jefatura</h3>
                        <p>Acceso para jefes y supervisores</p>
                    </div>
                    <div class="area-card" onclick="openLoginModal('mesa-partes')">
                        <i class="fas fa-inbox"></i>
                        <h3>Mesa de Partes</h3>
                        <p>Gestión de documentos y trámites</p>
                    </div>
                    <div class="area-card" onclick="openLoginModal('secretaria')">
                        <i class="fas fa-user-tie"></i>
                        <h3>Secretaría</h3>
                        <p>Administración y apoyo ejecutivo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal de Login para Jefatura -->
<div id="loginJefaturaModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-crown"></i> Acceso - Jefatura</h2>
            <span class="close" onclick="closeModal('loginJefaturaModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form class="login-form" method="POST" action="login/login_jefatura.php">
                <div class="form-group">
                    <label for="usernameJefatura">Usuario:</label>
                    <input type="text" id="usernameJefatura" name="usuario" required placeholder="Ingrese su usuario" value="<?php echo isset($_GET['usuario']) ? htmlspecialchars($_GET['usuario']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="passwordJefatura">Contraseña:</label>
                    <input type="password" id="passwordJefatura" name="password" required placeholder="Ingrese su contraseña">
                </div>
                <input type="hidden" name="area" value="jefatura">
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt"></i> INGRESAR A JEFATURA 
                </button>
                
                <?php
                // Mostrar mensajes de error específicos
                if (isset($_GET['error'])) {
                    echo '<div style="margin-top: 15px; padding: 12px; background: #ffebee; border: 1px solid #f44336; border-radius: 8px; color: #c62828; text-align: center; font-size: 14px;">';
                    switch ($_GET['error']) {
                        case 'invalid_credentials':
                            echo '<i class="fas fa-exclamation-circle"></i> Usuario o contraseña incorrectos';
                            break;
                        case 'user_inactive':
                            echo '<i class="fas fa-user-slash"></i> Su cuenta está inactiva. Contacte al administrador';
                            break;
                        case 'not_jefatura':
                            echo '<i class="fas fa-shield-alt"></i> Su usuario no tiene permisos para acceder a Jefatura';
                            break;
                        case 'user_not_found':
                            echo '<i class="fas fa-search"></i> Usuario no encontrado en el sistema';
                            break;
                        case 'db_connection':
                            echo '<i class="fas fa-database"></i> Error de conexión. Intente más tarde';
                            break;
                        case 'empty_fields':
                            echo '<i class="fas fa-edit"></i> Por favor complete todos los campos';
                            break;
                        default:
                            echo '<i class="fas fa-exclamation-triangle"></i> Error en el sistema. Contacte al administrador';
                    }
                    echo '</div>';
                }
                
                // Mostrar mensaje de éxito
                if (isset($_GET['success'])) {
                    echo '<div style="margin-top: 15px; padding: 12px; background: #e8f5e8; border: 1px solid #4caf50; border-radius: 8px; color: #2e7d32; text-align: center; font-size: 14px;">';
                    echo '<i class="fas fa-check-circle"></i> Acceso autorizado. Redirigiendo...';
                    echo '<script>setTimeout(function(){ window.location.href = "administracion/jefatura.php"; }, 2000);</script>';
                    echo '</div>';
                }
                
                // Mostrar mensaje de logout
                if (isset($_GET['logout'])) {
                    echo '<div style="margin-top: 15px; padding: 12px; background: #e3f2fd; border: 1px solid #2196f3; border-radius: 8px; color: #1565c0; text-align: center; font-size: 14px;">';
                    echo '<i class="fas fa-info-circle"></i> Sesión cerrada correctamente';
                    echo '</div>';
                }
                ?>
            </form>
        </div>
    </div>
</div>

    <!-- Modal de Login para Mesa de Partes -->
    <div id="loginMesaPartesModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-inbox"></i> Acceso - Mesa de Partes</h2>
                <span class="close" onclick="closeModal('loginMesaPartesModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form class="login-form" onsubmit="loginAdmin(event, 'mesa-partes')">
                    <div class="form-group">
                        <label for="usernameMesaPartes">Usuario:</label>
                        <input type="text" id="usernameMesaPartes" name="username" required placeholder="Ingrese su usuario">
                    </div>
                    <div class="form-group">
                        <label for="passwordMesaPartes">Contraseña:</label>
                        <input type="password" id="passwordMesaPartes" name="password" required placeholder="Ingrese su contraseña">
                    </div>
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt"></i> INGRESAR A MESA DE PARTES
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Login para Secretaría -->
    <div id="loginSecretariaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-user-tie"></i> Acceso - Secretaría</h2>
                <span class="close" onclick="closeModal('loginSecretariaModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form class="login-form" onsubmit="loginAdmin(event, 'secretaria')">
                    <div class="form-group">
                        <label for="usernameSecretaria">Usuario:</label>
                        <input type="text" id="usernameSecretaria" name="username" required placeholder="Ingrese su usuario">
                    </div>
                    <div class="form-group">
                        <label for="passwordSecretaria">Contraseña:</label>
                        <input type="password" id="passwordSecretaria" name="password" required placeholder="Ingrese su contraseña">
                    </div>
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt"></i> INGRESAR A SECRETARÍA
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Áreas -->
    <div id="areasModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-building"></i> Seleccione un Área</h2>
                <span class="close" onclick="closeModal('areasModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="areas-grid">
                    <div class="area-card" onclick="accessArea('inspeccion')">
                        <i class="fas fa-search"></i>
                        <h3>Inspección Criminalística</h3>
                        <p>Análisis de la escena del crimen</p>
                    </div>
                    <div class="area-card" onclick="accessArea('identificacion')">
                        <i class="fas fa-fingerprint"></i>
                        <h3>Identificación Forense</h3>
                        <p>Identificación de personas y evidencias</p>
                    </div>
                    <div class="area-card" onclick="accessArea('balistica')">
                        <i class="fas fa-crosshairs"></i>
                        <h3>Balística Forense</h3>
                        <p>Análisis de armas de fuego y proyectiles</p>
                    </div>
                    <div class="area-card" onclick="accessArea('grafotecnia')">
                        <i class="fas fa-pen-fancy"></i>
                        <h3>Grafotecnia Forense</h3>
                        <p>Análisis de escritura y documentos</p>
                    </div>
                    <div class="area-card" onclick="accessArea('antropologia')">
                        <i class="fas fa-skull"></i>
                        <h3>Antropología Forense</h3>
                        <p>Análisis de restos humanos</p>
                    </div>
                    <div class="area-card" onclick="accessArea('cerap')">
                        <i class="fas fa-database"></i>
                        <h3>CERAP</h3>
                        <p>Centro de Registro de Antecedentes Policiales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <h3>División de Criminalística Puno</h3>
            <p><i class="fas fa-map-marker-alt"></i> Puno, Perú</p>
            <p><i class="fas fa-phone"></i> Central: (051) 123-4567</p>
            <p><i class="fas fa-envelope"></i> criminalistica.puno@policia.gob.pe</p>
            <p>&copy; 2025 - Todos los derechos reservados</p>
            
            <div class="social-links">
                <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
<script src="js/script.js"></script>
</body>
</html>