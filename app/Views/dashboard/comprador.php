<?php
// Set page variables
$title = $title ?? 'Mi Dashboard - Rifas Chile';
?>

<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white font-semibold">
                                <?php 
                                    $primeraLetraNombre = isset($user['nombre']) ? strtoupper(substr($user['nombre'], 0, 1)) : 'U';
                                    $primeraLetraApellido = isset($user['apellidos']) ? strtoupper(substr($user['apellidos'], 0, 1)) : '';
                                    echo $primeraLetraNombre . $primeraLetraApellido;
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            ¡Hola, <?php echo htmlspecialchars($user['nombre']); ?>!
                        </h1>
                        <p class="text-sm text-gray-500">
                            Bienvenido a tu panel de usuario
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">                    <a href="<?= url('perfil') ?>" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a><a href="<?= url('logout') ?>" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Mis Tickets -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Mis Tickets</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            <?php echo number_format($stats['mis_tickets']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Rifas Participando -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rifas Participando</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            <?php echo number_format($stats['rifas_participando']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Premios Ganados -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Premios Ganados</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            <?php echo number_format($stats['premios_ganados']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gasto Total -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Gasto Total</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            $<?php echo number_format($stats['gasto_total']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Mis Últimos Tickets -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Mis Últimos Tickets</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($misTickets)): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes tickets aún</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza participando en nuestras rifas.</p>
                            <div class="mt-6">
                                <a href="/rifas" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Ver Rifas Disponibles
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($misTickets as $ticket): ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($ticket['rifa_nombre']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                Ticket #<?php echo htmlspecialchars($ticket['numero']); ?>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">
                                                $<?php echo number_format($ticket['valor']); ?>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo date('d/m/Y', strtotime($ticket['fecha_compra'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Rifas Activas -->
            <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Rifas Activas</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($rifasActivas)): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay rifas activas</h3>
                            <p class="mt-1 text-sm text-gray-500">Vuelve pronto para ver nuevas rifas.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ($rifasActivas as $rifa): ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($rifa['nombre']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                Valor: $<?php echo number_format($rifa['valor_numero']); ?>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Sorteo: <?php echo date('d/m/Y', strtotime($rifa['fecha_sorteo'])); ?>
                                            </p>
                                        </div>
                                        <div class="ml-4">
                                            <a href="/rifas/<?php echo htmlspecialchars($rifa['slug']); ?>" 
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                                Ver Rifa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-6 text-center">
                            <a href="/rifas" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                Ver todas las rifas →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Próximos Sorteos -->
        <?php if (!empty($proximosSorteos)): ?>
            <div class="mt-8">
                <div class="bg-white bg-opacity-80 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl shadow-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Próximos Sorteos</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php foreach ($proximosSorteos as $sorteo): ?>
                                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($sorteo['rifa_nombre']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                <?php echo date('d/m/Y H:i', strtotime($sorteo['fecha_sorteo'])); ?>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Mis tickets: <?php echo $sorteo['mis_tickets']; ?>
                                            </p>
                                        </div>
                                        <div class="text-yellow-600">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
