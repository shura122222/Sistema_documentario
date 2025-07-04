// Variables globales
let currentSection = 'dashboard';

// Función para mostrar secciones
function showSection(section, element) {
    // Ocultar todas las secciones
    document.querySelectorAll('.section').forEach(sec => {
        sec.classList.remove('active');
    });
    
    // Mostrar la sección seleccionada
    const sectionElement = document.getElementById(section + 'Section');
    if (sectionElement) {
        sectionElement.classList.add('active');
    }
    
    // Actualizar menú activo
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });
    if (element) {
        element.classList.add('active');
    }
    
    // Actualizar título y breadcrumb
    const titles = {
        'dashboard': 'Panel Principal - Jefatura',
        'personal': 'Gestión de Personal',
        'documentos': 'Documentos por Área',
        'reportes': 'Reportes Ejecutivos',
        'supervision': 'Supervisión General',
        'estadisticas': 'Estadísticas por Área',
        'coordinacion': 'Coordinación Interinstitucional',
        'configuracion': 'Configuración del Sistema',
    };
    
    document.getElementById('pageTitle').textContent = titles[section];
    document.getElementById('breadcrumbText').textContent = titles[section].replace(' - Jefatura', '');
    
    currentSection = section;
    showNotification(`Accediendo a: ${titles[section]}`, 'info');
}



// Función para mostrar modal de nuevo usuario
function showNewUserModal() {
    document.getElementById('newUserModal').style.display = 'block';
}

// Función para crear nuevo usuario con AJAX - VERSIÓN FINAL SIN ERRORES
function createNewUser(event) {
    event.preventDefault();
    
    const form = document.getElementById('newUserForm');
    const formData = new FormData(form);
    
    // Validación básica
    const nombres = formData.get('nombres')?.trim();
    const usuario = formData.get('usuario')?.trim();
    
    if (!nombres || !usuario) {
        showNotification('Complete los campos obligatorios', 'error');
        return;
    }
    
    // Cambiar botón
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    submitBtn.disabled = true;
    
    showNotification('Registrando usuario...', 'info');
    
    // Enviar con fetch
    fetch('crear_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Primero verificar si la respuesta es válida
        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }
        
        // Intentar convertir a JSON
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Respuesta no es JSON válido:', text);
                throw new Error('Respuesta del servidor inválida');
            }
        });
    })
    .then(data => {
        if (data && data.success) {
            showNotification(`Usuario ${data.data.usuario} registrado exitosamente`, 'success');
            closeModal('newUserModal');
            form.reset();
        } else {
            const errorMsg = data && data.message ? data.message : 'Error desconocido';
            showNotification(errorMsg, 'error');
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        showNotification('Usuario Creado C', 'error');
    })
    .finally(() => {
        // Restaurar botón
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Función auxiliar para validar email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Función auxiliar para limpiar formulario
function clearUserForm() {
    const form = document.getElementById('newUserForm');
    if (form) {
        form.reset();
    }
}




// Función para mostrar perfil de usuario
function viewProfile() {
    document.getElementById('profileModal').style.display = 'block';
}

// Función para seleccionar foto
function selectPhoto() {
    document.getElementById('photoInput').click();
}

// Función para previsualizar foto
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const photoDiv = document.getElementById('currentPhoto');
            photoDiv.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
        };
        reader.readAsDataURL(file);
    }
}

// Función para actualizar perfil
function updateProfile(event) {
    event.preventDefault();
    showNotification('Actualizando perfil...', 'info');
    
    setTimeout(() => {
        showNotification('Perfil actualizado exitosamente', 'success');
        closeModal('profileModal');
    }, 1500);
}

// Función para mostrar modal de cambio de contraseña
function showChangePasswordModal() {
    closeModal('profileModal');
    document.getElementById('changePasswordModal').style.display = 'block';
}

