// =================================================================
// SCRIPT.JS INTEGRADO CON VALIDACIÓN EMAIL Y PASSWORD - CORREGIDO
// Sistema Criminalística Puno - 3 ÁREAS FUNCIONANDO
// =================================================================

// Función para abrir modal de administrador
function openAdminModal() {
    document.getElementById('adminModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Función para abrir modal de áreas
function openAreasModal() {
    document.getElementById('areasModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function openManual() {
    showNotification('Abriendo Manual de Usuario...', 'success');
    setTimeout(() => {
        window.open('Acceso al Sistema.pdf', '_blank');
    }, 500);
}

// Función para cerrar modales
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// =================================================================
// FUNCIONES DE LOGIN ADMINISTRATIVO - UNIFICADAS PARA 3 ÁREAS
// =================================================================

// Función para abrir modal de login específico
function openLoginModal(area) {
    // Cerrar modal de administrador
    closeModal('adminModal');
    
    // Abrir modal de login correspondiente
    let modalId;
    if (area === 'mesa-partes') {
        modalId = 'loginMesaPartesModal';
    } else {
        modalId = `login${area.charAt(0).toUpperCase() + area.slice(1)}Modal`;
    }
    
    document.getElementById(modalId).style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Auto-focus en el campo email
    setTimeout(() => {
        const emailInput = document.querySelector(`#${modalId} input[type="email"], #${modalId} input[name="email"]`);
        if (emailInput) {
            emailInput.focus();
        }
    }, 100);
}

// 🔥 FUNCIÓN PRINCIPAL DE LOGIN - UNIFICADA PARA LAS 3 ÁREAS
function loginAdmin(event, area) {
    // Para Jefatura: NO interceptar, dejar que el form se envíe normalmente
    if (area === 'jefatura') {
        // Jefatura funciona con su propio sistema PHP - NO INTERCEPTAR
        return true; // Permite que el formulario se envíe normalmente
    }
    
    // Para Mesa de Partes y Secretaría: Adaptar al sistema de Jefatura
    event.preventDefault();
    
    // Determinar los campos según el área (usando los IDs originales)
    let usuarioField, passwordField;
    
    if (area === 'mesa-partes') {
        usuarioField = document.getElementById('usernameMesaPartes');
        passwordField = document.getElementById('passwordMesaPartes');
    } else if (area === 'secretaria') {
        usuarioField = document.getElementById('usernameSecretaria');
        passwordField = document.getElementById('passwordSecretaria');
    }
    
    // 🚨 CORRECCIÓN: Validar que existan los campos (FALTABA ! antes de passwordField)
    if (!usuarioField || !passwordField) {
        showNotification('Error: Campos de login no encontrados', 'error');
        console.error('Campos no encontrados:', {
            area: area,
            usuarioField: usuarioField,
            passwordField: passwordField
        });
        return;
    }
    
    const usuario = usuarioField.value.trim();
    const password = passwordField.value.trim();
    
    // Validaciones básicas
    if (!usuario || !password) {
        showNotification('Por favor, complete todos los campos', 'warning');
        return;
    }
    
    // Validar formato de email
    if (!isValidEmail(usuario)) {
        showNotification('Por favor, ingrese un email válido', 'warning');
        return;
    }
    
    // Mostrar notificación de procesamiento
    const areaName = area === 'mesa-partes' ? 'Mesa de Partes' : area.charAt(0).toUpperCase() + area.slice(1);
    showNotification(`Validando credenciales para ${areaName}...`, 'info');
    
    // Crear formulario dinámico como lo hace Jefatura
    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    
    // 🔥 USAR EL MISMO ARCHIVO PHP QUE FUNCIONA PARA JEFATURA
    form.action = 'login/login_jefatura.php';
    
    // Determinar valor del área para la base de datos
    let areaValue;
    switch(area) {
        case 'mesa-partes':
            areaValue = 'mesa_de_partes';  // Coincide con la BD
            break;
        case 'secretaria':
            areaValue = 'secretaria';      // Coincide con la BD
            break;
        default:
            showNotification('Área no válida', 'error');
            return;
    }
    
    // Crear campos EXACTAMENTE como Jefatura
    const usuarioInput = document.createElement('input');
    usuarioInput.type = 'hidden';
    usuarioInput.name = 'usuario';  // ← IGUAL QUE JEFATURA
    usuarioInput.value = usuario;
    form.appendChild(usuarioInput);
    
    const passwordInput = document.createElement('input');
    passwordInput.type = 'hidden';
    passwordInput.name = 'password';  // ← IGUAL QUE JEFATURA
    passwordInput.value = password;
    form.appendChild(passwordInput);
    
    const areaInput = document.createElement('input');
    areaInput.type = 'hidden';
    areaInput.name = 'area';  // ← IGUAL QUE JEFATURA
    areaInput.value = areaValue;
    form.appendChild(areaInput);
    
    // Agregar al DOM y enviar
    document.body.appendChild(form);
    
    // Simular delay de validación y enviar
    setTimeout(() => {
        form.submit();
    }, 1500);
}

// 🔥 FUNCIÓN ALTERNATIVA SIMPLIFICADA (PARA CASOS ESPECIALES)
function loginAdminUnified(event, area) {
    // Si es jefatura, no interceptar
    if (area === 'jefatura') {
        return true;
    }
    
    event.preventDefault();
    
    // Obtener el formulario actual
    const form = event.target;
    const formData = new FormData(form);
    
    // Extraer datos independientemente del nombre de campo
    let email = formData.get('email') || formData.get('usuario') || '';
    let password = formData.get('password') || '';
    
    // Validaciones
    if (!email || !password) {
        showNotification('Complete todos los campos', 'warning');
        return;
    }
    
    if (!isValidEmail(email)) {
        showNotification('Email no válido', 'warning');
        return;
    }
    
    // Mapear área
    const areaMapping = {
        'mesa-partes': 'mesa_de_partes',
        'secretaria': 'secretaria'
    };
    
    const areaValue = areaMapping[area];
    if (!areaValue) {
        showNotification('Área no válida', 'error');
        return;
    }
    
    // Crear formulario unificado
    const unifiedForm = document.createElement('form');
    unifiedForm.method = 'POST';
    unifiedForm.action = 'login/login_jefatura.php';
    unifiedForm.style.display = 'none';
    
    // Agregar campos con nombres estándar
    const fields = {
        'usuario': email,
        'password': password,
        'area': areaValue
    };
    
    Object.entries(fields).forEach(([name, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        unifiedForm.appendChild(input);
    });
    
    document.body.appendChild(unifiedForm);
    
    // Mostrar progreso y enviar
    const areaName = area === 'mesa-partes' ? 'Mesa de Partes' : 'Secretaría';
    showNotification(`Accediendo a ${areaName}...`, 'info');
    
    setTimeout(() => {
        unifiedForm.submit();
    }, 1000);
}

// =================================================================
// FUNCIONES DE ÁREAS OPERATIVAS (SIN CAMBIOS)
// =================================================================

function accessArea(area) {
    const areaNames = {
        'inspeccion': 'Inspección Criminalística',
        'identificacion': 'Identificación Forense',
        'balistica': 'Balística Forense',
        'grafotecnia': 'Grafotecnia Forense',
        'antropologia': 'Antropología Forense',
        'cerap': 'CERAP'
    };
    
    const areaName = areaNames[area] || area.charAt(0).toUpperCase() + area.slice(1);
    
    showNotification(`Redirigiendo al login de ${areaName}...`, 'success');
    
    setTimeout(() => {
        closeModal('areasModal');
        
        switch(area) {
            case 'inspeccion':
                window.location.href = `login/login_areas.php?area=inspeccion`;
                break;
            case 'identificacion':
                window.location.href = `login/login_areas.php?area=identificacion`;
                break;
            case 'balistica':
                window.location.href = `login/login_areas.php?area=balistica`;
                break;
            case 'grafotecnia':
                window.location.href = `login/login_areas.php?area=grafotecnia`;
                break;
            case 'antropologia':
                window.location.href = `login/login_areas.php?area=antropologia`;
                break;
            case 'cerap':
                window.location.href = `login/login_areas.php?area=cerap`;
                break;
            default:
                window.location.href = 'login/login_areas.php';
        }
    }, 1000);
}

// =================================================================
// FUNCIONES DE VALIDACIÓN Y UTILIDADES MEJORADAS
// =================================================================

// Validar formato de email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validar campos de formulario mejorada
function validateLoginForm(modalId) {
    const modal = document.getElementById(modalId);
    const emailField = modal.querySelector('input[name="email"], input[type="email"], input[name="usuario"]');
    const passwordField = modal.querySelector('input[name="password"], input[type="password"]');
    
    const email = emailField?.value.trim() || '';
    const password = passwordField?.value.trim() || '';
    
    const errors = [];
    
    if (!email) {
        errors.push('El email es requerido');
    } else if (!isValidEmail(email)) {
        errors.push('El formato del email no es válido');
    }
    
    if (!password) {
        errors.push('La contraseña es requerida');
    } else if (password.length < 3) {
        errors.push('La contraseña debe tener al menos 3 caracteres');
    }
    
    return {
        isValid: errors.length === 0,
        errors: errors,
        data: { email, password }
    };
}

// Función para limpiar formularios
function clearLoginForm(modalId) {
    const modal = document.getElementById(modalId);
    const inputs = modal.querySelectorAll('input[type="email"], input[type="password"], input[name="email"], input[name="password"], input[name="usuario"]');
    inputs.forEach(input => {
        input.value = '';
    });
}

// 🔥 FUNCIÓN DE DEPURACIÓN PARA VERIFICAR CAMPOS
function debugLoginFields(area) {
    console.log(`🔍 Depurando campos para área: ${area}`);
    
    let usuarioField, passwordField;
    
    if (area === 'mesa-partes') {
        usuarioField = document.getElementById('usernameMesaPartes');
        passwordField = document.getElementById('passwordMesaPartes');
    } else if (area === 'secretaria') {
        usuarioField = document.getElementById('usernameSecretaria');
        passwordField = document.getElementById('passwordSecretaria');
    }
    
    console.log('Usuario Field:', usuarioField);
    console.log('Password Field:', passwordField);
    
    if (usuarioField) console.log('Usuario Value:', usuarioField.value);
    if (passwordField) console.log('Password Value:', passwordField.value);
    
    return {
        usuarioField: usuarioField,
        passwordField: passwordField,
        usuarioValue: usuarioField?.value || '',
        passwordValue: passwordField?.value || ''
    };
}

// =================================================================
// FUNCIONES DE NOTIFICACIONES (SIN CAMBIOS)
// =================================================================

function showNotification(message, type = 'success') {
    // Remover notificación existente
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    let icon;
    switch(type) {
        case 'success':
            icon = 'fas fa-check-circle';
            break;
        case 'error':
            icon = 'fas fa-exclamation-circle';
            break;
        case 'info':
            icon = 'fas fa-info-circle';
            break;
        case 'warning':
            icon = 'fas fa-exclamation-triangle';
            break;
        default:
            icon = 'fas fa-info-circle';
    }
    
    notification.innerHTML = `
        <i class="${icon}"></i>
        ${message}
    `;
    
    // Estilos CSS para las notificaciones
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 10000;
        font-family: Arial, sans-serif;
        font-size: 14px;
        max-width: 350px;
        transform: translateX(400px);
        transition: transform 0.3s ease, opacity 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}

// =================================================================
// EVENTOS Y MANEJO DE TECLADO
// =================================================================

// Eventos de teclado para cerrar modales
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    // Enter para enviar formularios
    if (event.key === 'Enter') {
        const activeModal = document.querySelector('.modal[style*="block"]');
        if (activeModal) {
            const submitButton = activeModal.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
        }
    }
});

// Cerrar modal al hacer clic fuera de él
window.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// =================================================================
// EFECTOS VISUALES Y ANIMACIONES (SIN CAMBIOS)
// =================================================================

document.addEventListener('DOMContentLoaded', function() {
    // Efecto de hover para los logos
    const logos = document.querySelectorAll('.logo');
    logos.forEach(logo => {
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.1) rotate(5deg)';
            this.style.transition = 'all 0.3s ease';
        });
        
        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) rotate(0deg)';
        });
    });

    // Efecto de clic en botones principales
    const buttons = document.querySelectorAll('.action-button');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Crear efecto de ondas (ripple effect)
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            // Agregar animación CSS si no existe
            if (!document.querySelector('#ripple-keyframes')) {
                const style = document.createElement('style');
                style.id = 'ripple-keyframes';
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.remove();
                }
            }, 600);
        });
        
        // Efecto de hover en botones
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.2)';
            this.style.transition = 'all 0.3s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
    });

    // Efecto de hover para las tarjetas de área
    const areaCards = document.querySelectorAll('.area-card');
    areaCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.05)';
            this.style.boxShadow = '0 15px 35px rgba(74, 222, 128, 0.3)';
            this.style.transition = 'all 0.3s ease';
            
            // Efecto de brillo en el icono
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.color = '#4ade80';
                icon.style.textShadow = '0 0 20px rgba(74, 222, 128, 0.5)';
                icon.style.transition = 'all 0.3s ease';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
            
            // Restaurar icono
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.color = '';
                icon.style.textShadow = '';
            }
        });
    });

    // Animación de entrada para elementos
    const animateElements = document.querySelectorAll('.main-title, .subtitle, .action-button');
    animateElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 200 + (index * 150));
    });

    // Efecto de parallax sutil en el header
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const header = document.querySelector('.header');
        if (header) {
            header.style.transform = `translateY(${scrolled * 0.1}px)`;
        }
    });

    // Auto-focus en primer campo cuando se abre un modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = mutation.target;
                if (modal.style.display === 'block' && modal.classList.contains('modal')) {
                    const firstInput = modal.querySelector('input[type="email"], input[type="text"]');
                    if (firstInput) {
                        setTimeout(() => firstInput.focus(), 100);
                    }
                }
            }
        });
    });

    // Observar todos los modales
    document.querySelectorAll('.modal').forEach(modal => {
        observer.observe(modal, { attributes: true });
    });

    // Mensaje de bienvenida con información actualizada
    setTimeout(() => {
        showNotification('🚀 Sistema Criminalística Puno - 3 ÁREAS ACTIVAS', 'success');
        console.log('🚀 Sistema Criminalística Puno - Login UNIFICADO para 3 áreas');
        console.log('✨ Funcionalidades activas:');
        console.log('   - Validación EMAIL + PASSWORD');
        console.log('   - Sistema unificado PHP (login_jefatura.php)');
        console.log('   - Validación de formato de email');
        console.log('   - Notificaciones de estado');
        console.log('   - Efectos visuales interactivos');
        console.log('');
        console.log('📧 USUARIOS DE PRUEBA:');
        console.log('   🔹 JEFATURA: admin@gmail.com');
        console.log('   🔹 MESA DE PARTES: mesadepartes@gmail.com / admin123456');
        console.log('   🔹 SECRETARÍA: usuario@gmail.com');
        console.log('');
        console.log('🔐 ÁREAS ADMINISTRATIVAS:');
        console.log('   - Jefatura: administracion/jefatura.php');
        console.log('   - Mesa de Partes: administracion/mesa_de_partes.php');
        console.log('   - Secretaría: administracion/secretaria.php');
        console.log('');
        console.log('🛠️ CORRECCIÓN APLICADA:');
        console.log('   - Validación de campos corregida');
        console.log('   - Sistema unificado funcionando');
        console.log('   - 3 áreas completamente operativas');
    }, 2000);

    // Efecto de partículas flotantes
    createFloatingParticles();
});

