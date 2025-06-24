<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary">Crear Nuevo Vendedor</h1>
        <a href="<?= url('admin/vendedores') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Volver a Vendedores
        </a>
    </div>

    <?php require_once __DIR__ . '/../../layouts/alerts.php'; ?>

    <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-6 shadow-lg">
        <form action="<?= url('admin/vendedores/crear') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            
            <!-- Información Personal -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                        <input type="text" name="nombre" id="nombre" required class="form-input w-full" placeholder="Nombre completo">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" id="email" required class="form-input w-full" placeholder="correo@ejemplo.com">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">RUT *</label>
                        <input type="text" name="rut" id="rut" required class="form-input w-full" placeholder="12.345.678-9">
                        <p class="text-xs text-gray-500 mt-1">Formato: 12.345.678-9</p>
                    </div>
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" name="telefono" id="telefono" class="form-input w-full" placeholder="+56 9 1234 5678">
                    </div>
                </div>
            </div>
            
            <!-- Credenciales -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Credenciales de Acceso</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña *</label>
                        <input type="password" name="password" id="password" required class="form-input w-full" minlength="6">
                        <p class="text-xs text-gray-500 mt-1">Mínimo 6 caracteres</p>
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña *</label>
                        <input type="password" name="confirm_password" id="confirm_password" required class="form-input w-full" minlength="6">
                    </div>
                </div>
            </div>
            
            <!-- Configuración -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Configuración</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="comision_default" class="block text-sm font-medium text-gray-700 mb-1">Comisión por Defecto (%)</label>
                        <input type="number" name="comision_default" id="comision_default" class="form-input w-full" min="0" max="50" step="0.5" value="10">
                        <p class="text-xs text-gray-500 mt-1">Porcentaje por cada venta</p>
                    </div>
                    <div>
                        <label for="limite_credito" class="block text-sm font-medium text-gray-700 mb-1">Límite de Crédito (CLP)</label>
                        <input type="number" name="limite_credito" id="limite_credito" class="form-input w-full" min="0" step="1000" value="0">
                        <p class="text-xs text-gray-500 mt-1">0 = Sin límite de crédito</p>
                    </div>
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado" id="estado" class="form-select w-full">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Imagen de Perfil -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Imagen de Perfil</h2>
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="preview" class="h-24 w-24 object-cover rounded-full" src="<?= url('public/assets/img/default-profile.jpg') ?>" alt="Imagen de perfil">
                    </div>
                    <div class="w-full">
                        <label class="block">
                            <span class="sr-only">Seleccionar imagen</span>
                            <input type="file" name="imagen" id="imagen_upload" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            " accept="image/*">
                        </label>
                        <p class="mt-1 text-sm text-gray-500">PNG, JPG o JPEG hasta 5MB</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="<?= url('admin/vendedores') ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus mr-2"></i> Crear Vendedor
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('imagen_upload').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
};

// Formatear RUT automáticamente
document.getElementById('rut').addEventListener('input', function(e) {
    let rut = this.value.replace(/\./g,'').replace('-', '');
    
    if (rut.length > 1) {
        let dv = rut.charAt(rut.length-1);
        rut = rut.slice(0, -1);
        
        // Agregar puntos
        rut = rut.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        this.value = rut + '-' + dv;
    }
});

// Validar RUT
document.querySelector('form').addEventListener('submit', function(e) {
    let rut = document.getElementById('rut').value;
    if (!validarRut(rut)) {
        e.preventDefault();
        alert('El RUT ingresado no es válido');
    }
    
    if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
    }
});

function validarRut(rut) {
    // Despejar puntos y guión
    rut = rut.replace(/\./g,'').replace('-', '');
    
    // Obtener cuerpo y dígito verificador
    let cuerpo = rut.slice(0, -1);
    let dv = rut.slice(-1).toUpperCase();
    
    // Calcular dígito verificador
    let suma = 0;
    let multiplicador = 2;
    
    for (let i=cuerpo.length-1; i>=0; i--) {
        suma += parseInt(cuerpo.charAt(i)) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
    
    let dvEsperado = 11 - (suma % 11);
    if (dvEsperado === 11) dvEsperado = '0';
    else if (dvEsperado === 10) dvEsperado = 'K';
    else dvEsperado = String(dvEsperado);
    
    return dv === dvEsperado;
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