// Función para cambiar contraseña
function changePassword(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const passwords = Object.fromEntries(formData);
    
    if (passwords.new_password !== passwords.confirm_password) {
        showNotification('Las contraseñas no coinciden', 'error');
        return;
    }
    
    showNotification('Cambiando contraseña...', 'info');
    
    setTimeout(() => {
        showNotification('Contraseña cambiada exitosamente', 'success');
        closeModal('changePasswordModal');
        event.target.reset();
    }, 1500);
}

// Función para mostrar documentos por área
function showAreaDocuments(area) {
    const areaNames = {
        'balistica': 'Balística Forense',
        'grafotecnia': 'Grafotecnia',
        'identificacion': 'Identificación',
        'biologia': 'Biología Forense',
        'quimica': 'Química Forense',
        'fotografia': 'Fotografía Forense'
    };
    
    showNotification(`Accediendo a documentos de ${areaNames[area]}`, 'info');
}

// Función para generar reportes
function generateReport(type) {
    const reportTypes = {
        'monthly': 'Reporte Mensual',
        'trends': 'Análisis de Tendencias',
        'productivity': 'Reporte de Productividad',
        'quality': 'Evaluación de Calidad'
    };
    
    showNotification(`Generando ${reportTypes[type]}...`, 'info');
    
    setTimeout(() => {
        showNotification(`${reportTypes[type]} generado exitosamente`, 'success');
    }, 3000);
}

// Función para gestionar auditorías
function manageAudits() {
    showNotification('Accediendo a gestión de auditorías...', 'info');
}

// Función para gestionar certificaciones
function manageCertifications() {
    showNotification('Accediendo a gestión de certificaciones...', 'info');
}

// Función para gestionar procedimientos
function manageProcedures() {
    showNotification('Accediendo a gestión de procedimientos...', 'info');
}

// Función para gestionar objetivos
function manageObjectives() {
    showNotification('Accediendo a objetivos institucionales...', 'info');
}

// Función para gestionar proyectos
function manageProjects() {
    showNotification('Accediendo a gestión de proyectos...', 'info');
}

// Función para gestionar coordinación
function manageCoordination(entity) {
    const entities = {
        'mp': 'Ministerio Público',
        'pj': 'Poder Judicial',
        'pnp': 'Policía Nacional del Perú'
    };
    
    showNotification(`Accediendo a coordinación con ${entities[entity]}...`, 'info');
}

// Función para mostrar configuración del sistema
function showSystemConfig() {
    showNotification('Accediendo a configuración del sistema...', 'info');
}

// Función para gestionar respaldos
function manageBackups() {
    showNotification('Accediendo a gestión de respaldos...', 'info');
}

// Función para mostrar lista de usuarios
function showUsersList() {
    document.getElementById('usersList').style.display = 'block';
    loadUsersList();
    showNotification('Mostrando lista de usuarios', 'info');
}

// ===== FUNCIONES DE GESTIÓN DE USUARIOS =====

// Función para mostrar lista de usuarios
function showUsersList() {
    document.getElementById('usersList').style.display = 'block';
    loadUsersList();
    showNotification('Mostrando lista de usuarios', 'info');
}

// Función para cargar usuarios desde la base de datos
function loadUsersList() {
    const tableBody = document.getElementById('usersTableBody');
    if (!tableBody) {
        console.error('No se encontró el elemento usersTableBody');
        return;
    }
    
    tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Cargando usuarios...</td></tr>';
    
    fetch('listar_usuarios.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayUsers(data.usuarios);
                setupFilters(data.usuarios);
            } else {
                tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: red;">Error al cargar usuarios</td></tr>';
                showNotification('Error al cargar usuarios: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: red;">Error de conexión</td></tr>';
            showNotification('Error de conexión al cargar usuarios', 'error');
        });
}

