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

// Función para abrir manual
function openManual() {
    showNotification('Abriendo Manual de Usuario...', 'success');
    setTimeout(() => {
        window.open('data:text/html,<html><head><title>Manual de Usuario</title></head><body style="font-family: Arial; padding: 20px; background: #f0f0f0;"><h1>📖 Manual de Usuario - Sistema Criminalística Puno</h1><h2>Instrucciones de Uso:</h2><ul><li><strong>Administrador:</strong> Acceso para jefatura, mesa de partes y secretaría</li><li><strong>Áreas:</strong> Acceso a diferentes departamentos forenses</li><li><strong>Manual:</strong> Esta guía de usuario</li></ul><h3>Áreas Administrativas:</h3><ul><li><strong>Jefatura:</strong> Gestión ejecutiva y supervisión</li><li><strong>Mesa de Partes:</strong> Gestión de documentos y trámites</li><li><strong>Secretaría:</strong> Administración y apoyo ejecutivo</li></ul><p>Para más información, contacte al administrador del sistema.</p></body></html>', '_blank');
    }, 500);
}

// Función para cerrar modales
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.body.style.overflow = 'auto';
}

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
}

// Función de login para administradores - REDIRECCIÓN DIRECTA
function loginAdmin(event, area) {
    event.preventDefault();
    
    // Mostrar notificación de acceso
    const areaName = area === 'mesa-partes' ? 'Mesa de Partes' : area.charAt(0).toUpperCase() + area.slice(1);
    showNotification(`Accediendo a ${areaName}...`, 'success');
    
    // Redirección directa después de un breve delay
    setTimeout(() => {
        switch(area) {
            case 'jefatura':
                window.location.href = 'administracion/jefatura.php';
                break;
            case 'mesa-partes':
                window.location.href = 'administracion/mesa_de_partes.php';
                break;
            case 'secretaria':
                window.location.href = 'administracion/secretaria.php';
                break;
        }
    }, 1500);
}

// Función para acceder a áreas (sin login)
function accessArea(area) {
    showNotification(`Accediendo al área de ${area.charAt(0).toUpperCase() + area.slice(1)}...`, 'success');
    setTimeout(() => {
        closeModal('areasModal');
        
        switch(area) {
            case 'inspeccion':
                window.location.href = 'areas/inspeccion.php';
                break;
            case 'identificacion':
                window.location.href = 'areas/identificacion.php';
                break;
            case 'balistica':
                window.location.href = 'areas/balistica.php';
                break;
            case 'grafotecnia':
                window.location.href = 'areas/grafotecnia.php';
                break;
            case 'antropologia':
                window.location.href = 'areas/antropologia.php';
                break;
            case 'cerap':
                window.location.href = 'areas/cerap.php';
                break;
        }
    }, 1000);
}

// Función para mostrar notificaciones con estilos mejorados
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
    
    // Enter para enviar formularios (mantener funcionalidad)
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

// Efectos de interacción mejorados
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

    // Auto-focus en primer campo de usuario cuando se abre un modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = mutation.target;
                if (modal.style.display === 'block' && modal.classList.contains('modal')) {
                    const firstInput = modal.querySelector('input[type="text"]');
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

    // Mensaje de bienvenida con efectos
    setTimeout(() => {
        showNotification('🚀 Sistema Criminalística Puno cargado correctamente', 'success');
        console.log('🚀 Sistema Criminalística Puno - Modo Presentación');
        console.log('✨ Funcionalidades activas:');
        console.log('   - Efectos visuales interactivos');
        console.log('   - Animaciones de hover y clic');
        console.log('   - Notificaciones animadas');
        console.log('   - Navegación directa a páginas');
        console.log('   - Efectos de paralaje');
        console.log('   - Animaciones de entrada');
        console.log('');
        console.log('🎨 EFECTOS VISUALES:');
        console.log('   - Ripple effect en botones');
        console.log('   - Hover animations en tarjetas');
        console.log('   - Parallax scrolling en header');
        console.log('   - Auto-focus en modales');
        console.log('   - Transiciones suaves');
    }, 2000);

    // Efecto de partículas flotantes (opcional)
    createFloatingParticles();
});

// Función para crear partículas flotantes decorativas
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

// Función para limpiar recursos al salir de la página
window.addEventListener('beforeunload', function() {
    // Limpiar partículas
    document.querySelectorAll('div[style*="position: fixed"][style*="border-radius: 50%"]').forEach(particle => {
        particle.remove();
    });
});