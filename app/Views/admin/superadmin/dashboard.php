<?php
// Vista del dashboard de SuperAdmin
$title = $title ?? 'Panel SuperAdmin - Rifas Chile';
?>

<!-- Incluir la cabecera del admin panel -->
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard SuperAdmin</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tarjeta de Estadísticas - Total Usuarios -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-blue-500">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Usuarios</dt>
                            <dd class="text-2xl font-semibold text-gray-900"><?= $stats['total_usuarios'] ?? 0 ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="<?= url('superadmin/usuarios') ?>" class="font-medium text-blue-600 hover:text-blue-500">Ver todos</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Estadísticas - Administradores -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-green-500">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Administradores</dt>
                            <dd class="text-2xl font-semibold text-gray-900"><?= $stats['total_admins'] ?? 0 ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="<?= url('superadmin/usuarios?tipo=admin') ?>" class="font-medium text-green-600 hover:text-green-500">Filtrar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Estadísticas - Vendedores -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-yellow-500">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Vendedores</dt>
                            <dd class="text-2xl font-semibold text-gray-900"><?= $stats['total_vendedores'] ?? 0 ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="<?= url('superadmin/usuarios?tipo=vendedor') ?>" class="font-medium text-yellow-600 hover:text-yellow-500">Filtrar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Estadísticas - Compradores -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-purple-500">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Compradores</dt>
                            <dd class="text-2xl font-semibold text-gray-900"><?= $stats['total_compradores'] ?? 0 ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="<?= url('superadmin/usuarios?tipo=comprador') ?>" class="font-medium text-purple-600 hover:text-purple-500">Filtrar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Control Principal -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Panel de Control Principal</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-3">Acciones Rápidas</h3>
                <div class="space-y-3">
                    <a href="<?= url('superadmin/usuarios/crear') ?>" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <span class="bg-blue-500 rounded-md p-2">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700">Crear Nuevo Usuario</span>
                    </a>
                    <a href="<?= url('superadmin/config') ?>" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <span class="bg-green-500 rounded-md p-2">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700">Configuración del Sistema</span>
                    </a>
                    <a href="<?= url('superadmin/seguridad') ?>" class="flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                        <span class="bg-red-500 rounded-md p-2">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700">Panel de Seguridad</span>
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-3">Actividad Reciente</h3>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    <!-- Aquí se mostrarían los logs de actividad reciente -->
                    <p class="text-gray-500 text-sm italic">No hay actividad reciente para mostrar.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