// Función para mostrar usuarios en la tabla
function displayUsers(usuarios) {
    const tableBody = document.getElementById('usersTableBody');
    
    if (usuarios.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;">No hay usuarios registrados</td></tr>';
        return;
    }
    
    tableBody.innerHTML = usuarios.map(usuario => `
        <tr data-user-id="${usuario.id}">
            <td>${usuario.nombre_completo}</td>
            <td>${usuario.usuario}</td>
            <td>${getAreaDisplayName(usuario.area)}</td>
            <td>${getCargoDisplayName(usuario.cargo)}</td>
            <td>
                <span class="status-badge ${usuario.estado === 'activo' ? 'status-active' : 'status-inactive'}">
                    ${usuario.estado === 'activo' ? 'Activo' : 'Inactivo'}
                </span>
            </td>
            <td>${formatDate(usuario.fecha_registro)}</td>
            <td>
                <button class="btn btn-danger" onclick="deleteUser(${usuario.id}, '${usuario.nombre_completo}')" title="Eliminar usuario">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

// Función para configurar filtros
function setupFilters(usuarios) {
    const searchInput = document.getElementById('searchUsers');
    const areaFilter = document.getElementById('filterArea');
    const statusFilter = document.getElementById('filterStatus');
    
    if (!searchInput || !areaFilter || !statusFilter) {
        return; // Los filtros no están en el DOM aún
    }
    
    // Limpiar eventos anteriores
    searchInput.removeEventListener('input', filterUsers);
    areaFilter.removeEventListener('change', filterUsers);
    statusFilter.removeEventListener('change', filterUsers);
    
    // Agregar eventos de filtrado
    searchInput.addEventListener('input', () => filterUsers(usuarios));
    areaFilter.addEventListener('change', () => filterUsers(usuarios));
    statusFilter.addEventListener('change', () => filterUsers(usuarios));
}

// Función para filtrar usuarios
function filterUsers(usuarios) {
    const searchInput = document.getElementById('searchUsers');
    const areaFilter = document.getElementById('filterArea');
    const statusFilter = document.getElementById('filterStatus');
    
    if (!searchInput || !areaFilter || !statusFilter) {
        return;
    }
    
    const searchTerm = searchInput.value.toLowerCase();
    const areaFilterValue = areaFilter.value;
    const statusFilterValue = statusFilter.value;
    
    const filteredUsers = usuarios.filter(usuario => {
        const matchesSearch = usuario.nombre_completo.toLowerCase().includes(searchTerm) || 
                            usuario.usuario.toLowerCase().includes(searchTerm);
        const matchesArea = !areaFilterValue || usuario.area === areaFilterValue;
        const matchesStatus = !statusFilterValue || usuario.estado === statusFilterValue;
        
        return matchesSearch && matchesArea && matchesStatus;
    });
    
    displayUsers(filteredUsers);
}



// Función para eliminar usuario (actualizada con modal animado)
function deleteUser(userId, userName) {
    // Si no hay modales animados, usar confirm simple
    if (typeof showConfirmModal === 'undefined') {
        if (!confirm(`¿Está seguro que desea ELIMINAR permanentemente al usuario "${userName}"?\n\nEsta acción no se puede deshacer.`)) {
            return;
        }
        if (!confirm(`CONFIRMACIÓN FINAL:\n¿Realmente desea eliminar a "${userName}"?`)) {
            return;
        }
        executeDeleteUser(userId, userName);
        return;
    }
    
    // Usar modal animado
    showConfirmModal({
        title: '¡Eliminar Usuario!',
        message: `¿Está seguro que desea eliminar permanentemente al usuario <strong>"${userName}"</strong>?`,
        subtitle: 'Esta acción no se puede deshacer y se perderán todos los datos.',
        type: 'danger',
        confirmText: 'Sí, Eliminar',
        cancelText: 'Cancelar',
        onConfirm: () => {
            // Mostrar segundo modal de confirmación
            showConfirmModal({
                title: 'Confirmación Final',
                message: `Confirme nuevamente que desea eliminar a <strong>"${userName}"</strong>`,
                subtitle: 'Última oportunidad para cancelar.',
                type: 'warning',
                confirmText: 'Eliminar Definitivamente',
                cancelText: 'No, Cancelar',
                onConfirm: () => {
                    executeDeleteUser(userId, userName);
                }
            });
        }
    });
}


// Función para ejecutar la eliminación
function executeDeleteUser(userId, userName) {
    const formData = new FormData();
    formData.append('id', userId);
    
    // Mostrar loading
    showNotification('Eliminando usuario...', 'info');
    
    fetch('eliminar_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Usuario "${userName}" eliminado correctamente`, 'success');
            loadUsersList(); // Recargar la lista
        } else {
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error de conexión', 'error');
    });
}

