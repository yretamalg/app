<?php 
// Vista de gestión de usuarios para SuperAdmin
$title = $title ?? 'Gestión de Usuarios - SuperAdmin';
?>

<!-- Incluir la cabecera del admin panel -->
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h1>
        <a href="<?= url('superadmin/usuarios/crear') ?>" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg flex items-center transition-colors">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Crear Usuario
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form id="userFilterForm" class="flex flex-wrap gap-4">
            <div class="w-full md:w-auto">
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario</label>
                <select id="tipo" name="tipo" class="block w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3">
                    <option value="">Todos</option>
                    <option value="superadmin" <?= isset($_GET['tipo']) && $_GET['tipo'] === 'superadmin' ? 'selected' : '' ?>>SuperAdmin</option>
                    <option value="admin" <?= isset($_GET['tipo']) && $_GET['tipo'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                    <option value="vendedor" <?= isset($_GET['tipo']) && $_GET['tipo'] === 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
                    <option value="comprador" <?= isset($_GET['tipo']) && $_GET['tipo'] === 'comprador' ? 'selected' : '' ?>>Comprador</option>
                </select>
            </div>
            <div class="w-full md:w-auto">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado" class="block w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3">
                    <option value="">Todos</option>
                    <option value="activo" <?= isset($_GET['estado']) && $_GET['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= isset($_GET['estado']) && $_GET['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    <option value="suspendido" <?= isset($_GET['estado']) && $_GET['estado'] === 'suspendido' ? 'selected' : '' ?>>Suspendido</option>
                </select>
            </div>
            <div class="w-full md:w-auto flex-1">
                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" id="buscar" name="q" placeholder="Nombre, email o RUT..." 
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
                       class="block w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3">
            </div>
            <div class="w-full md:w-auto self-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors">
                    Filtrar
                </button>
            </div>
            <div class="w-full md:w-auto self-end">
                <button type="button" id="resetFilters" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors">
                    Limpiar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de usuarios -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creación</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No se encontraron usuarios</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium text-lg">
                                            <?= strtoupper(substr($usuario['nombre'] ?? 'U', 0, 1)) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($usuario['rut'] ?? 'Sin RUT') ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= htmlspecialchars($usuario['email']) ?></div>
                            <div class="text-sm text-gray-500"><?= htmlspecialchars($usuario['telefono'] ?? 'Sin teléfono') ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                <?php
                                switch($usuario['tipo']) {
                                    case 'superadmin':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    case 'admin':
                                        echo 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'vendedor':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                                <?= ucfirst(htmlspecialchars($usuario['tipo'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                <?php
                                switch($usuario['estado']) {
                                    case 'activo':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    case 'inactivo':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'suspendido':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                                <?= ucfirst(htmlspecialchars($usuario['estado'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d/m/Y', strtotime($usuario['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="<?= url('superadmin/usuarios/editar/' . $usuario['id']) ?>" 
                                   class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <?php if ($usuario['tipo'] !== 'superadmin'): ?>
                                <a href="<?= url('superadmin/personificar/' . $usuario['id']) ?>" 
                                   class="text-blue-600 hover:text-blue-900" title="Personificar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <button type="button" data-id="<?= $usuario['id'] ?>" class="text-red-600 hover:text-red-900 deleteBtn" title="Eliminar">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reset de filtros
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('tipo').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('buscar').value = '';
        document.getElementById('userFilterForm').submit();
    });
    
    // Eliminación de usuario
    const deleteBtns = document.querySelectorAll('.deleteBtn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            if (confirm('¿Estás seguro de querer eliminar este usuario? Esta acción no se puede deshacer.')) {
                window.location.href = '<?= url('superadmin/usuarios/eliminar/') ?>' + userId;
            }
        });
    });
});
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
