/**
 * SISTEMA DE LOGIN - CRIMINALÍSTICA PUNO
 * ✅ CORREGIDO: Login directo con email y contraseña (sin selección de área)
 */

/**
 * SISTEMA DE NOTIFICACIONES MODERNAS
 */
class ModernNotificationSystem {
    constructor() {
        this.container = null;
        this.notifications = new Map();
        this.notificationId = 0;
        this.maxNotifications = 5;
        this.init();
    }
    
    init() {
        this.container = document.getElementById('notifications');
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'notifications';
            this.container.className = 'notification-container';
            document.body.appendChild(this.container);
        }
    }
    
    show(message, type = 'info', options = {}) {
        const defaultOptions = {
            title: this.getDefaultTitle(type),
            duration: this.getDefaultDuration(type),
            closable: true,
            onclick: null,
            icon: this.getDefaultIcon(type)
        };
        
        const config = { ...defaultOptions, ...options };
        
        if (this.notifications.size >= this.maxNotifications) {
            this.removeOldest();
        }
        
        const notification = this.createNotification(message, type, config);
        this.addNotification(notification, config.duration);
        
        return notification.id;
    }
    
    success(message, options = {}) {
        return this.show(message, 'success', options);
    }
    
    error(message, options = {}) {
        return this.show(message, 'error', options);
    }
    
    warning(message, options = {}) {
        return this.show(message, 'warning', options);
    }
    
    info(message, options = {}) {
        return this.show(message, 'info', options);
    }
    
    loading(message, options = {}) {
        return this.show(message, 'loading', { ...options, closable: false });
    }
    
    createNotification(message, type, config) {
        const id = ++this.notificationId;
        
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.id = `notification-${id}`;
        
        notification.innerHTML = `
            <div class="notification-icon">
                ${this.getIconHTML(config.icon, type)}
            </div>
            <div class="notification-content">
                <div class="notification-title">${config.title}</div>
                <div class="notification-message">${message}</div>
            </div>
            ${config.closable ? `
                <button class="notification-close" onclick="window.notificationSystem.remove('${id}')">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                    </svg>
                </button>
            ` : ''}
        `;
        
        if (config.onclick) {
            notification.addEventListener('click', config.onclick);
            notification.style.cursor = 'pointer';
        }
        
        let autoRemoveTimer;
        notification.addEventListener('mouseenter', () => {
            if (autoRemoveTimer) clearTimeout(autoRemoveTimer);
        });
        
        notification.addEventListener('mouseleave', () => {
            if (config.duration > 0) {
                autoRemoveTimer = setTimeout(() => this.remove(id), 2000);
            }
        });
        
        return { element: notification, id: id };
    }
    
    addNotification(notification, duration) {
        this.container.appendChild(notification.element);
        
        requestAnimationFrame(() => {
            notification.element.classList.add('show');
        });
        
        this.notifications.set(notification.id, notification.element);
        
        if (duration > 0) {
            setTimeout(() => this.remove(notification.id), duration);
        }
    }
    
    remove(id) {
        const notification = this.notifications.get(id);
        if (!notification) return;
        
        notification.classList.add('hide');
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            this.notifications.delete(id);
        }, 400);
    }
    
    removeOldest() {
        const firstKey = this.notifications.keys().next().value;
        if (firstKey) this.remove(firstKey);
    }
    
    getIconHTML(icon, type) {
        if (type === 'loading') {
            return '<div class="notification-spinner"></div>';
        }
        
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ',
            check: '✓',
            cross: '✕'
        };
        
        return icons[icon] || icons[type] || icons.info;
    }
    
    getDefaultTitle(type) {
        const titles = {
            success: 'Éxito',
            error: 'Error',
            warning: 'Advertencia',
            info: 'Información',
            loading: 'Cargando'
        };
        return titles[type] || 'Notificación';
    }
    
    getDefaultIcon(type) {
        const icons = {
            success: 'check',
            error: 'cross',
            warning: 'warning',
            info: 'info',
            loading: 'loading'
        };
        return icons[type] || 'info';
    }
    
    getDefaultDuration(type) {
        const durations = {
            success: 5000,
            error: 7000,
            warning: 6000,
            info: 5000,
            loading: 0
        };
        return durations[type] || 5000;
    }
    
    // Métodos específicos para el sistema
    systemReady() {
        return this.success('✓ Sistema Criminalística Puno cargado correctamente', {
            title: 'Sistema Cargado',
            duration: 4000
        });
    }
    
    loginSuccess(username, area) {
        return this.success(`¡Bienvenido ${username}! Redirigiendo a ${area}...`, {
            title: 'Acceso Autorizado'
        });
    }
    
    loginError(message = 'Credenciales incorrectas') {
        return this.error(message, {
            title: 'Error de Acceso'
        });
    }
    
    credentialsValidating() {
        return this.loading('Validando credenciales y determinando área asignada...', {
            title: 'Verificando Acceso'
        });
    }
    
    capsLockWarning() {
        return this.warning('Bloq Mayús está activado', {
            title: 'Atención',
            duration: 4000
        });
    }
}