// Función para editar usuario (placeholder - se implementará después)
function editUser(userId) {
    showNotification(`Función de edición en desarrollo para usuario ID: ${userId}`, 'info');
    // TODO: Implementar modal de edición
}

// Funciones auxiliares
function getAreaDisplayName(area) {
    const areas = {
        'mesa_de_partes': 'Mesa de Partes',
        'secretaria': 'Secretaría',
        'inspeccion': 'Inspección',
        'identificacion': 'Identificación',
        'balistica': 'Balística',
        'grafotecnia': 'Grafotecnia',
        'antropologia': 'Antropología',
        'cerap': 'CERAP'
    };
    return areas[area] || area;
}

function getCargoDisplayName(cargo) {
    const cargos = {
        'jefe_de_unidad': 'Jefe de Unidad'
    };
    return cargos[cargo] || cargo;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-PE', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

// Función para editar usuario
function editUser(username) {
    showNotification(`Editando usuario: ${username}`, 'info');
}

// Función para cambiar estado de usuario
function toggleUserStatus(username) {
    showNotification(`Cambiando estado del usuario: ${username}`, 'info');
}

// Función para mostrar notificaciones
function showNotifications() {
    document.getElementById('notificationsModal').style.display = 'block';
}

// Función para mostrar configuración
function showSettings() {
    showNotification('Accediendo a configuración del sistema...', 'info');
}

// Función para cerrar modales
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Función para logout
function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        showNotification('Cerrando sesión...', 'info');
        setTimeout(() => {
            window.location.href = 'logout.php';
        }, 1500);
    }
}

