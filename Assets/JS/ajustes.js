document.addEventListener('DOMContentLoaded', async function() {
    // Cargar historial inmediatamente
    await actualizarHistorialBackups();

    // Manejar el formulario de backup
    const backupForm = document.getElementById('backupForm');
    if (backupForm) {
        backupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const passwordInput = this.querySelector('#backupPassword');
            const password = passwordInput.value;

            if (!password) {
                mostrarMensaje('error', 'Debe ingresar la contraseña');
                return;
            }

            try {
                const response = await realizarOperacion('crear_backup', {
                    password
                });

                if (response.success) {
                    mostrarMensaje('success', response.message);
                    await actualizarHistorialBackups();
                    
                    // Limpiar y cerrar modal
                    passwordInput.value = '';
                    const modal = bootstrap.Modal.getInstance(document.getElementById('backupModal'));
                    if (modal) {
                        modal.hide();
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('error', error.message);
            }
        });
    }

    // Manejar formulario de restauración
    const restaurarForm = document.getElementById('restaurarForm');
    if (restaurarForm) {
        restaurarForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const password = this.querySelector('input[name="password"]').value;
            const fileInput = this.querySelector('input[name="backup_file"]');

            if (!fileInput.files[0]) {
                mostrarMensaje('error', 'Debe seleccionar un archivo');
                return;
            }

            if (!password) {
                mostrarMensaje('error', 'Debe ingresar la contraseña');
                return;
            }

            try {
                const result = await Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Esta acción restaurará el sistema a una versión anterior. Los datos actuales serán reemplazados.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#BBCD5D',
                    cancelButtonColor: '#3C4046',
                    confirmButtonText: 'Sí, restaurar',
                    cancelButtonText: 'Cancelar'
                });

                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('tipo', 'restaurar_backup'); // Agregar tipo a FormData
                    formData.append('password', password);
                    formData.append('backup_file', fileInput.files[0]);

                    try {
                        const data = await realizarOperacion('restaurar_backup', formData, true); // Usar true para FormData
                        
                        if (data.success) {
                            await Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Sistema restaurado correctamente',
                                confirmButtonColor: '#BBCD5D'
                            });

                            // Cerrar modal y limpiar formulario
                            const modal = bootstrap.Modal.getInstance(document.getElementById('restaurarModal'));
                            modal.hide();
                            this.reset();

                            // Recargar página después de 2 segundos
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        mostrarMensaje('error', error.message);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje('error', error.message);
            }
        });
    }

    // Agregar el evento para el formulario de restablecer
    const restablecerForm = document.getElementById('restablecerForm');
    if (restablecerForm) {
        restablecerForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const confirmacionInput = this.querySelector('input[pattern="RESTABLECER"]');
            const passwordInput = this.querySelector('input[type="password"]');

            if (confirmacionInput.value !== 'RESTABLECER') {
                mostrarMensaje('error', 'Debe escribir RESTABLECER para confirmar');
                return;
            }

            if (!passwordInput.value) {
                mostrarMensaje('error', 'Debe ingresar la contraseña');
                return;
            }

            try {
                await confirmarRestablecer(confirmacionInput, passwordInput);
            } catch (error) {
                mostrarMensaje('error', error.message);
            }
        });
    }
});

// Definir colores del tema
const COLORS = {
    primary: '#BBCD5D',
    secondary: '#3C4046',
    danger: '#DC3545'
};

// Función para realizar operaciones con el backend
async function realizarOperacion(tipo, datos, isFormData = false) {
    try {
        console.log('Enviando operación:', { tipo, datos });

        const options = {
            method: 'POST'
        };

        if (isFormData) {
            // Si es FormData, usamos directamente los datos
            options.body = datos;
        } else {
            // Si no es FormData, convertimos a JSON
            options.body = JSON.stringify({ tipo, ...datos });
            options.headers = {
                'Content-Type': 'application/json'
            };
        }

        const response = await fetch('../Modules/AjustesAdmin/sistema_admin.php', options);
        const rawResponse = await response.text();
        console.log('Respuesta del servidor:', rawResponse);

        let result;
        try {
            result = JSON.parse(rawResponse);
        } catch (e) {
            console.error('Error al parsear respuesta:', rawResponse);
            throw new Error('Respuesta inválida del servidor');
        }

        if (!response.ok) {
            throw new Error(result.message || `Error del servidor: ${response.status}`);
        }

        if (!result.success) {
            throw new Error(result.message || 'La operación falló');
        }

        return result;
    } catch (error) {
        console.error('Error en operación:', error);
        throw error;
    }
}

