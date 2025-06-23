<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary">Gestión de Rifas</h1>
        <a href="<?= url('admin/rifas/crear') ?>" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i> Crear Nueva Rifa
        </a>
    </div>

    <?php require_once __DIR__ . '/../../layouts/alerts.php'; ?>

    <!-- Filtros -->
    <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-4 mb-6 shadow-lg">
        <form action="<?= url('admin/rifas') ?>" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="w-full md:w-1/4">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" id="estado" class="form-select w-full">
                    <option value="">Todos</option>
                    <option value="borrador">Borrador</option>
                    <option value="publicada">Publicada</option>
                    <option value="suspendida">Suspendida</option>
                    <option value="finalizada">Finalizada</option>
                </select>
            </div>
            <div class="w-full md:w-1/4">
                <label for="orden" class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                <select name="orden" id="orden" class="form-select w-full">
                    <option value="recientes">Más recientes</option>
                    <option value="antiguos">Más antiguos</option>
                    <option value="nombre">Nombre A-Z</option>
                    <option value="fecha_sorteo">Fecha de sorteo</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Rifas -->
    <div class="overflow-x-auto">
        <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200/30">
                <thead class="bg-gray-100/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rifa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Sorteo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Números</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-md divide-y divide-gray-200/30">
                    <?php if (empty($rifas)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay rifas disponibles. <a href="<?= url('admin/rifas/crear') ?>" class="text-primary hover:underline">Crear una nueva rifa</a>.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($rifas as $rifa) : ?>
                            <tr class="hover:bg-gray-50/30 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if ($rifa['imagen']) : ?>
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover" src="<?= url('public' . $rifa['imagen']) ?>" alt="<?= htmlspecialchars($rifa['titulo']) ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($rifa['titulo']) ?></div>
                                            <div class="text-xs text-gray-500">Creada: <?= date('d/m/Y', strtotime($rifa['created_at'])) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d/m/Y', strtotime($rifa['fecha_sorteo'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php
                                        switch ($rifa['estado']) {
                                            case 'borrador':
                                                echo 'bg-gray-100 text-gray-800';
                                                break;
                                            case 'publicada':
                                                echo 'bg-green-100 text-green-800';
                                                break;
                                            case 'suspendida':
                                                echo 'bg-orange-100 text-orange-800';
                                                break;
                                            case 'finalizada':
                                                echo 'bg-blue-100 text-blue-800';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800';
                                        }
                                        ?>">
                                        <?= ucfirst($rifa['estado']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php
                                    $vendidos = isset($rifa['estadisticas']['numeros_vendidos']) ? $rifa['estadisticas']['numeros_vendidos'] : 0;
                                    $total = isset($rifa['cantidad_numeros']) ? $rifa['cantidad_numeros'] : ($rifa['numeros_hasta'] - $rifa['numeros_desde'] + 1);
                                    $porcentaje = $total > 0 ? round(($vendidos / $total) * 100, 1) : 0;
                                    ?>
                                    <div class="flex items-center">
                                        <span class="mr-2"><?= $vendidos ?>/<?= $total ?></span>
                                        <div class="w-24 h-2 bg-gray-200 rounded-full">
                                            <div class="h-2 bg-primary rounded-full" style="width: <?= $porcentaje ?>%"></div>
                                        </div>
                                        <span class="ml-2 text-xs"><?= $porcentaje ?>%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    $<?= number_format($rifa['valor_numero'], 0, ',', '.') ?> CLP
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?= url('admin/rifas/' . $rifa['id']) ?>" class="text-primary hover:text-primary-dark transition" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= url('admin/rifas/' . $rifa['id'] . '/editar') ?>" class="text-blue-600 hover:text-blue-900 transition" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($rifa['estado'] === 'borrador') : ?>
                                            <form action="<?= url('admin/rifas/' . $rifa['id'] . '/publicar') ?>" method="POST" class="inline">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                <button type="submit" class="text-green-600 hover:text-green-900 transition" title="Publicar">
                                                    <i class="fas fa-globe"></i>
                                                </button>
                                            </form>
                                        <?php elseif ($rifa['estado'] === 'publicada') : ?>
                                            <form action="<?= url('admin/rifas/' . $rifa['id'] . '/suspender') ?>" method="POST" class="inline">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                <button type="submit" class="text-orange-600 hover:text-orange-900 transition" title="Suspender">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
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
