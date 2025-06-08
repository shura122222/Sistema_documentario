
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Antropología Forense</title>
    <style>
        :root {
            --main-color: #1a4741;
            --accent-color: #f6ba19;
            --text-color: #ffffff;
            --hover-color: #235952;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--main-color);
            color: var(--text-color);
            min-height: 100vh;
        }
        
        .sidebar {
            width: 300px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--main-color);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: all 0.3s ease;
        }
        
        .logo-container {
            width: 180px;
            height: 180px;
            margin-bottom: 30px;
            position: relative;
            animation: pulse 4s infinite alternate;
        }
        
        .logo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid var(--accent-color);
            transition: transform 0.5s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .info-section {
            width: 85%;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            transition: transform 0.3s ease;
        }
        
        .info-section:hover {
            transform: translateX(5px);
        }
        
        .info-title {
            font-size: 16px;
            color: var(--accent-color);
            margin-bottom: 5px;
        }
        
        .info-content {
            font-size: 18px;
            font-weight: 500;
        }
        
        .button-container {
            margin-top: 20px;
            width: 85%;
        }
        
        .button {
            width: 100%;
            padding: 12px;
            background-color: var(--accent-color);
            color: var(--main-color);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .button:hover {
            background-color: #ffca3a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .button:active {
            transform: translateY(0);
        }
        
        .main-content {
            margin-left: 300px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .welcome-message {
            text-align: center;
            font-size: 24px;
            opacity: 0;
            animation: fadeIn 1s forwards 0.5s;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(246, 186, 25, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(246, 186, 25, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(246, 186, 25, 0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <img src="/api/placeholder/180/180" alt="Logo Antropología Forense" class="logo">
        </div>
        
        <div class="info-section">
            <div class="info-title">ÁREA DE ANTROPOLOGÍA FORENSE</div>
        </div>
        
        <div class="info-section">
            <div class="info-title">NOMBRE:</div>
            <div class="info-content">JULIO.....</div>
        </div>
        
        <div class="info-section">
            <div class="info-title">ESPECIALIDAD:</div>
            <div class="info-content">ANTROPÓLOGO</div>
        </div>
        
        <div class="button-container">
            <button class="button" id="documentosBtn">DOCUMENTOS</button>
        </div>
    </div>
    
    <div class="main-content">
        <div class="welcome-message">
            <h1>Bienvenido al Sistema de Antropología Forense</h1>
            <p>Seleccione una opción del menú para continuar</p>
        </div>
    </div>

    <script>
        // Add animation when hovering over the logo
        const logo = document.querySelector('.logo');
        logo.addEventListener('mouseover', () => {
            logo.style.boxShadow = '0 0 20px var(--accent-color)';
        });
        
        logo.addEventListener('mouseout', () => {
            logo.style.boxShadow = 'none';
        });
        
        // Add click effect to the button
        const button = document.getElementById('documentosBtn');
        button.addEventListener('click', () => {
            button.style.transform = 'scale(0.95)';
            setTimeout(() => {
                button.style.transform = 'scale(1)';
                alert('Sección de documentos en desarrollo');
            }, 200);
        });
        
        // Add animation to info sections
        const infoSections = document.querySelectorAll('.info-section');
        infoSections.forEach((section, index) => {
            section.style.opacity = '0';
            setTimeout(() => {
                section.style.transition = 'opacity 0.5s ease, transform 0.3s ease';
                section.style.opacity = '1';
            }, 200 * (index + 1));
        });
    </script>
</body>
</html>