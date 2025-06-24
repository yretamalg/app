<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6 space-x-4">
        <a href="<?= url('admin/rifas') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-primary"><?= htmlspecialchars($rifa['titulo']) ?></h1>
        
        <?php if ($rifa['estado'] === 'borrador'): ?>
            <span class="ml-auto px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                Borrador
            </span>
        <?php elseif ($rifa['estado'] === 'publicada'): ?>
            <span class="ml-auto px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                Publicada
            </span>
        <?php elseif ($rifa['estado'] === 'suspendida'): ?>
            <span class="ml-auto px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                Suspendida
            </span>
        <?php else: ?>
            <span class="ml-auto px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                Finalizada
            </span>
        <?php endif; ?>
    </div>

    <?php require_once __DIR__ . '/../../layouts/alerts.php'; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda: Detalles y Acciones -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Imagen y Detalles -->
            <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg overflow-hidden shadow-lg">
                <?php if ($rifa['imagen']): ?>
                    <img src="<?= url('public' . $rifa['imagen']) ?>" alt="<?= htmlspecialchars($rifa['titulo']) ?>" class="w-full h-48 object-cover">
                <?php endif; ?>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Fecha de Sorteo</p>
                            <p class="font-medium"><?= date('d/m/Y', strtotime($rifa['fecha_sorteo'])) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Precio por Número</p>
                            <p class="font-medium">$<?= number_format($rifa['valor_numero'], 0, ',', '.') ?> CLP</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Números</p>
                            <p class="font-medium">Del <?= $rifa['numeros_desde'] ?> al <?= $rifa['numeros_hasta'] ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Premio Principal</p>
                            <p class="font-medium"><?= htmlspecialchars($rifa['premio_principal']) ?></p>
                        </div>
                        <?php if ($rifa['premios_secundarios']): ?>
                        <div>
                            <p class="text-sm text-gray-500">Premios Secundarios</p>
                            <p class="font-medium whitespace-pre-line"><?= htmlspecialchars($rifa['premios_secundarios']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-6 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Acciones</h2>
                <div class="space-y-2">
                    <a href="<?= url('admin/rifas/' . $rifa['id'] . '/editar') ?>" class="btn btn-primary w-full">
                        <i class="fas fa-edit mr-2"></i> Editar Rifa
                    </a>
                    <?php if ($rifa['estado'] === 'borrador'): ?>
                        <form action="<?= url('admin/rifas/' . $rifa['id'] . '/publicar') ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <button type="submit" class="btn btn-success w-full">
                                <i class="fas fa-globe mr-2"></i> Publicar Rifa
                            </button>
                        </form>
                    <?php elseif ($rifa['estado'] === 'publicada'): ?>
                        <form action="<?= url('admin/rifas/' . $rifa['id'] . '/suspender') ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <button type="submit" class="btn btn-warning w-full">
                                <i class="fas fa-pause mr-2"></i> Suspender Rifa
                            </button>
                        </form>
                    <?php elseif ($rifa['estado'] === 'suspendida'): ?>
                        <form action="<?= url('admin/rifas/' . $rifa['id'] . '/publicar') ?>" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <button type="submit" class="btn btn-success w-full">
                                <i class="fas fa-play mr-2"></i> Reactivar Rifa
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <?php if ($rifa['estado'] === 'publicada'): ?>
                        <a href="<?= url('rifas/' . $rifa['slug']) ?>" target="_blank" class="btn btn-info w-full">
                            <i class="fas fa-external-link-alt mr-2"></i> Ver Página Pública
                        </a>
                    <?php endif; ?>
                    
                    <!-- Asignar Vendedores -->
                    <a href="#" onclick="toggleVendedoresModal()" class="btn btn-secondary w-full">
                        <i class="fas fa-user-plus mr-2"></i> Asignar Vendedores
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Columna derecha: Estadísticas y Ventas -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-6 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Estadísticas de la Rifa</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-blue-50 rounded-lg text-center">
                        <p class="text-sm text-gray-500">Números Vendidos</p>
                        <p class="text-2xl font-semibold"><?= $estadisticas['numeros_vendidos'] ?> / <?= $estadisticas['total_numeros'] ?></p>
                        <p class="text-sm font-medium"><?= $estadisticas['porcentaje_vendido'] ?>%</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <p class="text-sm text-gray-500">Ingresos</p>
                        <p class="text-2xl font-semibold">$<?= number_format($estadisticas['ingreso_total'], 0, ',', '.') ?></p>
                        <p class="text-sm font-medium">CLP</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg text-center">
                        <p class="text-sm text-gray-500">Progreso</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2 mb-1">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $estadisticas['porcentaje_vendido'] ?>%"></div>
                        </div>
                        <p class="text-sm font-medium"><?= $estadisticas['numeros_disponibles'] ?> números disponibles</p>
                    </div>
                </div>
                
                <h3 class="font-medium mb-2">Descripción</h3>
                <div class="bg-white/50 p-4 rounded-lg mb-6">
                    <p class="whitespace-pre-line"><?= htmlspecialchars($rifa['descripcion']) ?></p>
                </div>
                
                <?php if (!empty($estadisticas['top_vendedores'])): ?>
                <h3 class="font-medium mb-2">Top Vendedores</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Números Vendidos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Porcentaje</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comisión</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($estadisticas['top_vendedores'] as $vendedor): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($vendedor['nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $vendedor['numeros_vendidos'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= round(($vendedor['numeros_vendidos'] / $estadisticas['numeros_vendidos']) * 100, 1) ?>%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        $<?= number_format($vendedor['numeros_vendidos'] * $rifa['valor_numero'] * 0.1, 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Vendedores Asignados -->
            <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-6 shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Vendedores Asignados</h2>
                
                <?php if (empty($vendedores)): ?>
                    <p class="text-gray-500">No hay vendedores asignados a esta rifa.</p>
                    <button onclick="toggleVendedoresModal()" class="mt-2 btn btn-sm btn-primary">
                        <i class="fas fa-user-plus mr-2"></i> Asignar Vendedores
                    </button>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Asignación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comisión</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($vendedores as $vendedor): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <?php if ($vendedor['imagen']): ?>
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="<?= url('public' . $vendedor['imagen']) ?>" alt="">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vendedor['nombre']) ?></div>
                                                    <div class="text-sm text-gray-500"><?= htmlspecialchars($vendedor['email']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= date('d/m/Y', strtotime($vendedor['fecha_asignacion'])) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $vendedor['comision'] ?>%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="<?= url('admin/vendedores/' . $vendedor['id'] . '/desasignar-rifa') ?>" method="POST" class="inline-block">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                <input type="hidden" name="id_rifa" value="<?= $rifa['id'] ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de desasignar este vendedor?')">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Asignar Vendedores -->
<div id="vendedoresModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Asignar Vendedores</h3>
            <button onclick="toggleVendedoresModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?= url('admin/vendedores/asignar-rifa') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <input type="hidden" name="id_rifa" value="<?= $rifa['id'] ?>">
            
            <div class="mb-4">
                <label for="vendedor" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Vendedor</label>
                <select name="id_vendedor" id="vendedor" class="form-select w-full" required>
                    <option value="">Seleccionar...</option>
                    <!-- Aquí se cargarían dinámicamente los vendedores del admin que no están asignados -->
                </select>
            </div>
            
            <div class="mb-4">
                <label for="comision" class="block text-sm font-medium text-gray-700 mb-1">Comisión (%)</label>
                <input type="number" name="comision" id="comision" class="form-input w-full" value="10" min="0" max="50" step="0.5" required>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="toggleVendedoresModal()" class="btn btn-secondary">Cancelar</button>
                <button type="submit" class="btn btn-primary">Asignar</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleVendedoresModal() {
    const modal = document.getElementById('vendedoresModal');
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Cargar vendedores disponibles vía AJAX
        fetch('<?= url('api/admin/vendedores-disponibles/' . $rifa['id']) ?>')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('vendedor');
                select.innerHTML = '<option value="">Seleccionar...</option>';
                
                if (data.vendedores && data.vendedores.length > 0) {
                    data.vendedores.forEach(vendedor => {
                        const option = document.createElement('option');
                        option.value = vendedor.id;
                        option.textContent = vendedor.nombre;
                        select.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.disabled = true;
                    option.textContent = 'No hay vendedores disponibles';
                    select.appendChild(option);
                }
            });
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
