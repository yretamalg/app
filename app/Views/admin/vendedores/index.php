<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary">Gestión de Vendedores</h1>
        <a href="<?= url('admin/vendedores/crear') ?>" class="btn btn-primary">
            <i class="fas fa-user-plus mr-2"></i> Nuevo Vendedor
        </a>
    </div>

    <?php require_once __DIR__ . '/../../layouts/alerts.php'; ?>

    <!-- Filtros -->
    <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-4 mb-6 shadow-lg">
        <form action="<?= url('admin/vendedores') ?>" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="buscar" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" id="buscar" name="buscar" class="form-input" placeholder="Nombre o correo..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
            </div>
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="activo" <?= (isset($_GET['estado']) && $_GET['estado'] === 'activo') ? 'selected' : '' ?>>Activos</option>
                    <option value="inactivo" <?= (isset($_GET['estado']) && $_GET['estado'] === 'inactivo') ? 'selected' : '' ?>>Inactivos</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Vendedores -->
    <div class="overflow-x-auto">
        <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200/30">
                <thead class="bg-gray-100/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rifas Asignadas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ventas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-md divide-y divide-gray-200/30">
                    <?php if (empty($vendedores)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay vendedores disponibles. <a href="<?= url('admin/vendedores/crear') ?>" class="text-primary hover:underline">Crear un nuevo vendedor</a>.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($vendedores as $vendedor) : ?>
                            <tr class="hover:bg-gray-50/30 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if ($vendedor['imagen']) : ?>
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="<?= url('public' . $vendedor['imagen']) ?>" alt="<?= htmlspecialchars($vendedor['nombre']) ?>">
                                            </div>
                                        <?php else : ?>
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vendedor['nombre']) ?></div>
                                            <div class="text-xs text-gray-500">Desde: <?= date('d/m/Y', strtotime($vendedor['created_at'])) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($vendedor['email']) ?></div>
                                    <div class="text-sm text-gray-500"><?= htmlspecialchars($vendedor['telefono'] ?? 'No disponible') ?></div>
                                    <div class="text-xs text-gray-500">RUT: <?= htmlspecialchars($vendedor['rut']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?= $vendedor['estado'] === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= ucfirst($vendedor['estado']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $vendedor['rifas_asignadas'] ?? 0 ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">$<?= number_format($vendedor['total_ventas'] ?? 0, 0, ',', '.') ?></div>
                                    <div class="text-xs text-gray-500"><?= $vendedor['numeros_vendidos'] ?? 0 ?> números</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="<?= url('admin/vendedores/' . $vendedor['id'] . '/editar') ?>" class="text-blue-600 hover:text-blue-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= url('admin/vendedores/' . $vendedor['id']) ?>" class="text-green-600 hover:text-green-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($vendedor['estado'] === 'activo') : ?>
                                            <form action="<?= url('admin/vendedores/' . $vendedor['id'] . '/desactivar') ?>" method="POST" class="inline">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                <button type="submit" class="text-orange-600 hover:text-orange-900" title="Desactivar" onclick="return confirm('¿Estás seguro de desactivar este vendedor?')">
                                                    <i class="fas fa-user-slash"></i>
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <form action="<?= url('admin/vendedores/' . $vendedor['id'] . '/activar') ?>" method="POST" class="inline">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Activar" onclick="return confirm('¿Estás seguro de activar este vendedor?')">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?= url('admin/vendedores/' . $vendedor['id'] . '/resetear-password') ?>" method="POST" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                            <button type="submit" class="text-purple-600 hover:text-purple-900" title="Resetear contraseña" onclick="return confirm('¿Estás seguro de resetear la contraseña de este vendedor? Se le enviará una nueva por email.')">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </form>
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

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
