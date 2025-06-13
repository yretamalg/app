/**
 * Logic.js - Módulo para cálculos, validaciones y lógica de negocio
 * Sistema de Rifas Chile
 */

class RifasLogic {
    constructor() {
        this.selectedNumbers = new Set();
        this.rifaData = null;
        this.init();
    }

    init() {
        this.initRifaGrid();
        this.initSaleForm();
        this.initStatistics();
        this.initValidations();
    }

    // Gestión de números de rifa
    initRifaGrid() {
        const rifaGrid = document.querySelector('.rifa-grid');
        if (rifaGrid) {
            rifaGrid.addEventListener('click', (e) => {
                if (e.target.matches('.rifa-number.disponible')) {
                    this.toggleNumber(e.target);
                }
            });

            // Botón seleccionar todos
            const selectAllBtn = document.getElementById('select-all-numbers');
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', () => this.selectAllAvailable());
            }

            // Botón limpiar selección
            const clearSelectionBtn = document.getElementById('clear-selection');
            if (clearSelectionBtn) {
                clearSelectionBtn.addEventListener('click', () => this.clearSelection());
            }
        }
    }

    toggleNumber(numberElement) {
        const number = parseInt(numberElement.textContent);
        
        if (numberElement.classList.contains('seleccionado')) {
            // Deseleccionar
            numberElement.classList.remove('seleccionado');
            this.selectedNumbers.delete(number);
        } else {
            // Seleccionar
            numberElement.classList.add('seleccionado');
            this.selectedNumbers.add(number);
        }

        this.updateSelectionSummary();
        this.updateSaleForm();
    }

    selectAllAvailable() {
        const availableNumbers = document.querySelectorAll('.rifa-number.disponible:not(.seleccionado)');
        
        availableNumbers.forEach(numberElement => {
            const number = parseInt(numberElement.textContent);
            numberElement.classList.add('seleccionado');
            this.selectedNumbers.add(number);
        });

        this.updateSelectionSummary();
        this.updateSaleForm();
    }

    clearSelection() {
        document.querySelectorAll('.rifa-number.seleccionado').forEach(numberElement => {
            numberElement.classList.remove('seleccionado');
        });
        
        this.selectedNumbers.clear();
        this.updateSelectionSummary();
        this.updateSaleForm();
    }

    updateSelectionSummary() {
        const summaryElement = document.getElementById('selection-summary');
        if (summaryElement) {
            const count = this.selectedNumbers.size;
            const numbers = Array.from(this.selectedNumbers).sort((a, b) => a - b);
            
            if (count === 0) {
                summaryElement.innerHTML = '<p class="text-gray-400">No hay números seleccionados</p>';
            } else {
                summaryElement.innerHTML = `
                    <p class="text-white font-medium">${count} número${count > 1 ? 's' : ''} seleccionado${count > 1 ? 's' : ''}</p>
                    <p class="text-gray-300 text-sm">${this.formatNumberList(numbers)}</p>
                `;
            }
        }
    }

    formatNumberList(numbers) {
        if (numbers.length <= 10) {
            return numbers.join(', ');
        } else {
            return numbers.slice(0, 10).join(', ') + ` y ${numbers.length - 10} más...`;
        }
    }

    // Formulario de venta
    initSaleForm() {
        const saleForm = document.getElementById('sale-form');
        if (saleForm) {
            saleForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.processSale();
            });

            // Actualizar total al cambiar modo de pago
            const paymentModeInputs = saleForm.querySelectorAll('input[name="payment_mode"]');
            paymentModeInputs.forEach(input => {
                input.addEventListener('change', () => this.updateSaleForm());
            });
        }
    }

    updateSaleForm() {
        const saleForm = document.getElementById('sale-form');
        if (!saleForm) return;

        const numbersInput = saleForm.querySelector('input[name="selected_numbers"]');
        const totalElement = saleForm.querySelector('#sale-total');
        const sellButton = saleForm.querySelector('#sell-button');

        // Actualizar números seleccionados
        if (numbersInput) {
            numbersInput.value = Array.from(this.selectedNumbers).join(',');
        }

        // Calcular y mostrar total
        const total = this.calculateTotal();
        if (totalElement) {
            totalElement.textContent = this.formatCurrency(total);
        }

        // Habilitar/deshabilitar botón de venta
        if (sellButton) {
            sellButton.disabled = this.selectedNumbers.size === 0;
        }
    }

    calculateTotal() {
        const pricePerNumber = this.getPricePerNumber();
        return this.selectedNumbers.size * pricePerNumber;
    }

    getPricePerNumber() {
        const priceElement = document.querySelector('[data-price-per-number]');
        return priceElement ? parseInt(priceElement.dataset.pricePerNumber) : 0;
    }

    formatCurrency(amount) {
        return '$' + amount.toLocaleString('es-CL') + ' CLP';
    }

    async processSale() {
        const saleForm = document.getElementById('sale-form');
        const formData = new FormData(saleForm);
        
        // Validar formulario
        const validation = this.validateSaleForm(formData);
        if (!validation.valid) {
            showToast(validation.message, 'error');
            return;
        }

        // Mostrar loading
        const sellButton = saleForm.querySelector('#sell-button');
        const removeLoading = rifasUI.addLoadingState(sellButton);

        try {
            const response = await fetch('/vendedor/vender', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();

            if (result.success) {
                showToast('Venta registrada exitosamente', 'success');
                this.clearSelection();
                this.refreshRifaGrid();
                rifasUI.closeModal();
                
                // Actualizar estadísticas
                this.updateDashboardStats();
            } else {
                showToast(result.message || 'Error al procesar la venta', 'error');
            }
        } catch (error) {
            console.error('Error processing sale:', error);
            showToast('Error de conexión. Inténtalo nuevamente', 'error');
        } finally {
            removeLoading();
        }
    }

    validateSaleForm(formData) {
        const buyerName = formData.get('buyer_name');
        const buyerEmail = formData.get('buyer_email');
        const buyerPhone = formData.get('buyer_phone');
        const paymentMode = formData.get('payment_mode');

        if (!buyerName || buyerName.trim().length < 2) {
            return { valid: false, message: 'El nombre del comprador es obligatorio' };
        }

        if (!buyerEmail || !this.validateEmail(buyerEmail)) {
            return { valid: false, message: 'Debe proporcionar un email válido' };
        }

        if (!buyerPhone || !this.validateChileanPhone(buyerPhone)) {
            return { valid: false, message: 'Debe proporcionar un teléfono chileno válido' };
        }

        if (!paymentMode) {
            return { valid: false, message: 'Debe seleccionar un modo de pago' };
        }

        if (this.selectedNumbers.size === 0) {
            return { valid: false, message: 'Debe seleccionar al menos un número' };
        }

        return { valid: true };
    }

    // Validaciones
    initValidations() {
        // Validación en tiempo real de formularios
        document.querySelectorAll('form').forEach(form => {
            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });
            });
        });
    }

    validateField(input) {
        const value = input.value.trim();
        const type = input.type || input.getAttribute('data-validate');
        let isValid = true;
        let message = '';

        switch (type) {
            case 'email':
                isValid = this.validateEmail(value);
                message = 'Email no válido';
                break;
            case 'rut':
                isValid = this.validateRUT(value);
                message = 'RUT no válido';
                break;
            case 'phone':
                isValid = this.validateChileanPhone(value);
                message = 'Teléfono no válido';
                break;
        }

        this.showFieldValidation(input, isValid, message);
        return isValid;
    }

    validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    validateRUT(rut) {
        if (!rut) return false;
        
        // Remove formatting
        const cleanRut = rut.replace(/[.-]/g, '');
        
        if (cleanRut.length < 8 || cleanRut.length > 9) return false;
        
        const dv = cleanRut.slice(-1).toUpperCase();
        const number = cleanRut.slice(0, -1);
        
        if (!/^\d+$/.test(number)) return false;
        
        // Calculate verification digit
        let sum = 0;
        let multiplier = 2;
        
        for (let i = number.length - 1; i >= 0; i--) {
            sum += parseInt(number[i]) * multiplier;
            multiplier = multiplier === 7 ? 2 : multiplier + 1;
        }
        
        const remainder = sum % 11;
        const calculatedDv = remainder === 0 ? '0' : remainder === 1 ? 'K' : (11 - remainder).toString();
        
        return dv === calculatedDv;
    }

    validateChileanPhone(phone) {
        // Remove all non-numeric characters except +
        const cleanPhone = phone.replace(/[^\d+]/g, '');
        
        // Chilean mobile: +56 9 XXXX XXXX or 9 XXXX XXXX
        // Chilean landline: +56 X XXXX XXXX or X XXXX XXXX (X != 9)
        const mobileRegex = /^(\+?56)?9\d{8}$/;
        const landlineRegex = /^(\+?56)?[2-8]\d{7,8}$/;
        
        return mobileRegex.test(cleanPhone) || landlineRegex.test(cleanPhone);
    }

    showFieldValidation(input, isValid, message) {
        const errorElement = input.parentNode.querySelector('.field-error');
        
        if (isValid) {
            input.classList.remove('border-red-500');
            input.classList.add('border-green-500');
            if (errorElement) errorElement.remove();
        } else {
            input.classList.remove('border-green-500');
            input.classList.add('border-red-500');
            
            if (!errorElement && message) {
                const error = document.createElement('p');
                error.className = 'field-error text-red-400 text-sm mt-1';
                error.textContent = message;
                input.parentNode.appendChild(error);
            }
        }
    }

    // Estadísticas y Dashboard
    initStatistics() {
        this.loadDashboardStats();
        
        // Actualizar estadísticas cada 5 minutos
        setInterval(() => {
            this.loadDashboardStats();
        }, 300000);
    }

    async loadDashboardStats() {
        try {
            const response = await fetch('/api/estadisticas/dashboard');
            const data = await response.json();
            
            if (data.success) {
                this.updateStatsDisplay(data.stats);
            }
        } catch (error) {
            console.error('Error loading dashboard stats:', error);
        }
    }

    updateStatsDisplay(stats) {
        // Actualizar contadores en el dashboard
        Object.keys(stats).forEach(key => {
            const element = document.querySelector(`[data-stat="${key}"]`);
            if (element) {
                if (key.includes('amount') || key.includes('total')) {
                    element.textContent = this.formatCurrency(stats[key]);
                } else {
                    element.textContent = stats[key].toLocaleString('es-CL');
                }
            }
        });

        // Actualizar gráficos si existen
        this.updateCharts(stats);
    }

    updateCharts(stats) {
        // Actualizar barras de progreso
        document.querySelectorAll('.progress-bar').forEach(bar => {
            const statKey = bar.getAttribute('data-progress-stat');
            if (statKey && stats[statKey]) {
                const percentage = Math.min(100, (stats[statKey] / stats[statKey + '_max']) * 100);
                const fill = bar.querySelector('.progress-fill');
                if (fill) {
                    fill.style.width = percentage + '%';
                }
            }
        });
    }

    async updateDashboardStats() {
        await this.loadDashboardStats();
    }

    // Gestión de inventario de rifas
    async refreshRifaGrid() {
        const rifaGrid = document.querySelector('.rifa-grid');
        if (!rifaGrid) return;

        const rifaId = rifaGrid.getAttribute('data-rifa-id');
        if (!rifaId) return;

        try {
            const response = await fetch(`/api/rifas/${rifaId}/numeros`);
            const data = await response.json();
            
            if (data.success) {
                this.updateRifaGrid(data.numbers);
            }
        } catch (error) {
            console.error('Error refreshing rifa grid:', error);
        }
    }

    updateRifaGrid(numbers) {
        const rifaGrid = document.querySelector('.rifa-grid');
        if (!rifaGrid) return;

        rifaGrid.innerHTML = '';
        
        numbers.forEach(numberData => {
            const numberElement = document.createElement('div');
            numberElement.className = `rifa-number ${numberData.estado}`;
            numberElement.textContent = numberData.numero;
            
            if (numberData.estado === 'disponible') {
                numberElement.addEventListener('click', () => this.toggleNumber(numberElement));
            }
            
            rifaGrid.appendChild(numberElement);
        });
    }

    // Cálculos de inventario para administradores
    calculateInventoryDistribution(totalNumbers, vendors, distributionType) {
        const results = [];
        
        switch (distributionType) {
            case 'equitativo':
                const numbersPerVendor = Math.floor(totalNumbers / vendors.length);
                const remainder = totalNumbers % vendors.length;
                
                vendors.forEach((vendor, index) => {
                    const extra = index < remainder ? 1 : 0;
                    const assignedNumbers = numbersPerVendor + extra;
                    
                    results.push({
                        vendor_id: vendor.id,
                        vendor_name: vendor.nombre,
                        assigned_numbers: assignedNumbers,
                        range_start: results.length > 0 ? results[results.length - 1].range_end + 1 : 1,
                        range_end: results.length > 0 ? results[results.length - 1].range_end + assignedNumbers : assignedNumbers
                    });
                });
                break;
                
            case 'manual':
                // Para distribución manual, el administrador especifica manualmente
                break;
        }
        
        return results;
    }

    // Utilidades
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-CL', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);
        return date.toLocaleString('es-CL', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    getDaysUntil(dateString) {
        const targetDate = new Date(dateString);
        const today = new Date();
        const diffTime = targetDate - today;
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }

    isDateInPast(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        return date < today;
    }
}

// Inicializar lógica cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.rifasLogic = new RifasLogic();
});

// Funciones globales de utilidad
function validateRUT(rut) {
    return window.rifasLogic ? window.rifasLogic.validateRUT(rut) : false;
}

function validateEmail(email) {
    return window.rifasLogic ? window.rifasLogic.validateEmail(email) : false;
}

function formatCurrency(amount) {
    return window.rifasLogic ? window.rifasLogic.formatCurrency(amount) : '$' + amount;
}
