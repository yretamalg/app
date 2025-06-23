<?php
// Set page variables
$title = $title ?? 'Dashboard Super Admin - Rifas Chile';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 py-8">
    <!-- Main Content Container -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Panel Super Administrador</h1>
            <p class="text-gray-300">Control total del sistema</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Usuarios -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-300">Total Usuarios</p>
                        <p class="text-2xl font-semibold text-white">
                            <?php echo number_format($stats['usuarios_total']); ?>
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

            <!-- Total Rifas -->
            <div class="glass-card p-6 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
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
                <a href="<?= url('superadmin/usuarios/crear') ?>" class="glass-button-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Crear Usuario
                </a>
                <a href="<?= url('superadmin/configuracion') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configuración
                </a>
                <a href="<?= url('superadmin/seguridad') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Seguridad
                </a>
                <a href="<?= url('superadmin/logs') ?>" class="glass-button">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Logs
                </a>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="glass-card p-6 rounded-xl mb-8">
            <h2 class="text-xl font-semibold text-white mb-4">Usuarios Recientes</h2>
            
            <?php if (empty($recentUsers)): ?>
                <p class="text-gray-300">No hay usuarios recientes.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">RUT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($recentUsers as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellidos']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($user['rut']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $user['tipo'] === 'admin' ? 'bg-blue-100 text-blue-800' : 
                                              ($user['tipo'] === 'vendedor' ? 'bg-green-100 text-green-800' : 
                                              ($user['tipo'] === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) ?>">
                                            <?= ucfirst(htmlspecialchars($user['tipo'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $user['estado'] === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= ucfirst(htmlspecialchars($user['estado'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?= url('superadmin/usuarios/' . $user['id'] . '/editar') ?>" class="text-blue-400 hover:text-blue-300 mr-3">
                                            Editar
                                        </a>
                                        <form action="<?= url('superadmin/usuarios/' . $user['id'] . '/impersonar') ?>" method="post" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?? '' ?>">
                                            <button type="submit" class="text-yellow-400 hover:text-yellow-300">
                                                Impersonar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="mt-4 text-right">
                <a href="<?= url('superadmin/usuarios') ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                    Ver todos los usuarios →
                </a>
            </div>
        </div>

        <!-- Recent Rifas -->
        <div class="glass-card p-6 rounded-xl">
            <h2 class="text-xl font-semibold text-white mb-4">Rifas Recientes</h2>
            
            <?php if (empty($recentRifas)): ?>
                <p class="text-gray-300">No hay rifas recientes.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Admin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha de Sorteo</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php foreach ($recentRifas as $rifa): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($rifa['nombre']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                        <?= htmlspecialchars($rifa['admin_nombre'] ?? 'N/A') ?>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="<?= url('admin/rifas/' . $rifa['id']) ?>" class="text-blue-400 hover:text-blue-300">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Top Vendedores -->
        <?php if (!empty($topVendedores)): ?>
        <div class="glass-card p-6 rounded-xl mt-8">
            <h2 class="text-xl font-semibold text-white mb-4">Mejores Vendedores</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($topVendedores as $vendedor): ?>
                    <div class="glass-card p-5 rounded-lg border border-gray-700 border-opacity-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center text-white font-bold">
                                    <?= strtoupper(substr($vendedor['nombre'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-medium"><?= htmlspecialchars($vendedor['nombre'] . ' ' . $vendedor['apellidos']) ?></p>
                                <p class="text-gray-400 text-sm"><?= htmlspecialchars($vendedor['email']) ?></p>
                            </div>
                        </div>
                        
                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs text-gray-400">Total Ventas</p>
                                <p class="text-lg text-white font-semibold"><?= number_format($vendedor['total_ventas']) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Total Ingresos</p>
                                <p class="text-lg text-white font-semibold">$<?= number_format($vendedor['total_ingresos']) ?></p>
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
document.addEventListener('DOMContentLoaded', function() {
    // Si hay un mensaje flash, mostrarlo
    <?php if (isset($_SESSION['flash']['success'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['success']) ?>', 'success');
    <?php endif; ?>
    
    <?php if (isset($_SESSION['flash']['error'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['error']) ?>', 'error');
    <?php endif; ?>

    // Si hay un mensaje de advertencia de seguridad, mostrarlo
    <?php if (isset($_SESSION['flash']['security_warning'])): ?>
        rifasUI.showNotification('<?= htmlspecialchars($_SESSION['flash']['security_warning']) ?>', 'warning');
    <?php endif; ?>
});
</script>
