<?php
// Set page variables
$title = $title ?? 'Dashboard Administrador - Rifas Chile';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 py-8">
    <!-- Main Content Container -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">¡Bienvenido, <?= htmlspecialchars($user['nombre']) ?>!</h1>
            <p class="text-gray-300">Panel de Administrador de Rifas</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Rifas Activas -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Rifas Activas</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['rifas_activas']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Rifas -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Total Rifas</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['rifas_total']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vendedores Activos -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Vendedores Activos</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['vendedores_activos']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ventas del Mes -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Ventas del Mes</p>
                        <p class="text-2xl font-semibold text-white">
                            $<?php echo number_format($stats['ventas_mes']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Acciones Rápidas</h2>
            <div class="flex flex-wrap gap-4">
                <a href="<?= url('admin/rifas/crear') ?>" class="glass-button-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Rifa
                </a>
                <a href="<?= url('admin/vendedores/crear') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Nuevo Vendedor
                </a>
                <a href="<?= url('admin/ventas') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Ver Ventas
                </a>
                <a href="<?= url('admin/estadisticas') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Estadísticas
                </a>
            </div>
        </div>

        <!-- Recent Rifas -->
        <div class="glass-card p-6 rounded-xl mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Rifas Recientes</h2>
            
            <?php if (empty($recentRifas)): ?>
                <p class="text-gray-300">No hay rifas recientes.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha de Sorteo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Progreso</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($recentRifas as $rifa): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($rifa['nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $rifa['estado'] === 'activa' ? 'bg-green-100 text-green-800' : 
                                               ($rifa['estado'] === 'pausada' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                            <?= ucfirst(htmlspecialchars($rifa['estado'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= ucfirst(htmlspecialchars($rifa['tipo_inventario'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= date('d/m/Y', strtotime($rifa['fecha_sorteo'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= ($rifa['numeros_vendidos'] / $rifa['total_numeros']) * 100 ?>%"></div>
                                        </div>
                                        <span class="text-xs text-gray-400"><?= $rifa['numeros_vendidos'] ?> de <?= $rifa['total_numeros'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?= url('admin/rifas/' . $rifa['id']) ?>" class="text-blue-400 hover:text-blue-300 mr-3">
                                            Ver
                                        </a>
                                        <a href="<?= url('admin/rifas/' . $rifa['id'] . '/editar') ?>" class="text-green-400 hover:text-green-300">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="mt-4 text-right">
                <a href="<?= url('admin/rifas') ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                    Ver todas las rifas →
                </a>
            </div>
        </div>

        <!-- Pending Approvals -->
        <?php if (!empty($pendingApprovals)): ?>
        <div class="glass-card p-6 rounded-xl mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Aprobaciones Pendientes</h2>
            <div class="space-y-4">
                <?php foreach ($pendingApprovals as $approval): ?>
                    <div class="border border-gray-700 border-opacity-50 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white font-medium"><?= htmlspecialchars($approval['titulo']) ?></p>
                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($approval['descripcion']) ?></p>
                            </div>
                            <div>
                                <button type="button" onclick="aprobar(<?= $approval['id'] ?>)" class="text-green-400 hover:text-green-300 mr-3">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="rechazar(<?= $approval['id'] ?>)" class="text-red-400 hover:text-red-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.glass-button {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.glass-button:hover {
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.glass-button-primary {
    background: rgba(37, 99, 235, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.glass-button-primary:hover {
    background: rgba(29, 78, 216, 0.9);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}
</style>

<script>
function aprobar(id) {
    if (confirm('¿Estás seguro de aprobar este elemento?')) {
        // Implementar llamada AJAX para aprobar
        rifasUI.showNotification('Elemento aprobado exitosamente', 'success');
    }
}

function rechazar(id) {
    if (confirm('¿Estás seguro de rechazar este elemento?')) {
        // Implementar llamada AJAX para rechazar
        rifasUI.showNotification('Elemento rechazado', 'error');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Si hay un mensaje flash, mostrarlo
    <?php if (isset($_SESSION['flash']['success'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['success']) ?>', 'success');
    <?php endif; ?>
    
    <?php if (isset($_SESSION['flash']['error'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['error']) ?>', 'error');
    <?php endif; ?>

    // Inicialización de gráficos (si se necesitan)
    // Ejemplo: drawVentasChart();
});
</script>
