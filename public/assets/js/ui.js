/**
 * UI.js - Módulo para interacciones visuales y componentes de interfaz
 * Sistema de Rifas Chile
 */

class RifasUI {
    constructor() {
        this.init();
    }

    init() {
        this.initModals();
        this.initToasts();
        this.initDropdowns();
        this.initNotifications();
        this.initFormEnhancements();
        this.initTooltips();
    }

    // Gestión de Modales
    initModals() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-modal-open]')) {
                const modalId = e.target.getAttribute('data-modal-open');
                this.openModal(modalId);
            }

            if (e.target.matches('[data-modal-close]') || e.target.matches('.modal-overlay')) {
                this.closeModal();
            }
        });

        // Cerrar modal con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Animación de entrada
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.style.transform = 'scale(0.9)';
                content.style.opacity = '0';
                
                requestAnimationFrame(() => {
                    content.style.transition = 'all 0.3s ease';
                    content.style.transform = 'scale(1)';
                    content.style.opacity = '1';
                });
            }
        }
    }

    closeModal() {
        const openModal = document.querySelector('.modal-overlay:not(.hidden)');
        if (openModal) {
            const content = openModal.querySelector('.modal-content');
            
            if (content) {
                content.style.transition = 'all 0.3s ease';
                content.style.transform = 'scale(0.9)';
                content.style.opacity = '0';
                
                setTimeout(() => {
                    openModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            } else {
                openModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
    }

    // Sistema de Toasts/Notificaciones
    initToasts() {
        this.toastContainer = this.createToastContainer();
    }

    createToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(container);
        }
        return container;
    }

    showToast(message, type = 'info', duration = 5000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} p-4 text-white`;
        
        const iconMap = {
            success: '✓',
            error: '✗',
            warning: '⚠',
            info: 'ℹ'
        };

        toast.innerHTML = `
            <div class="flex items-center">
                <span class="text-lg mr-2">${iconMap[type] || iconMap.info}</span>
                <span>${message}</span>
                <button class="ml-auto text-white hover:text-gray-300" onclick="this.parentElement.parentElement.remove()">
                    ✕
                </button>
            </div>
        `;

        this.toastContainer.appendChild(toast);

        // Auto-remove
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }
        }, duration);
    }

    // Dropdowns
    initDropdowns() {
        document.addEventListener('click', (e) => {
            // Cerrar todos los dropdowns
            if (!e.target.matches('[data-dropdown-toggle]')) {
                document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }

            // Toggle dropdown específico
            if (e.target.matches('[data-dropdown-toggle]')) {
                const dropdownId = e.target.getAttribute('data-dropdown-toggle');
                const dropdown = document.querySelector(`[data-dropdown-menu="${dropdownId}"]`);
                
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            }
        });
    }

    // Sistema de Notificaciones en Tiempo Real
    initNotifications() {
        this.notificationBell = document.getElementById('notification-bell');
        this.notificationBadge = document.getElementById('notification-badge');
        this.notificationDropdown = document.getElementById('notification-dropdown');
        
        if (this.notificationBell) {
            this.loadNotifications();
            
            // Actualizar notificaciones cada 30 segundos
            setInterval(() => {
                this.loadNotifications();
            }, 30000);
        }
    }

    async loadNotifications() {
        try {
            const response = await fetch('/api/notificaciones');
            const data = await response.json();
            
            if (data.success) {
                this.updateNotificationBadge(data.unread_count);
                this.updateNotificationDropdown(data.notifications);
            }
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    updateNotificationBadge(count) {
        if (this.notificationBadge) {
            if (count > 0) {
                this.notificationBadge.textContent = count > 99 ? '99+' : count;
                this.notificationBadge.classList.remove('hidden');
            } else {
                this.notificationBadge.classList.add('hidden');
            }
        }
    }

    updateNotificationDropdown(notifications) {
        if (this.notificationDropdown) {
            const list = this.notificationDropdown.querySelector('.notification-list');
            
            if (list) {
                list.innerHTML = '';
                
                if (notifications.length === 0) {
                    list.innerHTML = '<p class="text-gray-500 text-center py-4">No hay notificaciones</p>';
                } else {
                    notifications.forEach(notification => {
                        const item = this.createNotificationItem(notification);
                        list.appendChild(item);
                    });
                }
            }
        }
    }

    createNotificationItem(notification) {
        const item = document.createElement('div');
        item.className = `notification-item p-3 border-b border-gray-200 hover:bg-gray-50 cursor-pointer ${!notification.read_at ? 'bg-blue-50' : ''}`;
        item.setAttribute('data-notification-id', notification.id);
        
        item.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">${this.getNotificationTitle(notification.action)}</p>
                    <p class="text-sm text-gray-600">${notification.details || ''}</p>
                    <p class="text-xs text-gray-400">${this.formatTimeAgo(notification.created_at)}</p>
                </div>
                ${!notification.read_at ? '<div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>' : ''}
            </div>
        `;

        item.addEventListener('click', () => {
            this.markNotificationAsRead(notification.id);
        });

        return item;
    }

    getNotificationTitle(action) {
        const titles = {
            'sale_made': 'Nueva venta realizada',
            'rifa_completed': 'Rifa completada',
            'rifa_near_draw': 'Sorteo próximo',
            'vendor_assigned': 'Vendedor asignado',
            'payment_pending_expired': 'Pago expirado',
            'user_registered': 'Nuevo usuario registrado'
        };

        return titles[action] || 'Notificación';
    }

    async markNotificationAsRead(notificationId) {
        try {
            await fetch('/api/notificaciones/marcar-leida', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ notification_id: notificationId })
            });
            
            this.loadNotifications(); // Refresh
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    // Mejoras de Formularios
    initFormEnhancements() {
        this.initRUTInputs();
        this.initCurrencyInputs();
        this.initDateInputs();
        this.initFileUploads();
    }

    initRUTInputs() {
        document.querySelectorAll('input[data-rut]').forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.value = this.formatRUT(e.target.value);
            });
        });
    }

    formatRUT(value) {
        // Remove all non-numeric characters except K
        let rut = value.replace(/[^0-9kK]/g, '');
        
        if (rut.length <= 1) return rut;
        
        // Separate verification digit
        let dv = rut.slice(-1);
        let number = rut.slice(0, -1);
        
        // Format number with dots
        if (number.length > 3) {
            number = number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        
        return number + '-' + dv;
    }

    initCurrencyInputs() {
        document.querySelectorAll('input[data-currency]').forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/[^\d]/g, '');
                e.target.value = this.formatCurrency(value);
            });
        });
    }

    formatCurrency(value) {
        if (!value) return '';
        return '$' + parseInt(value).toLocaleString('es-CL');
    }

    initDateInputs() {
        // Configurar inputs de fecha para formato chileno
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('change', (e) => {
                // Validaciones adicionales para fechas chilenas
                const date = new Date(e.target.value);
                const today = new Date();
                
                if (input.hasAttribute('data-min-today') && date < today) {
                    this.showToast('La fecha no puede ser anterior a hoy', 'error');
                    e.target.value = '';
                }
            });
        });
    }

    initFileUploads() {
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const preview = input.parentNode.querySelector('.file-preview');
                    if (preview) {
                        preview.textContent = file.name;
                        preview.classList.remove('hidden');
                    }
                }
            });
        });
    }

    // Tooltips
    initTooltips() {
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                this.showTooltip(e.target, e.target.getAttribute('data-tooltip'));
            });

            element.addEventListener('mouseleave', () => {
                this.hideTooltip();
            });
        });
    }

    showTooltip(element, text) {
        this.hideTooltip(); // Remove any existing tooltip

        const tooltip = document.createElement('div');
        tooltip.id = 'tooltip';
        tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg';
        tooltip.textContent = text;

        document.body.appendChild(tooltip);

        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
    }

    hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }

    // Utilidades
    formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'hace unos segundos';
        if (diffInSeconds < 3600) return `hace ${Math.floor(diffInSeconds / 60)} minutos`;
        if (diffInSeconds < 86400) return `hace ${Math.floor(diffInSeconds / 3600)} horas`;
        if (diffInSeconds < 2592000) return `hace ${Math.floor(diffInSeconds / 86400)} días`;
        if (diffInSeconds < 31536000) return `hace ${Math.floor(diffInSeconds / 2592000)} meses`;
        return `hace ${Math.floor(diffInSeconds / 31536000)} años`;
    }

    // Efectos visuales
    addLoadingState(element) {
        const originalText = element.textContent;
        element.disabled = true;
        element.innerHTML = '<span class="spinner mr-2"></span>Cargando...';
        
        return () => {
            element.disabled = false;
            element.textContent = originalText;
        };
    }

    // Confirmaciones
    confirm(message, onConfirm, onCancel = null) {
        const modal = this.createConfirmModal(message, onConfirm, onCancel);
        document.body.appendChild(modal);
        this.openModal(modal.id);
    }

    createConfirmModal(message, onConfirm, onCancel) {
        const modalId = 'confirm-modal-' + Date.now();
        const modal = document.createElement('div');
        modal.id = modalId;
        modal.className = 'modal-overlay hidden';
        
        modal.innerHTML = `
            <div class="modal-content max-w-md">
                <h3 class="text-lg font-medium text-white mb-4">Confirmar acción</h3>
                <p class="text-gray-300 mb-6">${message}</p>
                <div class="flex justify-end space-x-3">
                    <button class="glass-button" onclick="rifasUI.closeModal(); this.parentElement.parentElement.parentElement.remove();">
                        Cancelar
                    </button>
                    <button class="glass-button-primary" id="confirm-yes">
                        Confirmar
                    </button>
                </div>
            </div>
        `;

        modal.querySelector('#confirm-yes').addEventListener('click', () => {
            onConfirm();
            this.closeModal();
            modal.remove();
        });

        return modal;
    }

    // Sistema de notificaciones moderno con estilo glassmorphism
    showNotification(message, type = 'info') {
        const notificationClasses = {
            'success': 'bg-green-500 bg-opacity-80',
            'error': 'bg-red-500 bg-opacity-80',
            'info': 'bg-blue-500 bg-opacity-80',
            'warning': 'bg-yellow-500 bg-opacity-80'
        };
        
        // Crear elemento de notificación con estilo glassmorphism
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg backdrop-blur-sm text-white 
            border border-white border-opacity-20 ${notificationClasses[type] || notificationClasses.info} 
            transform transition-all duration-300 opacity-0 translate-y-[-20px] z-50`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="mr-2">
                    ${type === 'success' ? '<i class="fas fa-check-circle"></i>' : 
                    type === 'error' ? '<i class="fas fa-exclamation-circle"></i>' :
                    type === 'warning' ? '<i class="fas fa-exclamation-triangle"></i>' :
                    '<i class="fas fa-info-circle"></i>'}
                </span>
                <p class="text-sm">${message}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('opacity-0', 'translate-y-[-20px]');
            notification.classList.add('opacity-100', 'translate-y-0');
        }, 10);
        
        // Animar salida y eliminar
        setTimeout(() => {
            notification.classList.remove('opacity-100', 'translate-y-0');
            notification.classList.add('opacity-0', 'translate-y-[-20px]');
            
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }
}

// Inicializar UI cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.rifasUI = new RifasUI();
});

// Funciones globales para compatibilidad
function showToast(message, type = 'info', duration = 5000) {
    if (window.rifasUI) {
        window.rifasUI.showToast(message, type, duration);
    }
}

function openModal(modalId) {
    if (window.rifasUI) {
        window.rifasUI.openModal(modalId);
    }
}

function closeModal() {
    if (window.rifasUI) {
        window.rifasUI.closeModal();
    }
}

// Crear instancia global
window.rifasUI = new RifasUI();
// Mantener compatibilidad con UI para vistas existentes
window.UI = window.rifasUI;
