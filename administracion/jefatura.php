<?php
session_start();

// Verificar sesión de jefatura
if (!isset($_SESSION['user_id']) || $_SESSION['area'] !== 'jefatura') {
    header('Location: ../index.html?error=no_session');
    exit;
}

// Obtener datos del usuario
$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre_completo'];
$cargo = $_SESSION['cargo'];
$loginTime = date('d/m/Y H:i:s', $_SESSION['login_time']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefatura - Sistema Criminalística Puno</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css\jefatura.css">
</head>
<body>
    <div class="container">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="logo-text">
                    Jefatura<br>
                    Criminalística Puno
                </div>
            </div>
            
            <div class="user-section">
                <div class="user-name"><?php echo htmlspecialchars($nombre); ?></div>
                <div class="user-role"><?php echo htmlspecialchars($cargo); ?></div>
                <div style="font-size: 0.8rem; opacity: 0.7; margin-top: 5px;">
                    <i class="fas fa-clock"></i> <?php echo $loginTime; ?>
                </div>
            </div>
            
            <div class="menu">
                <button class="menu-item active" onclick="showSection('dashboard', this)">
                    <i class="fas fa-tachometer-alt"></i> Panel Principal
                </button>
                <button class="menu-item" onclick="showSection('personal', this)">
                    <i class="fas fa-users"></i> Gestión de Personal
                </button>
                <button class="menu-item" onclick="showSection('documentos', this)">
                    <i class="fas fa-file-alt"></i> Documentos por Área
                </button>
                <button class="menu-item" onclick="showSection('reportes', this)">
                    <i class="fas fa-chart-line"></i> Reportes Ejecutivos
                </button>
                <button class="menu-item" onclick="showSection('supervision', this)">
                    <i class="fas fa-eye"></i> Supervisión General
                </button>
                <button class="menu-item" onclick="showSection('estadisticas', this)">
                    <i class="fas fa-chart-bar"></i> Estadísticas por Área
                </button>
                <button class="menu-item" onclick="showSection('calidad', this)">
                    <i class="fas fa-award"></i> Control de Calidad
                </button>
                <button class="menu-item" onclick="showSection('planificacion', this)">
                    <i class="fas fa-chess-board"></i> Planificación Estratégica
                </button>
                <button class="menu-item" onclick="showSection('coordinacion', this)">
                    <i class="fas fa-handshake"></i> Coordinación Inter.
                </button>
                <button class="menu-item" onclick="showSection('configuracion', this)">
                    <i class="fas fa-cog"></i> Configuración
                </button>
            </div>
            
            <button class="logout-btn" onclick="window.location.href='../index.php'">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </button>
            
        </div>
        
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="header">
                <div class="header-top">
                    <h1 class="page-title" id="pageTitle">Panel Principal - Jefatura</h1>
                    <div class="header-actions">
                        <button class="notification-btn" onclick="showNotifications()">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <button class="settings-btn" onclick="showSettings()">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
                <div class="breadcrumb">
                    <a href="#">Inicio</a> / <span id="breadcrumbText">Panel Principal</span>
                </div>
            </div>
            
            <div class="content-area">
                <!-- ESTADÍSTICAS PRINCIPALES -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-number">24</div>
                        <div class="stat-label">Personal Activo</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">156</div>
                        <div class="stat-label">Casos Este Mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">89%</div>
                        <div class="stat-label">Eficiencia General</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Reportes Pendientes</div>
                    </div>
                </div>
                
                <!-- SECCIÓN PRINCIPAL -->
                <div id="dashboardSection" class="section active">
                    <div class="dashboard-grid">
                        <div class="card" onclick="showSection('personal', document.querySelector('[onclick*=personal]'))">
                            <div class="card-header">
                                <div class="card-icon personal">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div class="card-title">Gestión de Personal</div>
                            </div>
                            <div class="card-description">
                                Administración y supervisión del personal de todas las áreas criminalísticas. Control de asistencia, evaluaciones y asignaciones.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Acceder
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('documentos', document.querySelector('[onclick*=documentos]'))">
                            <div class="card-header">
                                <div class="card-icon documentos">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <div class="card-title">Ver Documentos por Área</div>
                            </div>
                            <div class="card-description">
                                Revisión y supervisión de documentos generados por cada área especializada. Informes, peritajes y reportes técnicos.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Revisar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('reportes', document.querySelector('[onclick*=reportes]'))">
                            <div class="card-header">
                                <div class="card-icon reportes">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="card-title">Reportes Ejecutivos</div>
                            </div>
                            <div class="card-description">
                                Estadísticas y métricas institucionales. Análisis de rendimiento, productividad y resultados por área.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Generar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('supervision', document.querySelector('[onclick*=supervision]'))">
                            <div class="card-header">
                                <div class="card-icon supervision">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="card-title">Supervisión General</div>
                            </div>
                            <div class="card-description">
                                Monitoreo en tiempo real de todas las actividades operativas. Control de casos activos y seguimiento de procesos.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Supervisar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('estadisticas', document.querySelector('[onclick*=estadisticas]'))">
                            <div class="card-header">
                                <div class="card-icon documentos">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="card-title">Estadísticas por Área</div>
                            </div>
                            <div class="card-description">
                                Análisis detallado del rendimiento por área especializada. Balística, Grafotecnia, Identificación, etc.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Analizar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('calidad', document.querySelector('[onclick*=calidad]'))">
                            <div class="card-header">
                                <div class="card-icon calidad">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="card-title">Control de Calidad</div>
                            </div>
                            <div class="card-description">
                                Supervisión de procedimientos y estándares de calidad. Auditorías internas y mejora continua.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Auditar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('planificacion', document.querySelector('[onclick*=planificacion]'))">
                            <div class="card-header">
                                <div class="card-icon supervision">
                                    <i class="fas fa-chess-board"></i>
                                </div>
                                <div class="card-title">Planificación Estratégica</div>
                            </div>
                            <div class="card-description">
                                Desarrollo de planes y estrategias institucionales. Objetivos, metas y proyectos a corto y largo plazo.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Planificar
                            </button>
                        </div>
                        
                        <div class="card" onclick="showSection('coordinacion', document.querySelector('[onclick*=coordinacion]'))">
                            <div class="card-header">
                                <div class="card-icon coordinacion">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div class="card-title">Coordinación Interinstitucional</div>
                            </div>
                            <div class="card-description">
                                Gestión de relaciones con otras entidades. Ministerio Público, Poder Judicial, otras instituciones.
                            </div>
                            <button class="card-action">
                                <i class="fas fa-arrow-right"></i> Coordinar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN GESTIÓN DE PERSONAL -->
                <div id="personalSection" class="section">
                    <div class="grid-2">
                        <div class="card">
                            <h3><i class="fas fa-user-plus"></i> Registrar Nuevo Usuario</h3>
                            <p>Crear nuevas cuentas para el personal de diferentes áreas</p>
                            <button class="btn btn-primary" onclick="showNewUserModal()">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-users"></i> Gestionar Personal</h3>
                            <p>Ver, editar y administrar cuentas existentes</p>
                            <button class="btn btn-primary" onclick="showUsersList()">
                                <i class="fas fa-list"></i> Ver Personal
                            </button>
                        </div>
                    </div>
                    
                    <div id="usersList" style="margin-top: 30px;">
                        <h3>Personal Registrado</h3>
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Área</th>
                                    <th>Cargo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Carlos Mendoza</td>
                                    <td>cmendoza</td>
                                    <td>Balística</td>
                                    <td>Perito Principal</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-secondary" onclick="editUser('cmendoza')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="toggleUserStatus('cmendoza')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ana García</td>
                                    <td>agarcia</td>
                                    <td>Grafotecnia</td>
                                    <td>Perito Especialista</td>
                                    <td><span class="status-badge status-active">Activo</span></td>
                                    <td>
                                        <button class="btn btn-secondary" onclick="editUser('agarcia')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="toggleUserStatus('agarcia')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Luis Rodríguez</td>
                                    <td>lrodriguez</td>
                                    <td>Identificación</td>
                                    <td>Técnico</td>
                                    <td><span class="status-badge status-inactive">Inactivo</span></td>
                                    <td>
                                        <button class="btn btn-secondary" onclick="editUser('lrodriguez')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-primary" onclick="toggleUserStatus('lrodriguez')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN DOCUMENTOS POR ÁREA -->
                <div id="documentosSection" class="section">
                    <div class="grid-3">
                        <div class="card">
                            <h3><i class="fas fa-crosshairs"></i> Balística Forense</h3>
                            <p>Informes de análisis balístico</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('balistica')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-pen-nib"></i> Grafotecnia</h3>
                            <p>Análisis de documentos y escrituras</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('grafotecnia')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-fingerprint"></i> Identificación</h3>
                            <p>Análisis dactiloscópicos</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('identificacion')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-microscope"></i> Biología Forense</h3>
                            <p>Análisis de muestras biológicas</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('biologia')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-flask"></i> Química Forense</h3>
                            <p>Análisis químicos y toxicológicos</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('quimica')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-camera"></i> Fotografía Forense</h3>
                            <p>Documentación fotográfica</p>
                            <button class="btn btn-primary" onclick="showAreaDocuments('fotografia')">
                                <i class="fas fa-folder-open"></i> Ver Documentos
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN REPORTES EJECUTIVOS -->
                <div id="reportesSection" class="section">
                    <div class="grid-2">
                        <div class="card">
                            <h3><i class="fas fa-chart-bar"></i> Reportes Mensuales</h3>
                            <p>Estadísticas y métricas del mes actual</p>
                            <button class="btn btn-primary" onclick="generateReport('monthly')">
                                <i class="fas fa-file-pdf"></i> Generar Reporte
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-chart-line"></i> Análisis de Tendencias</h3>
                            <p>Evolución de indicadores por área</p>
                            <button class="btn btn-primary" onclick="generateReport('trends')">
                                <i class="fas fa-chart-line"></i> Ver Tendencias
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-clock"></i> Productividad</h3>
                            <p>Análisis de tiempos y eficiencia</p>
                            <button class="btn btn-primary" onclick="generateReport('productivity')">
                                <i class="fas fa-stopwatch"></i> Analizar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-star"></i> Evaluación de Calidad</h3>
                            <p>Indicadores de calidad por área</p>
                            <button class="btn btn-primary" onclick="generateReport('quality')">
                                <i class="fas fa-award"></i> Evaluar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN SUPERVISIÓN GENERAL -->
                <div id="supervisionSection" class="section">
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="stat-number">15</div>
                            <div class="stat-label">Casos Activos</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">8</div>
                            <div class="stat-label">Urgentes</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">92%</div>
                            <div class="stat-label">Cumplimiento</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Retrasados</div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <h3><i class="fas fa-tasks"></i> Monitor de Casos en Tiempo Real</h3>
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Caso</th>
                                    <th>Área</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>C-2024-001</td>
                                    <td>Balística</td>
                                    <td>Carlos Mendoza</td>
                                    <td><span class="status-badge status-active">En Proceso</span></td>
                                    <td>Alta</td>
                                    <td>15/06/2025</td>
                                </tr>
                                <tr>
                                    <td>C-2024-002</td>
                                    <td>Grafotecnia</td>
                                    <td>Ana García</td>
                                    <td><span class="status-badge status-active">Iniciado</span></td>
                                    <td>Media</td>
                                    <td>20/06/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN ESTADÍSTICAS POR ÁREA -->
                <div id="estadisticasSection" class="section">
                    <div class="grid-2">
                        <div class="card">
                            <h3><i class="fas fa-chart-pie"></i> Distribución de Casos</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 3rem; color: #0f4c3a;">📊</div>
                                <p>Gráfico de distribución por área</p>
                            </div>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-trending-up"></i> Rendimiento Mensual</h3>
                            <div style="text-align: center; padding: 20px;">
                                <div style="font-size: 3rem; color: #10b981;">📈</div>
                                <p>Evolución del rendimiento</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN CONTROL DE CALIDAD -->
                <div id="calidadSection" class="section">
                    <div class="grid-3">
                        <div class="card">
                            <h3><i class="fas fa-clipboard-check"></i> Auditorías</h3>
                            <p>Programar y revisar auditorías</p>
                            <button class="btn btn-primary" onclick="manageAudits()">
                                <i class="fas fa-calendar"></i> Gestionar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-certificate"></i> Certificaciones</h3>
                            <p>Control de certificaciones del personal</p>
                            <button class="btn btn-primary" onclick="manageCertifications()">
                                <i class="fas fa-award"></i> Ver Estado
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-file-medical"></i> Procedimientos</h3>
                            <p>Revisión de protocolos y procedimientos</p>
                            <button class="btn btn-primary" onclick="manageProcedures()">
                                <i class="fas fa-book"></i> Revisar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN PLANIFICACIÓN ESTRATÉGICA -->
                <div id="planificacionSection" class="section">
                    <div class="grid-2">
                        <div class="card">
                            <h3><i class="fas fa-bullseye"></i> Objetivos Institucionales</h3>
                            <p>Definir y seguir objetivos estratégicos</p>
                            <button class="btn btn-primary" onclick="manageObjectives()">
                                <i class="fas fa-target"></i> Gestionar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-project-diagram"></i> Proyectos</h3>
                            <p>Administrar proyectos y iniciativas</p>
                            <button class="btn btn-primary" onclick="manageProjects()">
                                <i class="fas fa-tasks"></i> Ver Proyectos
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN COORDINACIÓN INTERINSTITUCIONAL -->
                <div id="coordinacionSection" class="section">
                    <div class="grid-3">
                        <div class="card">
                            <h3><i class="fas fa-balance-scale"></i> Ministerio Público</h3>
                            <p>Coordinación con fiscalías</p>
                            <button class="btn btn-primary" onclick="manageCoordination('mp')">
                                <i class="fas fa-handshake"></i> Gestionar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-university"></i> Poder Judicial</h3>
                            <p>Colaboración con juzgados</p>
                            <button class="btn btn-primary" onclick="manageCoordination('pj')">
                                <i class="fas fa-gavel"></i> Coordinar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-shield-alt"></i> PNP</h3>
                            <p>Trabajo conjunto con comisarías</p>
                            <button class="btn btn-primary" onclick="manageCoordination('pnp')">
                                <i class="fas fa-users"></i> Colaborar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN CONFIGURACIÓN -->
                <div id="configuracionSection" class="section">
                    <div class="grid-2">
                        <div class="card">
                            <h3><i class="fas fa-cogs"></i> Configuración General</h3>
                            <p>Ajustes del sistema y parámetros</p>
                            <button class="btn btn-primary" onclick="showSystemConfig()">
                                <i class="fas fa-wrench"></i> Configurar
                            </button>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-database"></i> Respaldos</h3>
                            <p>Gestionar copias de seguridad</p>
                            <button class="btn btn-primary" onclick="manageBackups()">
                                <i class="fas fa-save"></i> Gestionar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL DE NOTIFICACIONES -->
    <div id="notificationsModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal('notificationsModal')">&times;</button>
            <h2><i class="fas fa-bell"></i> Notificaciones Recientes</h2>
            <div style="margin-top: 20px;">
                <div style="padding: 15px; border-left: 4px solid #10b981; background: #f0f9ff; margin-bottom: 10px; border-radius: 5px;">
                    <strong>Nuevo informe de balística</strong><br>
                    <small>Hace 2 horas - Área de Balística Forense</small>
                </div>
                <div style="padding: 15px; border-left: 4px solid #f59e0b; background: #fffbeb; margin-bottom: 10px; border-radius: 5px;">
                    <strong>Reunión programada</strong><br>
                    <small>Hoy 14:00 - Sala de Juntas</small>
                </div>
                <div style="padding: 15px; border-left: 4px solid #ef4444; background: #fef2f2; border-radius: 5px;">
                    <strong>Documento requiere revisión</strong><br>
                    <small>Ayer - Grafotecnia Forense</small>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL NUEVO USUARIO -->
    <div id="newUserModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal('newUserModal')">&times;</button>
            <h2><i class="fas fa-user-plus"></i> Registrar Nuevo Usuario</h2>
            <form id="newUserForm" onsubmit="createNewUser(event)">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-input" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input type="text" class="form-input" name="apellidos" required>
                    </div>
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">DNI</label>
                        <input type="text" class="form-input" name="dni" maxlength="8" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-input" name="telefono">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" required>
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Área</label>
                        <select class="form-select" name="area" required>
                            <option value="">Seleccionar área</option>
                            <option value="balistica">Balística Forense</option>
                            <option value="grafotecnia">Grafotecnia</option>
                            <option value="identificacion">Identificación</option>
                            <option value="biologia">Biología Forense</option>
                            <option value="quimica">Química Forense</option>
                            <option value="fotografia">Fotografía Forense</option>
                            <option value="informatica">Informática Forense</option>
                            <option value="acustica">Acústica Forense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cargo</label>
                        <select class="form-select" name="cargo" required>
                            <option value="">Seleccionar cargo</option>
                            <option value="jefe">Jefe de Área</option>
                            <option value="perito_principal">Perito Principal</option>
                            <option value="perito_especialista">Perito Especialista</option>
                            <option value="perito">Perito</option>
                            <option value="tecnico">Técnico</option>
                            <option value="auxiliar">Auxiliar</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-input" name="usuario" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contraseña Temporal</label>
                        <input type="password" class="form-input" name="password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-input" name="direccion">
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Usuario
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('newUserModal')">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR PERFIL -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal('profileModal')">&times;</button>
            <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>
            
            <div class="photo-upload-area">
                <div class="current-photo" id="currentPhoto">
                    <i class="fas fa-user"></i>
                </div>
                <button type="button" class="photo-upload-btn" onclick="selectPhoto()">
                    <i class="fas fa-camera"></i> Cambiar Foto
                </button>
                <input type="file" id="photoInput" accept="image/*" style="display: none;" onchange="previewPhoto(event)">
            </div>
            
            <form id="profileForm" onsubmit="updateProfile(event)">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Nombres</label>
                        <input type="text" class="form-input" name="nombres" value="Juan Carlos">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input type="text" class="form-input" name="apellidos" value="Mamani Quispe">
                    </div>
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">DNI</label>
                        <input type="text" class="form-input" name="dni" value="12345678" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-input" name="telefono" value="+51 987654321">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" value="jefe@criminalistica.gob.pe">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-input" name="direccion" value="Jr. Los Incas 456, Puno">
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('profileModal')">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" onclick="showChangePasswordModal()">
                        <i class="fas fa-key"></i> Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CAMBIAR CONTRASEÑA -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <button class="close-modal" onclick="closeModal('changePasswordModal')">&times;</button>
            <h2><i class="fas fa-key"></i> Cambiar Contraseña</h2>
            
            <form id="passwordForm" onsubmit="changePassword(event)">
                <div class="form-group">
                    <label class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-input" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-input" name="new_password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-input" name="confirm_password" required minlength="6">
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cambiar Contraseña
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('changePasswordModal')">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Botones de acceso rápido -->
    <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button onclick="viewProfile()" style="width: 50px; height: 50px; border-radius: 50%; background: #0f4c3a; color: white; border: none; cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;" title="Ver Perfil (Alt+P)" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-user"></i>
            </button>
            <button onclick="showHelp()" style="width: 50px; height: 50px; border-radius: 50%; background: #3b82f6; color: white; border: none; cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;" title="Ayuda" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-question"></i>
            </button>
            <button onclick="refreshData()" style="width: 50px; height: 50px; border-radius: 50%; background: #10b981; color: white; border: none; cursor: pointer; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;" title="Actualizar (Ctrl+R)" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <script src="../js\jefatura.js"></script>
</body>
</html>