/**
 * SISTEMA DE LOGIN SIMPLIFICADO - SOLO EMAIL Y CONTRASEÑA
 * ✅ CORREGIDO: Login directo sin selección de área (área se determina automáticamente)
 */
class LoginSystem {
    constructor() {
        this.currentLoadingNotification = null;
        
        this.initializeElements();
        this.bindEvents();
        this.startAnimations();
        this.setupInactivityTimer();
    }
    
    initializeElements() {
        this.loginForm = document.getElementById('loginForm');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.loginButton = document.getElementById('loginButton');
        this.buttonText = this.loginButton.querySelector('.button-text');
        this.loadingSpinner = this.loginButton.querySelector('.loading-spinner');
        
        this.togglePassword = document.getElementById('togglePassword');
        this.capsWarning = document.getElementById('capsWarning');
        
        this.forgotPasswordLink = document.getElementById('forgotPassword');
        this.helpLink = document.getElementById('helpLink');
        
        // Obtener token CSRF
        this.csrfToken = window.loginConfig ? window.loginConfig.csrfToken : '';
    }
    
    bindEvents() {
        this.loginForm.addEventListener('submit', (e) => this.handleSubmit(e));
        
        this.emailInput.addEventListener('input', () => this.validateInput(this.emailInput));
        this.passwordInput.addEventListener('input', () => this.validateInput(this.passwordInput));
        this.emailInput.addEventListener('keyup', (e) => this.checkCapsLock(e));
        this.passwordInput.addEventListener('keyup', (e) => this.checkCapsLock(e));
        
        this.togglePassword.addEventListener('click', () => this.togglePasswordVisibility());
        
        this.forgotPasswordLink.addEventListener('click', (e) => this.handleForgotPassword(e));
        this.helpLink.addEventListener('click', (e) => this.showHelp(e));
        
        document.addEventListener('keydown', (e) => this.handleKeyboard(e));
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        await this.performLogin();
    }
    
    async performLogin() {
        const email = this.emailInput.value.trim();
        const password = this.passwordInput.value.trim();
        
        if (!this.basicValidation(email, password)) return;
        
        this.setLoading(true, 'VALIDANDO CREDENCIALES...');
        this.currentLoadingNotification = window.notificationSystem.credentialsValidating();
        
        try {
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('csrf_token', this.csrfToken);
            
            // Enviar a validar_credenciales.php con ruta correcta
            const response = await fetch("./validar_credenciales.php", {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                this.handleSuccessfulLogin(data);
            } else {
                this.handleFailedLogin(data.message);
            }
            
        } catch (error) {
            console.error('Error:', error);
            if (error.message.includes('404')) {
                this.handleFailedLogin('Error: No se pudo conectar con el servidor. Verifique la configuración.');
            } else {
                this.handleFailedLogin('Error de conexión. Verifique su red e intente nuevamente.');
            }
        } finally {
            this.setLoading(false);
            if (this.currentLoadingNotification) {
                window.notificationSystem.remove(this.currentLoadingNotification);
                this.currentLoadingNotification = null;
            }
        }
    }
    
    basicValidation(email, password) {
        if (!email) {
            this.showFieldError(this.emailInput, 'El email es requerido');
            return false;
        }
        
        // Validar formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            this.showFieldError(this.emailInput, 'Formato de email inválido');
            return false;
        }
        
        if (!password) {
            this.showFieldError(this.passwordInput, 'La contraseña es requerida');
            return false;
        }
        
        if (password.length < 3) {
            this.showFieldError(this.passwordInput, 'La contraseña debe tener al menos 3 caracteres');
            return false;
        }
        
        return true;
    }
    
