
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Antropología Forense - Criminalística Puno</title>
    
    <style>
        /* ========================================
           VARIABLES Y CONFIGURACIÓN GLOBAL
           ======================================== */
        :root {
            /* Colores institucionales */
            --primary-green: #1a4b3a;
            --secondary-green: #2d5a3d;
            --antropologia-primary: #2d5a3d;
            --antropologia-secondary: #3a7555;
            --antropologia-accent: #4a9065;
            --antropologia-dark: #1a4b3a;
            
            /* Colores de estado */
            --success: #4caf50;
            --warning: #ff9800;
            --error: #f44336;
            --info: #2196f3;
            --pending: #ff9800;
            --completed: #4caf50;
            
            /* Grises */
            --gray-50: #fafafa;
            --gray-100: #f5f5f5;
            --gray-200: #eeeeee;
            --gray-300: #e0e0e0;
            --gray-400: #bdbdbd;
            --gray-500: #9e9e9e;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
            
            /* Espaciados */
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --spacing-xxl: 48px;
            
            /* Sombras */
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 8px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.1);
            
            /* Transiciones */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }
        /* ========================================
           RESET Y ESTILOS BASE
           ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        /* ========================================
           SIDEBAR
           ======================================== */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2d5a3d 0%, #1a4b3a 100%);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: transform var(--transition-normal);
        }
        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-icon svg {
            width: 30px;
            height: 30px;
            fill: white;
        }
        .logo-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }
        .logo-text p {
            margin: 0;
            font-size: 12px;
            opacity: 0.8;
        }
        .user-info {
            padding: 20px;
            background: rgba(0,0,0,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .user-info h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        .user-info p {
            margin: 0 0 10px 0;
            font-size: 13px;
            opacity: 0.8;
        }
        .login-time {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            opacity: 0.7;
        }
        /* Navigation */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: all var(--transition-normal);
            position: relative;
            cursor: pointer;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.1);
        }
        .nav-item.active {
            background: rgba(255,255,255,0.15);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
        }
        .nav-icon {
            width: 20px;
            height: 20px;
            fill: white;
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 20px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all var(--transition-normal);
            cursor: pointer;
            border: none;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
        }
        /* ========================================
           MAIN CONTENT
           ======================================== */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-header {
            background: white;
            padding: 20px 30px;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .header-left h1 {
            margin: 0 0 5px 0;
            font-size: 24px;
            color: #333;
        }
        .breadcrumb {
            font-size: 13px;
            color: #666;
        }
        .breadcrumb a {
            color: #2d5a3d;
            text-decoration: none;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }
        .notification-btn svg {
            width: 24px;
            height: 24px;
            fill: #666;
        }
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #f44336;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }
        .welcome-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: #e8f5e9;
            color: #2d5a3d;
            border-radius: 20px;
            font-size: 14px;
        }
        /* ========================================
           CONTENT SECTIONS
           ======================================== */
        .content-section {
            display: none;
            padding: 30px;
            animation: fadeIn 0.3s ease;
        }
        .content-section.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* ========================================
           STATS CARDS
           ======================================== */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all var(--transition-normal);
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon.blue { background: #e8f5e9; color: #2d5a3d; }
        .stat-icon.orange { background: #fff3e0; color: #ff9800; }
        .stat-icon.green { background: #e8f5e9; color: #4caf50; }
        .stat-icon.purple { background: #f3e5f5; color: #9c27b0; }
        .stat-icon svg {
            width: 30px;
            height: 30px;
            fill: currentColor;
        }
        .stat-content h3 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }
        .stat-content p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        /* ========================================
           ACTION CARDS
           ======================================== */
        .action-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
        }
        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .action-icon.green { background: #e8f5e9; color: #4caf50; }
        .action-icon.blue { background: #e8f5e9; color: #2d5a3d; }
        .action-icon.orange { background: #fff3e0; color: #ff9800; }
        .action-icon.purple { background: #f3e5f5; color: #9c27b0; }
        .action-icon svg {
            width: 35px;
            height: 35px;
            fill: currentColor;
        }
        .action-card h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            color: #333;
        }
        .action-card p {
            margin: 0 0 20px 0;
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            color: white;
        }
        .action-btn svg {
            width: 20px;
            height: 20px;
            fill: white;
        }
        .action-btn.green { background: #4caf50; }
        .action-btn.green:hover { background: #45a049; }
        .action-btn.blue { background: #2d5a3d; }
        .action-btn.blue:hover { background: #1a4b3a; }
        .action-btn.orange { background: #ff9800; }
        .action-btn.orange:hover { background: #f57c00; }
        .action-btn.purple { background: #9c27b0; }
        .action-btn.purple:hover { background: #7b1fa2; }
        /* ========================================
           DOCUMENTS TABLE
           ======================================== */
        .recent-documents {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--shadow-md);
        }
        .recent-documents h2 {
            margin: 0 0 20px 0;
            font-size: 20px;
            color: #333;
        }
        .table-container {
            overflow-x: auto;
        }
        .documents-table {
            width: 100%;
            border-collapse: collapse;
        }
        .documents-table thead {
            background: #f5f5f5;
        }
        .documents-table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .documents-table td {
            padding: 16px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }
        .documents-table tbody tr:hover {
            background: #f9f9f9;
        }
        .doc-type {
            display: inline-block;
            padding: 4px 10px;
            background: #e8f5e9;
            color: #2d5a3d;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status.pending {
            background: #fff3e0;
            color: #f57c00;
        }
        .status.completed {
            background: #e8f5e9;
            color: #388e3c;
        }
        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            margin: 0 2px;
            border-radius: 4px;
            transition: background var(--transition-fast);
        }
        .btn-icon:hover {
            background: #f5f5f5;
        }
        .btn-icon svg {
            width: 18px;
            height: 18px;
            fill: #666;
        }
        /* ========================================
           FORMS
           ======================================== */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .section-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f5f5f5;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        .btn-back:hover {
            background: #e0e0e0;
        }
        .document-form {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow-md);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all var(--transition-normal);
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2d5a3d;
            box-shadow: 0 0 0 3px rgba(45, 90, 61, 0.1);
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        .btn-primary {
            background: #2d5a3d;
            color: white;
        }
        .btn-primary:hover {
            background: #1a4b3a;
        }
        .btn-secondary {
            background: #f5f5f5;
            color: #666;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        /* ========================================
           MODAL
           ======================================== */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease;
        }
        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
        }
        .close:hover {
            color: #333;
        }
        /* ========================================
           FLOATING ACTION BUTTON
           ======================================== */
        .fab-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }
        .fab {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #2d5a3d;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: all var(--transition-normal);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0,0,0,0.3);
        }
        .fab svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        /* ========================================
           NOTIFICATIONS
           ======================================== */
        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1001;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .notification-toast.show {
            transform: translateX(0);
        }
        .notification-toast.success { border-left: 4px solid #4caf50; }
        .notification-toast.error { border-left: 4px solid #f44336; }
        .notification-toast.warning { border-left: 4px solid #ff9800; }
        .notification-toast.info { border-left: 4px solid #2d5a3d; }
        /* ========================================
           LOADING
           ======================================== */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #2d5a3d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* ========================================
           RESPONSIVE
           ======================================== */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            margin-right: 15px;
        }
        .mobile-menu-btn svg {
            width: 24px;
            height: 24px;
            fill: #333;
        }
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-container,
            .action-cards-container,
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-badge {
                display: none;
            }
            
            .documents-table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24"><path d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"/></svg>
    </button>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,2A3,3 0 0,1 15,5V11A3,3 0 0,1 12,14A3,3 0 0,1 9,11V5A3,3 0 0,1 12,2M19,11C19,14.53 16.39,17.44 13,17.93V21H11V17.93C7.61,17.44 5,14.53 5,11H7A5,5 0 0,0 12,16A5,5 0 0,0 17,11H19Z"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <h2>ANTROPOLOGÍA</h2>
                    <p>CRIMINALÍSTICA PUNO</p>
                </div>
            </div>
        </div>
        <div class="user-info">
            <h3>Juan Carlos Mamani</h3>
            <p>Perito Antropólogo</p>
            <span class="login-time">
                <svg style="width:16px;height:16px" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
                </svg>
                <span id="datetime">26/01/2025 15:58</span>
            </span>
        </div>
        <nav class="sidebar-nav">
            <a class="nav-item active" onclick="showSection('dashboard')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z"/>
                </svg>
                Panel Principal
            </a>
            
            <a class="nav-item" onclick="showSection('nuevo-documento')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                </svg>
                Nuevo Documento
            </a>
            
            <a class="nav-item" onclick="showSection('documentos-entrada')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M10,19L12,15H9V10H15V15L13,19H10Z"/>
                </svg>
                Documentos Entrada
            </a>
            
            <a class="nav-item" onclick="showSection('documentos-salida')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M9,13V18H15V13L12,9L9,13Z"/>
                </svg>
                Documentos Salida
            </a>
            
            <a class="nav-item" onclick="showSection('buscar')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
                </svg>
                Buscar Documentos
            </a>
            
            <a class="nav-item" onclick="showSection('reportes')">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9,4V20H5V4H9M9,2H5A2,2 0 0,0 3,4V20A2,2 0 0,0 5,22H9A2,2 0 0,0 11,20V4A2,2 0 0,0 9,2M15,4V20H11V4H15M15,2H11A2,2 0 0,0 9,4V20A2,2 0 0,0 11,22H15A2,2 0 0,0 17,20V4A2,2 0 0,0 15,2M21,4V20H17V4H21M21,2H17A2,2 0 0,0 15,4V20A2,2 0 0,0 17,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2Z"/>
                </svg>
                Reportes
            </a>
        </nav>
        <div class="sidebar-footer">
            <button class="logout-btn" onclick="logout()">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"/>
                </svg>
                Cerrar Sesión
            </button>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">
                <h1>Panel de Gestión Documental - Antropología Forense</h1>
                <nav class="breadcrumb">
                    <a href="#" onclick="showSection('dashboard')">Inicio</a>
                    <span>/</span>
                    <span id="breadcrumb-current">Panel Principal</span>
                </nav>
            </div>
            <div class="header-right">
                <button class="notification-btn" onclick="toggleNotifications()">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"/>
                    </svg>
                    <span class="notification-badge">3</span>
                </button>
                <div class="welcome-badge">
                    <svg style="width:20px;height:20px" viewBox="0 0 24 24" fill="#2d5a3d">
                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                    </svg>
                    Bienvenido al Panel de Antropología
                </div>
            </div>
        </header>
        <!-- Dashboard Section -->
        <section id="dashboard" class="content-section active">
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16,15H9V13H16M19,11H9V9H19M19,7H9V5H19M21,1H7C5.89,1 5,1.89 5,3V17C5,18.11 5.9,19 7,19H21C22.11,19 23,18.11 23,17V3C23,1.89 22.1,1 21,1M3,5V21H19V23H3A2,2 0 0,1 1,21V5H3Z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 id="stat-hoy">12</h3>
                        <p>DOCUMENTOS HOY</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9A3,3 0 0,1 15,12Z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 id="stat-pendientes">8</h3>
                        <p>PENDIENTES</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M12,18L7,13L8.41,11.59L12,15.17L15.59,11.58L17,13L12,18Z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 id="stat-mes">156</h3>
                        <p>PROCESADOS ESTE MES</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16,6L18.29,8.29L13.41,13.17L9.41,9.17L2,16.59L3.41,18L9.41,12L13.41,16L19.71,9.71L22,12V6H16Z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <h3 id="stat-eficiencia">94%</h3>
                        <p>EFICIENCIA PROMEDIO</p>
                    </div>
                </div>
            </div>
            <!-- Action Cards -->
            <div class="action-cards-container">
                <div class="action-card">
                    <div class="action-icon green">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M10,19L12,15H9V10H15V15L13,19H10Z"/>
                        </svg>
                    </div>
                    <h3>Registro de Entrada</h3>
                    <p>Registre nuevos documentos, muestras o evidencias que ingresan al área de Antropología Forense para su análisis.</p>
                    <button class="action-btn green" onclick="showSection('nuevo-documento')">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                        </svg>
                        Nuevo Ingreso
                    </button>
                </div>
                <div class="action-card">
                    <div class="action-icon blue">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M9,13V18H15V13L12,9L9,13Z"/>
                        </svg>
                    </div>
                    <h3>Registro de Salida</h3>
                    <p>Registre la salida de documentos procesados, informes periciales o muestras devueltas.</p>
                    <button class="action-btn blue" onclick="showSalidaModal()">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16,17V14H9V10H16V7L21,12L16,17Z"/>
                        </svg>
                        Registrar Salida
                    </button>
                </div>
                <div class="action-card">
                    <div class="action-icon orange">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
                        </svg>
                    </div>
                    <h3>Búsqueda Rápida</h3>
                    <p>Busque documentos por número de oficio, remitente, fecha o cualquier otro criterio.</p>
                    <button class="action-btn orange" onclick="showSection('buscar')">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
                        </svg>
                        Buscar
                    </button>
                </div>
                <div class="action-card">
                    <div class="action-icon purple">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22,21H2V3H4V19H6V10H10V19H12V6H16V19H18V14H22V21Z"/>
                        </svg>
                    </div>
                    <h3>Reportes y Estadísticas</h3>
                    <p>Genere reportes detallados y estadísticas del área de Antropología Forense.</p>
                    <button class="action-btn purple" onclick="showSection('reportes')">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9,4V20H5V4H9M9,2H5A2,2 0 0,0 3,4V20A2,2 0 0,0 5,22H9A2,2 0 0,0 11,20V4A2,2 0 0,0 9,2M15,4V20H11V4H15M15,2H11A2,2 0 0,0 9,4V20A2,2 0 0,0 11,22H15A2,2 0 0,0 17,20V4A2,2 0 0,0 15,2M21,4V20H17V4H21M21,2H17A2,2 0 0,0 15,4V20A2,2 0 0,0 17,22H21A2,2 0 0,0 23,20V4A2,2 0 0,0 21,2Z"/>
                        </svg>
                        Ver Reportes
                    </button>
                </div>
            </div>
            <!-- Recent Documents Table -->
            <div class="recent-documents">
                <h2>Documentos Recientes</h2>
                <div class="table-container">
                    <table class="documents-table">
                        <thead>
                            <tr>
                                <th>N° Documento</th>
                                <th>Tipo</th>
                                <th>Remitente</th>
                                <th>Asunto</th>
                                <th>Fecha Ingreso</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="recent-docs-tbody">
                            <tr>
                                <td>OF-2025-001</td>
                                <td><span class="doc-type">Oficio</span></td>
                                <td>Fiscalía Provincial</td>
                                <td>Análisis de restos óseos</td>
                                <td>15/01/2025</td>
                                <td><span class="status pending">En Proceso</span></td>
                                <td>
                                    <button class="btn-icon" title="Ver detalles" onclick="viewDocument('OF-2025-001')">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                        </svg>
                                    </button>
                                    <button class="btn-icon" title="Editar" onclick="editDocument('OF-2025-001')">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF-2025-003</td>
                                <td><span class="doc-type">Informe</span></td>
                                <td>PNP - Comisaría Centro</td>
                                <td>Identificación de víctima</td>
                                <td>14/01/2025</td>
                                <td><span class="status completed">Completado</span></td>
                                <td>
                                    <button class="btn-icon" title="Ver detalles" onclick="viewDocument('INF-2025-003')">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                        </svg>
                                    </button>
                                    <button class="btn-icon" title="Descargar" onclick="downloadDocument('INF-2025-003')">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Nuevo Documento Section -->
        <section id="nuevo-documento" class="content-section">
            <div class="section-header">
                <h2>Registrar Nuevo Documento</h2>
                <button class="btn-back" onclick="showSection('dashboard')">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"/>
                    </svg>
                    Volver al Panel
                </button>
            </div>
            <form class="document-form" id="nuevoDocumentoForm" onsubmit="handleNuevoDocumento(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="tipoDocumento">Tipo de Documento *</label>
                        <select id="tipoDocumento" name="tipoDocumento" required>
                            <option value="">Seleccione...</option>
                            <option value="oficio">Oficio</option>
                            <option value="informe">Informe</option>
                            <option value="memorandum">Memorándum</option>
                            <option value="solicitud">Solicitud</option>
                            <option value="evidencia">Evidencia</option>
                            <option value="muestra">Muestra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numeroDocumento">Número de Documento *</label>
                        <input type="text" id="numeroDocumento" name="numeroDocumento" required placeholder="Ej: OF-2025-001">
                    </div>
                    <div class="form-group">
                        <label for="fechaIngreso">Fecha de Ingreso *</label>
                        <input type="datetime-local" id="fechaIngreso" name="fechaIngreso" required>
                    </div>
                    <div class="form-group">
                        <label for="remitente">Remitente *</label>
                        <input type="text" id="remitente" name="remitente" required placeholder="Institución o persona">
                    </div>
                    <div class="form-group">
                        <label for="cargoRemitente">Cargo del Remitente</label>
                        <input type="text" id="cargoRemitente" name="cargoRemitente" placeholder="Cargo o función">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono de Contacto</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="999999999">
                    </div>
                    <div class="form-group full-width">
                        <label for="asunto">Asunto *</label>
                        <textarea id="asunto" name="asunto" rows="3" required placeholder="Descripción breve del asunto"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" placeholder="Observaciones adicionales"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prioridad">Prioridad *</label>
                        <select id="prioridad" name="prioridad" required>
                            <option value="normal">Normal</option>
                            <option value="urgente">Urgente</option>
                            <option value="muy_urgente">Muy Urgente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="adjunto">Adjuntar Archivo</label>
                        <input type="file" id="adjunto" name="adjunto" accept=".pdf,.doc,.docx,.jpg,.png">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="resetForm()">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3M19,19H5V5H16.17L19,7.83V19M12,12C10.34,12 9,13.34 9,15S10.34,18 12,18 15,16.66 15,15 13.66,12 12,12M6,6H15V10H6V6Z"/>
                        </svg>
                        Guardar Documento
                    </button>
                </div>
            </form>
        </section>
        <!-- Otras secciones vacías por ahora -->
        <section id="documentos-entrada" class="content-section">
            <h2>Documentos de Entrada</h2>
            <p>Esta sección está en desarrollo...</p>
        </section>
        <section id="documentos-salida" class="content-section">
            <h2>Documentos de Salida</h2>
            <p>Esta sección está en desarrollo...</p>
        </section>
        <section id="buscar" class="content-section">
            <h2>Buscar Documentos</h2>
            <p>Esta sección está en desarrollo...</p>
        </section>
        <section id="reportes" class="content-section">
            <h2>Reportes</h2>
            <p>Esta sección está en desarrollo...</p>
        </section>
    </main>
    <!-- Modal -->
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Notificaciones</h2>
            <div class="notifications-list">
                <p>No hay notificaciones nuevas</p>
            </div>
        </div>
    </div>
    <!-- Floating Action Button -->
    <div class="fab-container">
        <button class="fab" onclick="showQuickActions()">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
            </svg>
        </button>
    </div>
    <script>
        // Variables globales
        let currentSection = 'dashboard';
        // Actualizar fecha y hora
        function updateDateTime() {
            const now = new Date();
            const datetime = now.toLocaleString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('datetime').textContent = datetime;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
        // Toggle sidebar móvil
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
        // Mostrar sección
        function showSection(sectionId) {
            // Ocultar todas las secciones
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Mostrar sección seleccionada
            document.getElementById(sectionId).classList.add('active');
            
            // Actualizar navegación activa
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Marcar el item activo
            const activeItem = document.querySelector(`[onclick="showSection('${sectionId}')"]`);
            if (activeItem) {
                activeItem.classList.add('active');
            }
            
            // Actualizar breadcrumb
            const breadcrumbTexts = {
                'dashboard': 'Panel Principal',
                'nuevo-documento': 'Nuevo Documento',
                'documentos-entrada': 'Documentos de Entrada',
                'documentos-salida': 'Documentos de Salida',
                'buscar': 'Buscar Documentos',
                'reportes': 'Reportes'
            };
            document.getElementById('breadcrumb-current').textContent = breadcrumbTexts[sectionId] || 'Sección';
            
            currentSection = sectionId;
            
            // Cerrar sidebar en móvil
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        }
        // Manejar nuevo documento
        function handleNuevoDocumento(event) {
            event.preventDefault();
            showLoading('Guardando documento...');
            
            // Simular guardado
            setTimeout(() => {
                hideLoading();
                showNotification('Documento guardado exitosamente', 'success');
                resetForm();
                showSection('dashboard');
                
                // Actualizar estadísticas
                updateStats();
            }, 1500);
        }
        // Reset form
        function resetForm() {
            document.getElementById('nuevoDocumentoForm').reset();
        }
        // Mostrar/ocultar loading
        function showLoading(message = 'Cargando...') {
            const loading = document.createElement('div');
            loading.id = 'loadingOverlay';
            loading.className = 'loading-overlay';
            loading.innerHTML = `
                <div class="loading-content">
                    <div class="loading-spinner"></div>
                    <p>${message}</p>
                </div>
            `;
            document.body.appendChild(loading);
        }
        function hideLoading() {
            const loading = document.getElementById('loadingOverlay');
            if (loading) loading.remove();
        }
        // Notificaciones
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification-toast ${type} show`;
            notification.innerHTML = `
                <svg viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px">
                    ${type === 'success' ? '<path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>' :
                      type === 'error' ? '<path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>' :
                      '<path d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>'}
                </svg>
                <span>${message}</span>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
        // Ver documento
        function viewDocument(docId) {
            showNotification(`Viendo documento ${docId}`, 'info');
        }
        // Editar documento
        function editDocument(docId) {
            showNotification(`Editando documento ${docId}`, 'info');
        }
        // Descargar documento
        function downloadDocument(docId) {
            showNotification(`Descargando documento ${docId}`, 'info');
        }
        // Modal de salida
        function showSalidaModal() {
            showNotification('Función en desarrollo', 'info');
        }
        // Toggle notificaciones
        function toggleNotifications() {
            document.getElementById('notificationModal').style.display = 'block';
        }
        // Cerrar modal
        function closeModal() {
            document.getElementById('notificationModal').style.display = 'none';
        }
        // Acciones rápidas
        function showQuickActions() {
            showNotification('Menú de acciones rápidas', 'info');
        }
// Logout
function logout() {
    if (confirm('¿Está seguro de cerrar sesión?')) {
        window.location.href = '../index.php';
    }
}

        // Actualizar estadísticas
        function updateStats() {
            // Simular actualización de estadísticas
            const stats = {
                hoy: Math.floor(Math.random() * 20) + 5,
                pendientes: Math.floor(Math.random() * 10) + 3,
                mes: Math.floor(Math.random() * 200) + 100,
                eficiencia: Math.floor(Math.random() * 10) + 90
            };
            
            document.getElementById('stat-hoy').textContent = stats.hoy;
            document.getElementById('stat-pendientes').textContent = stats.pendientes;
            document.getElementById('stat-mes').textContent = stats.mes;
            document.getElementById('stat-eficiencia').textContent = stats.eficiencia + '%';
        }
        // Click fuera del modal para cerrar
        window.onclick = function(event) {
            const modal = document.getElementById('notificationModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            
            // Set fecha actual en el formulario
            const now = new Date();
            const localISOTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
            const fechaInput = document.getElementById('fechaIngreso');
            if (fechaInput) {
                fechaInput.value = localISOTime;
            }
        });
    </script>
</body>
</html>