// Función para actualizar la tabla de historial
async function actualizarHistorialBackups() {
    try {
        const response = await realizarOperacion('obtener_historial', {});
        const tabla = document.querySelector('#backupHistoryBody');
        
        if (!tabla) {
            console.error('Tabla no encontrada');
            return;
        }

        // Limpiar tabla existente
        tabla.innerHTML = '';

        if (!response.success) {
            throw new Error(response.message || 'Error al obtener historial');
        }

        const historial = response.data || [];

        if (historial.length === 0) {
            tabla.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        <em>No hay copias de seguridad disponibles</em>
                    </td>
                </tr>`;
            return;
        }

        tabla.innerHTML = historial.map(backup => `
            <tr>
                <td>${new Date(backup.fecha).toLocaleString('es-MX')}</td>
                <td>${formatBytes(backup.tamanho)}</td>
                <td>${backup.usuario}</td>
                <td><span class="badge bg-success">Completo</span></td>
                <td>
                    <div class="btn-group">
                        <button type="button" 
                                class="btn btn-sm btn-primary" 
                                onclick="descargarBackup('${backup.archivo}')"
                                title="Descargar backup">
                            <i class="fas fa-download"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-danger" 
                                onclick="eliminarBackup(${backup.id})"
                                title="Eliminar backup">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');

    } catch (error) {
        console.error('Error:', error);
        mostrarMensaje('error', 'Error al actualizar el historial');
    }
}

async function crearBackup(password) {
    try {
        const response = await realizarOperacion('crear_backup', { password });
        if (response.success) {
            mostrarMensaje('success', response.message);
            await actualizarHistorialBackups();
        }
    } catch (error) {
        mostrarMensaje('error', error.message);
    }
}

async function eliminarBackup(id) {
    try {
        const result = await Swal.fire({
            title: '¿Eliminar backup?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: COLORS.danger,
            cancelButtonColor: COLORS.secondary,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            const response = await realizarOperacion('eliminar_backup', { id });
            
            if (response.success) {
                await actualizarHistorialBackups();
                mostrarMensaje('success', 'Backup eliminado correctamente');
            }
        }
    } catch (error) {
        mostrarMensaje('error', error.message);
    }
}

async function descargarBackup(archivo) {
    try {
        const response = await realizarOperacion('descargar_backup', { archivo });
        
        if (response.success) {
            mostrarMensaje('success', 'Preparando descarga...', 1500);
            
            setTimeout(() => {
                const link = document.createElement('a');
                link.href = response.data.ruta;
                link.download = response.data.archivo;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, 500);
        }
    } catch (error) {
        mostrarMensaje('error', error.message);
    }
}

// Función para mostrar mensajes
function mostrarMensaje(tipo, mensaje, timer = undefined) {
    const config = {
        icon: tipo,
        title: tipo === 'success' ? 'Éxito' : 'Error',
        text: mensaje,
        confirmButtonColor: tipo === 'success' ? COLORS.primary : COLORS.danger,
        cancelButtonColor: COLORS.secondary,
        timer: tipo === 'success' ? (timer || 2000) : undefined,
        timerProgressBar: tipo === 'success',
        customClass: {
            confirmButton: `btn-${tipo === 'success' ? 'success' : 'danger'}`,
            cancelButton: 'btn-secondary'
        }
    };

    return Swal.fire(config);
}

// Actualizar el estilo de los modales
document.addEventListener('DOMContentLoaded', function() {
    // Agregar estilos personalizados
    const style = document.createElement('style');
    style.textContent = `
        .swal2-popup .swal2-styled.swal2-confirm {
            background-color: ${COLORS.primary} !important;
        }
        .swal2-popup .swal2-styled.swal2-cancel {
            background-color: ${COLORS.secondary} !important;
        }
        .swal2-popup .swal2-styled.swal2-confirm.btn-danger {
            background-color: ${COLORS.danger} !important;
        }
        .modal .btn-primary {
            background-color: ${COLORS.primary};
            border-color: ${COLORS.primary};
        }
        .modal .btn-secondary {
            background-color: ${COLORS.secondary};
            border-color: ${COLORS.secondary};
        }
        .modal .btn-danger {
            background-color: ${COLORS.danger};
            border-color: ${COLORS.danger};
        }
    `;
    document.head.appendChild(style);
});

// Función auxiliar para formatear bytes
function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

async function confirmarRestablecer(confirmacionInput, passwordInput) {
    const result = await Swal.fire({
        title: '¿Está completamente seguro?',
        html: `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Esta acción eliminará <strong>TODOS</strong> los datos y restablecerá el sistema 
                a su estado inicial. Esta acción no se puede deshacer.
            </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC3545',
        cancelButtonColor: '#3C4046',
        confirmButtonText: 'Sí, restablecer sistema',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        try {
            const response = await realizarOperacion('restablecer_sistema', {
                confirmacion: confirmacionInput.value,
                password: passwordInput.value
            });

            if (response.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Sistema Restablecido',
                    text: 'El sistema ha sido restablecido correctamente',
                    confirmButtonColor: '#BBCD5D',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                // Cerrar sesión y redireccionar al login
                try {
                    await fetch('../Modules/Login/cerrar_sesion.php');
                } catch (error) {
                    console.error('Error al cerrar sesión:', error);
                }

                // Redireccionar a la página de login principal
                window.top.location.href = '../index.php';
            } 
        } catch (error) {
            console.error('Error:', error);
            mostrarMensaje('error', error.message);
        }
    }
}