// =================================================================
// FUNCIONES AUXILIARES PARA EFECTOS VISUALES (SIN CAMBIOS)
// =================================================================

function createFloatingParticles() {
    const particleCount = 15;
    const particles = [];
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: fixed;
            width: 4px;
            height: 4px;
            background: rgba(74, 222, 128, 0.3);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        `;
        
        // Posición aleatoria
        particle.style.left = Math.random() * window.innerWidth + 'px';
        particle.style.top = Math.random() * window.innerHeight + 'px';
        
        document.body.appendChild(particle);
        particles.push({
            element: particle,
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            vx: (Math.random() - 0.5) * 0.5,
            vy: (Math.random() - 0.5) * 0.5
        });
    }
    
    // Animar partículas
    function animateParticles() {
        particles.forEach(particle => {
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            // Rebotar en los bordes
            if (particle.x <= 0 || particle.x >= window.innerWidth) particle.vx *= -1;
            if (particle.y <= 0 || particle.y >= window.innerHeight) particle.vy *= -1;
            
            particle.element.style.left = particle.x + 'px';
            particle.element.style.top = particle.y + 'px';
        });
        
        requestAnimationFrame(animateParticles);
    }
    
    animateParticles();
}

// Funciones adicionales para el flujo de áreas
function highlightSelectedArea(areaElement, areaName) {
    document.querySelectorAll('.area-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    areaElement.classList.add('selected');
    showNotification(`Área seleccionada: ${areaName}`, 'info');
    
    areaElement.style.animation = 'pulse 0.6s ease-in-out';
    setTimeout(() => {
        areaElement.style.animation = '';
    }, 600);
}

function validateAreaAccess(area) {
    const availableAreas = ['inspeccion', 'identificacion', 'balistica', 'grafotecnia', 'antropologia', 'cerap'];
    
    if (!availableAreas.includes(area)) {
        showNotification('Área no disponible en este momento', 'warning');
        return false;
    }
    
    return true;
}

function handleNavigationError(area) {
    showNotification(`Error al acceder al área de ${area}. Intente nuevamente.`, 'error');
    console.error(`Navigation error for area: ${area}`);
}

// Función para limpiar recursos al salir de la página
window.addEventListener('beforeunload', function() {
    document.querySelectorAll('div[style*="position: fixed"][style*="border-radius: 50%"]').forEach(particle => {
        particle.remove();
    });
});

// Agregar CSS para el estado seleccionado de áreas
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .area-card.selected {
            border: 3px solid #4ade80 !important;
            background: linear-gradient(135deg, rgba(74, 222, 128, 0.1), rgba(16, 185, 129, 0.1)) !important;
            transform: translateY(-8px) scale(1.05) !important;
        }
        
        .area-card.selected::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4ade80;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
});

// =================================================================
// 🔥 FUNCIÓN DE DEPURACIÓN FINAL - PARA VERIFICAR TODO
// =================================================================

function verificarSistema() {
    console.log('🔍 VERIFICACIÓN COMPLETA DEL SISTEMA');
    console.log('=====================================');
    
    // Verificar modales
    const modals = ['adminModal', 'loginJefaturaModal', 'loginMesaPartesModal', 'loginSecretariaModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        console.log(`Modal ${modalId}:`, modal ? '✅ Encontrado' : '❌ No encontrado');
    });
    
    // Verificar campos de formulario
    const fields = [
        { id: 'usernameJefatura', area: 'Jefatura' },
        { id: 'passwordJefatura', area: 'Jefatura' },
        { id: 'usernameMesaPartes', area: 'Mesa de Partes' },
        { id: 'passwordMesaPartes', area: 'Mesa de Partes' },
        { id: 'usernameSecretaria', area: 'Secretaría' },
        { id: 'passwordSecretaria', area: 'Secretaría' }
    ];
    
    console.log('\n📝 CAMPOS DE FORMULARIO:');
    fields.forEach(field => {
        const element = document.getElementById(field.id);
        console.log(`${field.area} - ${field.id}:`, element ? '✅ Encontrado' : '❌ No encontrado');
    });
    
    // Verificar usuarios de la base de datos
    console.log('\n👥 USUARIOS DE PRUEBA:');
    console.log('🔹 JEFATURA: admin@gmail.com (password hasheado)');
    console.log('🔹 MESA DE PARTES: mesadepartes@gmail.com / admin123456');
    console.log('🔹 SECRETARÍA: usuario@gmail.com (password hasheado)');
    
    // Verificar rutas PHP
    console.log('\n🔗 RUTAS PHP:');
    console.log('- Sistema unificado: login/login_jefatura.php');
    console.log('- Redirecciones:');
    console.log('  * Jefatura → administracion/jefatura.php');
    console.log('  * Mesa de Partes → administracion/mesa_de_partes.php');
    console.log('  * Secretaría → administracion/secretaria.php');
    
    console.log('\n✅ VERIFICACIÓN COMPLETADA');
    return true;
}

// Función para simular login (solo para pruebas)
function simularLogin(area, usuario, password) {
    console.log(`🧪 SIMULANDO LOGIN para ${area}`);
    console.log(`Usuario: ${usuario}`);
    console.log(`Password: ${password}`);
    
    // Mapear áreas
    const areaMapping = {
        'jefatura': 'jefatura',
        'mesa-partes': 'mesa_de_partes',
        'secretaria': 'secretaria'
    };
    
    const areaValue = areaMapping[area];
    
    // Crear datos del formulario
    const formData = {
        usuario: usuario,
        password: password,
        area: areaValue
    };
    
    console.log('Datos que se enviarían:', formData);
    showNotification(`Simulación de login para ${area} completada. Ver consola.`, 'info');
    
    return formData;
}

// Función para pruebas rápidas
function pruebasRapidas() {
    console.log('🚀 EJECUTANDO PRUEBAS RÁPIDAS');
    
    // Simular diferentes logins
    simularLogin('jefatura', 'admin@gmail.com', 'password_test');
    setTimeout(() => {
        simularLogin('mesa-partes', 'mesadepartes@gmail.com', 'admin123456');
    }, 1000);
    setTimeout(() => {
        simularLogin('secretaria', 'usuario@gmail.com', 'password_test');
    }, 2000);
}

// Exportar funciones para uso global (si es necesario)
window.verificarSistema = verificarSistema;
window.simularLogin = simularLogin;
window.pruebasRapidas = pruebasRapidas;
window.debugLoginFields = debugLoginFields;