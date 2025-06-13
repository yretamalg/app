<!-- Sidebar Navigation -->
<nav class="glass-sidebar fixed left-0 top-0 w-64 h-screen p-6 z-40">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center mb-8">
            <h1 class="text-2xl font-bold text-white">Rifas Chile</h1>
        </div>

        <!-- User Info -->
        <div class="glass-card p-4 mb-6">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                    <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                </div>
                <div class="ml-3">
                    <p class="text-white font-medium"><?= $user['nombre'] ?> <?= $user['apellidos'] ?? '' ?></p>
                    <p class="text-gray-300 text-sm capitalize"><?= $user['tipo'] ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 space-y-2">
            <?php if ($userType === 'superadmin'): ?>
                <!-- SuperAdmin Menu -->
                <a href="/superadmin" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/superadmin' ? 'active' : '' ?>">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="/superadmin/usuarios" class="nav-item">
                    <span class="nav-icon">👥</span>
                    Usuarios
                </a>
                <a href="/superadmin/configuracion" class="nav-item">
                    <span class="nav-icon">⚙️</span>
                    Configuración
                </a>
                <a href="/superadmin/seguridad" class="nav-item">
                    <span class="nav-icon">🔒</span>
                    Seguridad
                </a>
                <a href="/superadmin/logs" class="nav-item">
                    <span class="nav-icon">📋</span>
                    Logs
                </a>

            <?php elseif ($userType === 'admin'): ?>
                <!-- Admin Menu -->
                <a href="/admin" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="/admin/rifas" class="nav-item">
                    <span class="nav-icon">🎲</span>
                    Mis Rifas
                </a>
                <a href="/admin/vendedores" class="nav-item">
                    <span class="nav-icon">👨‍💼</span>
                    Vendedores
                </a>
                <a href="/admin/ventas" class="nav-item">
                    <span class="nav-icon">💰</span>
                    Ventas
                </a>
                <a href="/admin/estadisticas" class="nav-item">
                    <span class="nav-icon">📈</span>
                    Estadísticas
                </a>
                <a href="/admin/perfil" class="nav-item">
                    <span class="nav-icon">👤</span>
                    Mi Perfil
                </a>

            <?php elseif ($userType === 'vendedor'): ?>
                <!-- Vendedor Menu -->
                <a href="/vendedor" class="nav-item <?= $_SERVER['REQUEST_URI'] === '/vendedor' ? 'active' : '' ?>">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="/vendedor/rifas" class="nav-item">
                    <span class="nav-icon">🎲</span>
                    Mis Rifas
                </a>
                <a href="/vendedor/ventas" class="nav-item">
                    <span class="nav-icon">💰</span>
                    Mis Ventas
                </a>
                <a href="/vendedor/perfil" class="nav-item">
                    <span class="nav-icon">👤</span>
                    Mi Perfil
                </a>
            <?php endif; ?>
        </div>

        <!-- Logout -->
        <div class="pt-4 border-t border-gray-600">
            <a href="/logout" class="nav-item text-red-400 hover:text-red-300">
                <span class="nav-icon">🚪</span>
                Cerrar Sesión
            </a>
        </div>
    </div>
</nav>

<!-- Top Navigation Bar -->
<header class="glass-nav fixed top-0 left-64 right-0 h-16 px-6 flex items-center justify-between z-30">
    <!-- Page Title -->
    <div>
        <h2 class="text-xl font-semibold text-white"><?= $pageTitle ?? 'Dashboard' ?></h2>
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="notification-bell relative">
            <button id="notification-bell" data-dropdown-toggle="notifications" class="glass-button p-2 relative">
                🔔
                <span id="notification-badge" class="notification-badge hidden">0</span>
            </button>
            
            <!-- Notifications Dropdown -->
            <div id="notification-dropdown" data-dropdown-menu="notifications" class="absolute right-0 mt-2 w-80 glass-card max-h-96 overflow-y-auto hidden">
                <div class="p-4 border-b border-gray-600">
                    <h3 class="text-white font-medium">Notificaciones</h3>
                </div>
                <div class="notification-list">
                    <!-- Notifications will be loaded here via JavaScript -->
                </div>
                <div class="p-4 border-t border-gray-600">
                    <a href="/notificaciones" class="text-blue-400 hover:text-blue-300 text-sm">
                        Ver todas las notificaciones
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <?php if ($userType === 'admin'): ?>
            <a href="/admin/rifas/crear" class="glass-button-primary">
                ➕ Nueva Rifa
            </a>
        <?php endif; ?>

        <!-- User Menu -->
        <div class="relative">
            <button data-dropdown-toggle="user-menu" class="flex items-center glass-button p-2">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                </div>
                <span class="ml-2 text-white">▼</span>
            </button>
            
            <!-- User Dropdown -->
            <div data-dropdown-menu="user-menu" class="absolute right-0 mt-2 w-48 glass-card hidden">
                <div class="p-2">
                    <a href="/<?= $userType ?>/perfil" class="block px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                        👤 Mi Perfil
                    </a>
                    <a href="/configuracion" class="block px-4 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                        ⚙️ Configuración
                    </a>
                    <hr class="my-2 border-gray-600">
                    <a href="/logout" class="block px-4 py-2 text-red-400 hover:bg-red-500 hover:bg-opacity-10 rounded">
                        🚪 Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.nav-item {
    @apply flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-all duration-200;
}

.nav-item.active {
    @apply text-white bg-white bg-opacity-20;
}

.nav-icon {
    @apply mr-3 text-lg;
}
</style>