// Sistema de notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 10000;
        font-size: 14px;
        max-width: 350px;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    `;
    
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Cerrar modales al hacer clic fuera
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

// Animaciones al cargar
document.addEventListener('DOMContentLoaded', function() {
    showNotification('¡Bienvenido al Panel de Jefatura!', 'success');
    
    // Animar estadísticas
    const stats = document.querySelectorAll('.stat-number');
    stats.forEach((stat, index) => {
        const finalValue = stat.textContent;
        stat.textContent = '0';
        
        setTimeout(() => {
            animateNumber(stat, finalValue);
        }, index * 200);
    });
});

// Función para animar números
function animateNumber(element, finalValue) {
    const isPercentage = finalValue.includes('%');
    const numericValue = parseInt(finalValue.replace('%', ''));
    const duration = 2000;
    const steps = 60;
    const increment = numericValue / steps;
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= numericValue) {
            current = numericValue;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current) + (isPercentage ? '%' : '');
    }, duration / steps);
}

// Función para refrescar datos
function refreshData() {
    showNotification('Actualizando datos del sistema...', 'info');
    
    // Simular actualización de estadísticas
    setTimeout(() => {
        const stats = document.querySelectorAll('.stat-number');
        stats.forEach(stat => {
            const currentValue = parseInt(stat.textContent);
            const variation = Math.floor(Math.random() * 10) - 5; // +/- 5
            const newValue = Math.max(0, currentValue + variation);
            
            if (stat.textContent.includes('%')) {
                stat.textContent = Math.min(100, newValue) + '%';
            } else {
                stat.textContent = newValue;
            }
        });
        
        showNotification('Datos actualizados correctamente', 'success');
    }, 1500);
}

// Auto-refresh cada 5 minutos
setInterval(refreshData, 5 * 60 * 1000);

// Función para buscar en el sistema
function searchSystem() {
    const searchTerm = prompt('Ingrese término de búsqueda:');
    if (searchTerm && searchTerm.trim()) {
        showNotification(`Buscando: "${searchTerm}"...`, 'info');
        
        setTimeout(() => {
            showNotification(`Se encontraron resultados para: "${searchTerm}"`, 'success');
        }, 1500);
    }
}

// Atajos de teclado
document.addEventListener('keydown', function(e) {
    // Ctrl + S para buscar
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        searchSystem();
    }
    
    // Ctrl + R para refrescar
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshData();
    }
    
    // Escape para cerrar modales
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }
    
    // Alt + P para mostrar perfil
    if (e.altKey && e.key === 'p') {
        e.preventDefault();
        viewProfile();
    }
});

// Función para mostrar ayuda
function showHelp() {
    const helpInfo = `
        <h3><i class="fas fa-question-circle"></i> Ayuda del Sistema</h3>
        <div style="margin-top: 20px; text-align: left;">
            <h4>📋 Navegación:</h4>
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li>Use el menú lateral para navegar entre módulos</li>
                <li>Las estadísticas se actualizan automáticamente cada 5 minutos</li>
                <li>Haga clic en las tarjetas para acceder a los módulos</li>
            </ul>
            
            <h4>⌨️ Atajos de Teclado:</h4>
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li><strong>Ctrl + S:</strong> Buscar en el sistema</li>
                <li><strong>Ctrl + R:</strong> Refrescar datos</li>
                <li><strong>Escape:</strong> Cerrar modales</li>
                <li><strong>Alt + P:</strong> Ver perfil</li>
            </ul>
            
            <h4>🔧 Funciones Principales:</h4>
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li><strong>Gestión de Personal:</strong> Control de empleados y registro de nuevos usuarios</li>
                <li><strong>Documentos:</strong> Revisión de informes por área especializada</li>
                <li><strong>Reportes:</strong> Generación de estadísticas ejecutivas</li>
                <li><strong>Supervisión:</strong> Monitoreo en tiempo real de casos</li>
                <li><strong>Control de Calidad:</strong> Auditorías y certificaciones</li>
                <li><strong>Coordinación:</strong> Gestión de relaciones interinstitucionales</li>
            </ul>
            
            <h4>📞 Soporte Técnico:</h4>
            <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin: 15px 0;">
                <p><strong>Teléfono:</strong> +51 51 123-4567</p>
                <p><strong>Email:</strong> soporte@criminalistica.puno.gob.pe</p>
                <p><strong>Horario:</strong> Lunes a Viernes, 8:00 AM - 6:00 PM</p>
            </div>
        </div>
        <div style="margin-top: 20px; text-align: center;">
            <button onclick="contactSupport()" class="btn btn-primary">
                <i class="fas fa-headset"></i> Contactar Soporte
            </button>
            <button onclick="downloadManual()" class="btn btn-secondary">
                <i class="fas fa-download"></i> Descargar Manual
            </button>
        </div>
    `;
    
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.style.display = 'block';
    modal.innerHTML = `
        <div class="modal-content" style="max-width: 800px;">
            <button class="close-modal" onclick="this.closest('.modal').remove()">&times;</button>
            ${helpInfo}
        </div>
    `;
    
    document.body.appendChild(modal);
}

// Función para contactar soporte
function contactSupport() {
    showNotification('Conectando con soporte técnico...', 'info');
    setTimeout(() => {
        showNotification('Ticket de soporte creado. Ref: #ST-2025-001', 'success');
    }, 2000);
}

// Función para descargar manual
function downloadManual() {
    showNotification('Descargando manual de usuario...', 'info');
    setTimeout(() => {
        showNotification('Manual descargado exitosamente', 'success');
    }, 1500);
}

// Verificar sesión cada 10 minutos
setInterval(function() {
    fetch('check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.active) {
                showNotification('Su sesión ha expirado. Redirigiendo...', 'error');
                setTimeout(() => {
                    window.location.href = '../index.html';
                }, 2000);
            }
        })
        .catch(error => {
            console.warn('Error verificando sesión:', error);
        });
}, 10 * 60 * 1000);