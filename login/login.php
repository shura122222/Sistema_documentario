<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/lg.css">

</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-container">
                <!--  cambiar la imagen del logo -->
                <img src="111.png" alt="Logo Criminalística" class="logo" id="logo-image">
            </div>
            
            <div class="login-form">
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="white"></path>
                        </svg>
                    </div>
                    <input type="text" class="form-input" placeholder="USUARIO">
                </div>
                
                <div class="input-group">
                    <div class="input-icon">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" fill="white"></path>
                        </svg>
                    </div>
                    <input type="password" class="form-input" placeholder="CONTRASEÑA">
                </div>
                
                <button class="login-button">INGRESAR</button>
                
                <div class="forgot-password">
                    <a href="#">¿recuperar contraseña?</a>
                </div>
            </div>
        </div>
        <div class="login-right"></div>
    </div>

    <script>
        // Este script te permite cambiar la imagen del logo
        // Reemplaza la URL a continuación con la ruta a tu imagen real
        document.addEventListener('DOMContentLoaded', function() {
            // Para cambiar el logo, modifica la URL en la siguiente línea
            // const logoUrl = "ruta/a/tu/logo.png";
            // document.getElementById('logo-image').src = logoUrl;
        });
    </script>
</body>
</html>