    handleSuccessfulLogin(data) {
        const userName = data.user ? data.user.name || data.user.email : 'Usuario';
        const userArea = data.user ? data.user.area || 'Sistema' : 'Sistema';
        
        window.notificationSystem.loginSuccess(userName, userArea);
        
        this.loginButton.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
        this.buttonText.textContent = '✓ ACCESO AUTORIZADO';
        
        // Guardar información de sesión
        if (typeof(Storage) !== "undefined") {
            sessionStorage.setItem('loginTime', new Date().toISOString());
            sessionStorage.setItem('userArea', userArea);
        }
        
        setTimeout(() => {
            // Redireccionar a la URL proporcionada por el servidor
            window.location.href = data.redirect || '../areas/';
        }, 1500);
    }
    
    handleFailedLogin(message = 'Credenciales incorrectas') {
        window.notificationSystem.error(message, {
            title: 'Error de Acceso',
            duration: 8000
        });
        
        // Efectos de error
        this.emailInput.classList.add('error');
        this.passwordInput.classList.add('error');
        
        // Animación de shake
        this.loginForm.style.animation = 'shake 0.5s ease-in-out';
        
        setTimeout(() => {
            this.emailInput.classList.remove('error');
            this.passwordInput.classList.remove('error');
            this.loginForm.style.animation = '';
        }, 500);
        
        // Solo limpiar la contraseña
        this.passwordInput.value = '';
        this.passwordInput.focus();
    }
    
    setLoading(isLoading, text = '') {
        this.loginButton.disabled = isLoading;
        
        if (isLoading) {
            this.loadingSpinner.classList.add('show');
            if (text) this.buttonText.textContent = text;
        } else {
            this.loadingSpinner.classList.remove('show');
            this.buttonText.textContent = 'INGRESAR AL SISTEMA';
        }
    }
    
    showFieldError(field, message) {
        field.classList.add('error');
        window.notificationSystem.error(message, {
            title: 'Campo Requerido'
        });
        field.focus();
        
        setTimeout(() => field.classList.remove('error'), 500);
    }
    
    checkCapsLock(event) {
        const capsLockOn = event.getModifierState && event.getModifierState('CapsLock');
        
        if (capsLockOn) {
            if (!this.capsWarning.classList.contains('show')) {
                this.capsWarning.classList.add('show');
                window.notificationSystem.capsLockWarning();
            }
        } else {
            this.capsWarning.classList.remove('show');
        }
    }
    
    togglePasswordVisibility() {
        const eyeOpen = this.togglePassword.querySelector('.eye-open');
        const eyeClosed = this.togglePassword.querySelector('.eye-closed');
        
        if (this.passwordInput.type === 'password') {
            this.passwordInput.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'block';
        } else {
            this.passwordInput.type = 'password';
            eyeOpen.style.display = 'block';
            eyeClosed.style.display = 'none';
        }
    }
    
    validateInput(input) {
        input.classList.remove('error');
        
        if (input === this.emailInput) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (input.value.length > 0 && !emailRegex.test(input.value)) {
                input.classList.add('error');
            }
        }
        
