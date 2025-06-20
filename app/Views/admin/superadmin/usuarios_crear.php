<?php 
// Vista de creación de usuarios para SuperAdmin
$title = $title ?? 'Crear Usuario - SuperAdmin';
?>

<!-- Incluir la cabecera del admin panel -->
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Crear Usuario</h1>
        <a href="<?= url('superadmin/usuarios') ?>" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg flex items-center transition-colors">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash'])): ?>
        <?php foreach ($_SESSION['flash'] as $type => $message): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $type === 'error' ? 'bg-red-500 bg-opacity-20 border border-red-300 text-red-800' : 'bg-green-500 bg-opacity-20 border border-green-300 text-green-800'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Formulario de creación de usuario -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form id="createUserForm" method="POST" action="<?= url('superadmin/usuarios/crear') ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken ?? ''); ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Básica -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Información Básica</h2>
                    
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-600">*</span></label>
                        <input type="text" id="nombre" name="nombre" required 
                               value="<?= htmlspecialchars($_SESSION['old_input']['nombre'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" 
                               value="<?= htmlspecialchars($_SESSION['old_input']['apellidos'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-600">*</span></label>
                        <input type="email" id="email" name="email" required 
                               value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña <span class="text-red-600">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" 
                               value="<?= htmlspecialchars($_SESSION['old_input']['telefono'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">RUT (Formato: 12345678-9)</label>
                        <input type="text" id="rut" name="rut" 
                               value="<?= htmlspecialchars($_SESSION['old_input']['rut'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <!-- Configuración del Usuario -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Configuración del Usuario</h2>
                    
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario <span class="text-red-600">*</span></label>
                        <select id="tipo" name="tipo" required
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="comprador" <?= (isset($_SESSION['old_input']['tipo']) && $_SESSION['old_input']['tipo'] == 'comprador') ? 'selected' : '' ?>>Comprador</option>
                            <option value="vendedor" <?= (isset($_SESSION['old_input']['tipo']) && $_SESSION['old_input']['tipo'] == 'vendedor') ? 'selected' : '' ?>>Vendedor</option>
                            <option value="admin" <?= (isset($_SESSION['old_input']['tipo']) && $_SESSION['old_input']['tipo'] == 'admin') ? 'selected' : '' ?>>Administrador</option>
                            <option value="superadmin" <?= (isset($_SESSION['old_input']['tipo']) && $_SESSION['old_input']['tipo'] == 'superadmin') ? 'selected' : '' ?>>SuperAdmin</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado <span class="text-red-600">*</span></label>
                        <select id="estado" name="estado" required
                                class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="activo" <?= (isset($_SESSION['old_input']['estado']) && $_SESSION['old_input']['estado'] == 'activo') ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= (isset($_SESSION['old_input']['estado']) && $_SESSION['old_input']['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                            <option value="suspendido" <?= (isset($_SESSION['old_input']['estado']) && $_SESSION['old_input']['estado'] == 'suspendido') ? 'selected' : '' ?>>Suspendido</option>
                        </select>
                    </div>
                    
                    <div id="organizacionContainer">
                        <label for="organizacion" class="block text-sm font-medium text-gray-700 mb-1">Organización</label>
                        <input type="text" id="organizacion" name="organizacion" 
                               value="<?= htmlspecialchars($_SESSION['old_input']['organizacion'] ?? '') ?>"
                               class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_particular" name="is_particular" value="1"
                               <?= (isset($_SESSION['old_input']['is_particular']) && $_SESSION['old_input']['is_particular']) ? 'checked' : '' ?>
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_particular" class="ml-2 block text-sm text-gray-700">Es Particular</label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="datos_completos" name="datos_completos" value="1"
                               <?= (isset($_SESSION['old_input']['datos_completos']) && $_SESSION['old_input']['datos_completos']) ? 'checked' : '' ?>
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="datos_completos" class="ml-2 block text-sm text-gray-700">Datos Completos</label>
                    </div>
                    
                    <p class="text-sm text-gray-500 italic">
                        Si no se marcan los "Datos Completos", el usuario deberá completar su información en el primer inicio de sesión.
                    </p>
                </div>
            </div>
            
            <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors">
                    Limpiar
                </button>
                <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formateo de RUT chileno
    const rutInput = document.getElementById('rut');
    rutInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9kK]/g, '');
        if (value.length > 1) {
            value = value.slice(0, -1) + '-' + value.slice(-1);
        }
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        e.target.value = value;
    });
    
    // Mostrar/ocultar campo de organización
    const isParticularCheckbox = document.getElementById('is_particular');
    const organizacionContainer = document.getElementById('organizacionContainer');
    
    function updateOrganizacionVisibility() {
        if (isParticularCheckbox.checked) {
            organizacionContainer.classList.add('opacity-50');
            organizacionContainer.querySelector('input').disabled = true;
        } else {
            organizacionContainer.classList.remove('opacity-50');
            organizacionContainer.querySelector('input').disabled = false;
        }
    }
    
    updateOrganizacionVisibility();
    isParticularCheckbox.addEventListener('change', updateOrganizacionVisibility);
});
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
