<?php
// Set page variables
$title = $title ?? 'Dashboard Vendedor - Rifas Chile';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 py-8">
    <!-- Main Content Container -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">¡Bienvenido, <?= htmlspecialchars($user['nombre']) ?>!</h1>
            <p class="text-gray-300">Panel de Vendedor de Rifas</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Mis Rifas -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Mis Rifas</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['mis_rifas']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Rifas Activas -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
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

            <!-- Tickets Vendidos -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Tickets Vendidos</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['tickets_vendidos']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ingresos del Mes -->
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
                        <p class="text-sm font-medium text-gray-300">Ingresos del Mes</p>
                        <p class="text-2xl font-semibold text-white">
                            $<?php echo number_format($stats['ingresos_mes']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Acciones Rápidas</h2>
            <div class="flex flex-wrap gap-4">
                <a href="<?= url('vendedor/rifas') ?>" class="glass-button-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Mis Rifas
                </a>
                <a href="<?= url('vendedor/ventas') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    Mis Ventas
                </a>
            </div>
        </div>

        <!-- Mis Rifas -->
        <div class="glass-card p-6 rounded-xl mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Mis Rifas Asignadas</h2>
            
            <?php if (empty($misRifas)): ?>
                <p class="text-gray-300">No tienes rifas asignadas actualmente.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($misRifas as $rifa): ?>
                        <div class="glass-card p-5 rounded-lg border border-gray-700 border-opacity-50">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-medium text-white"><?= htmlspecialchars($rifa['nombre']) ?></h3>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $rifa['estado'] === 'activa' ? 'bg-green-100 text-green-800' : 
                                       ($rifa['estado'] === 'pausada' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst(htmlspecialchars($rifa['estado'])) ?>
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-400 mt-1">
                                Sorteo: <?= date('d/m/Y', strtotime($rifa['fecha_sorteo'])) ?>
                            </p>
                            
                            <div class="mt-3">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>Progreso</span>
                                    <span><?= $rifa['numeros_vendidos'] ?> de <?= $rifa['total_numeros'] ?></span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?= ($rifa['numeros_vendidos'] / $rifa['total_numeros']) * 100 ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-end space-x-2">
                                <a href="<?= url('vendedor/rifas/' . $rifa['id']) ?>" class="glass-button-small">
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="mt-4 text-right">
                <a href="<?= url('vendedor/rifas') ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                    Ver todas mis rifas →
                </a>
            </div>
        </div>

        <!-- Ventas Recientes -->
        <div class="glass-card p-6 rounded-xl">
            <h2 class="text-xl font-semibold text-white mb-4">Ventas Recientes</h2>
            
            <?php if (empty($ventasRecientes)): ?>
                <p class="text-gray-300">No hay ventas recientes.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rifa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Número(s)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($ventasRecientes as $venta): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($venta['rifa_nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($venta['cliente_nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($venta['numeros']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $venta['estado'] === 'pagado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                            <?= ucfirst(htmlspecialchars($venta['estado'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200 text-right">
                                        $<?= number_format($venta['monto']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="mt-4 text-right">
                <a href="<?= url('vendedor/ventas') ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                    Ver todas mis ventas →
                </a>
            </div>
        </div>
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

.glass-button-small {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.glass-button-small:hover {
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
document.addEventListener('DOMContentLoaded', function() {
    // Si hay un mensaje flash, mostrarlo
    <?php if (isset($_SESSION['flash']['success'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['success']) ?>', 'success');
    <?php endif; ?>
    
    <?php if (isset($_SESSION['flash']['error'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['error']) ?>', 'error');
    <?php endif; ?>
});
</script>