        if (input === this.passwordInput) {
            if (input.value.length > 0 && input.value.length < 3) {
                input.classList.add('error');
            }
        }
    }
    
    handleKeyboard(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            if (document.activeElement === this.emailInput || 
                document.activeElement === this.passwordInput) {
                event.preventDefault();
                this.loginForm.dispatchEvent(new Event('submit'));
            }
        }
        
        if (event.key === 'Escape') {
            this.resetForm();
        }
    }
    
    handleForgotPassword(e) {
        e.preventDefault();
        window.notificationSystem.info('Para recuperar su contraseña, contacte al administrador del sistema o al departamento de TI.', {
            title: 'Recuperar Contraseña',
            duration: 8000
        });
    }
    
    showHelp(e) {
        e.preventDefault();
        window.notificationSystem.info(`
            <strong>Ayuda del Sistema:</strong><br>
            • Use su email institucional<br>
            • Su área se asignará automáticamente<br>
            • La sesión expira después de 30 minutos de inactividad<br>
            • Para soporte técnico: ext. 123<br>
            • Email: soporte@criminalistica.gob.pe
        `, {
            title: 'Ayuda y Soporte',
            duration: 10000
        });
    }
    
    startAnimations() {
        setTimeout(() => {
            const loginPanel = document.querySelector('.login-panel');
            if (loginPanel) {
                loginPanel.style.opacity = '1';
                loginPanel.style.transform = 'translateY(0) scale(1)';
            }
        }, 200);
    }
    
    resetForm() {
        this.emailInput.value = '';
        this.passwordInput.value = '';
        this.emailInput.classList.remove('error');
        this.passwordInput.classList.remove('error');
        this.buttonText.textContent = 'INGRESAR AL SISTEMA';
        this.emailInput.focus();
    }
    
    setupInactivityTimer() {
        let inactivityTimer;
        const inactivityWarningTime = 5 * 60 * 1000; // 5 minutos para advertencia
        
        const resetInactivityTimer = () => {
            clearTimeout(inactivityTimer);
            
            // Solo configurar timer si no estamos en la página de login
            if (window.location.pathname.includes('/areas/')) {
                inactivityTimer = setTimeout(() => {
                    window.notificationSystem.warning(
                        'Su sesión expirará pronto por inactividad. Realice alguna acción para continuar.',
                        {
                            title: 'Advertencia de Inactividad',
                            duration: 30000
                        }
                    );
                }, inactivityWarningTime);
            }
        };
        
        // Eventos que indican actividad del usuario
        ['mousedown', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer, true);
        });
        
        resetInactivityTimer();
    }
}

/**
 * CREAR PARTÍCULAS ANIMADAS
 */
function createParticles() {
    const background = document.querySelector('.animated-background');
    if (!background) return;
    
    const particleCount = 30;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        const size = Math.random() * 3 + 1;
        const x = Math.random() * 100;
        const delay = Math.random() * 10;
        const duration = Math.random() * 8 + 12;
        
        particle.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${x}%;
            animation-delay: ${delay}s;
            animation-duration: ${duration}s;
        `;
        
        background.appendChild(particle);
    }
}

/**
 * INICIALIZACIÓN COMPLETA
 */
document.addEventListener('DOMContentLoaded', () => {
    // Crear partículas de fondo
    createParticles();
    
    // Inicializar sistema de notificaciones
    window.notificationSystem = new ModernNotificationSystem();
    
    // Inicializar sistema de login
    window.loginSystem = new LoginSystem();
    
    // Mostrar notificación de bienvenida
    setTimeout(() => {
        window.notificationSystem.systemReady();
    }, 1500);
    
    // Mostrar notificaciones según configuración
    if (window.loginConfig) {
        if (window.loginConfig.sessionExpired) {
            window.notificationSystem.warning('Su sesión ha expirado', {
                title: 'Sesión Expirada',
                duration: 6000
            });
        }
        
        if (window.loginConfig.accessDenied) {
            window.notificationSystem.error('Acceso denegado a esa área', {
                title: 'Sin Permisos',
                duration: 6000
            });
        }
    }
    
    // Log de confirmación en modo desarrollo
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        console.log('✅ Sistema de Login Directo - Activado');
        console.log('🔧 Cambios aplicados:');
        console.log('   - Login directo con email y contraseña');
        console.log('   - Sin selección de área (automática por BD)');
        console.log('   - Token CSRF incluido en solicitudes');
        console.log('   - Redirección automática según área asignada');
        console.log('   - Timer de inactividad configurado');
    }
});

// Métodos globales de conveniencia
window.showSuccess = (message, options) => window.notificationSystem.success(message, options);
window.showError = (message, options) => window.notificationSystem.error(message, options);
window.showWarning = (message, options) => window.notificationSystem.warning(message, options);
window.showInfo = (message, options) => window.notificationSystem.info(message, options);
window.showLoading = (message, options) => window.notificationSystem.loading(message, options);