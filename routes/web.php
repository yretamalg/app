<?php

// Public routes
$router->get('/', 'HomeController@index', 'home');
$router->get('/rifas', 'Rifa@publicIndex', 'rifas.public');
$router->get('/rifas/([a-z0-9-]+)', 'Rifa@publicShow', 'rifas.show');
$router->get('/vendedor/([a-z0-9-]+)', 'Vendedor@publicShow', 'vendedor.show');

// Static pages
$router->get('/politicas-privacidad', 'Page@privacy', 'privacy');
$router->get('/terminos-condiciones', 'Page@terms', 'terms');
$router->get('/contacto', 'Page@contact', 'contact');
$router->post('/contacto', 'Page@submitContact', 'contact.submit');

// Authentication routes
$router->get('/login', 'AuthController@login', 'login');
$router->post('/auth/login', 'AuthController@processLogin', 'login.submit');
$router->get('/register', 'AuthController@register', 'register');
$router->post('/auth/register', 'AuthController@processRegister', 'register.submit');
$router->get('/forgot-password', 'AuthController@forgotPassword', 'forgot-password');
$router->post('/auth/forgot-password', 'AuthController@processForgotPassword', 'forgot-password.submit');
$router->get('/reset-password', 'AuthController@resetPassword', 'reset-password');
$router->post('/auth/reset-password', 'AuthController@processResetPassword', 'reset-password.submit');
$router->get('/logout', 'AuthController@logout', 'logout');
$router->get('/recuperar-password', 'AuthController@forgotPasswordForm', 'password.forgot');
$router->post('/recuperar-password', 'AuthController@forgotPassword', 'password.forgot.submit');
$router->get('/reset-password', 'AuthController@resetPasswordForm', 'password.reset');
$router->post('/reset-password', 'AuthController@resetPassword', 'password.reset.submit');

// Dashboard and user area routes
$router->get('/dashboard', 'DashboardController@index', 'dashboard');
$router->get('/perfil', 'DashboardController@profile', 'profile');
$router->post('/perfil', 'DashboardController@updateProfile', 'profile.update');

// SuperAdmin routes (hidden)
$router->get('/superadmin/login', 'SuperAdmin@loginForm', 'superadmin.login');
$router->post('/superadmin/login', 'SuperAdmin@login', 'superadmin.login.submit');
$router->get('/superadmin/logout', 'SuperAdmin@logout', 'superadmin.logout');
$router->get('/superadmin', 'SuperAdmin@dashboard', 'superadmin.dashboard');
$router->get('/superadmin/usuarios', 'SuperAdmin@usuarios', 'superadmin.usuarios');
$router->get('/superadmin/usuarios/crear', 'SuperAdmin@crearUsuario', 'superadmin.usuarios.crear');
$router->post('/superadmin/usuarios/crear', 'SuperAdmin@guardarUsuario', 'superadmin.usuarios.store');
$router->get('/superadmin/usuarios/([0-9]+)/editar', 'SuperAdmin@editarUsuario', 'superadmin.usuarios.editar');
$router->post('/superadmin/usuarios/([0-9]+)/editar', 'SuperAdmin@actualizarUsuario', 'superadmin.usuarios.update');
$router->post('/superadmin/usuarios/([0-9]+)/impersonar', 'SuperAdmin@impersonar', 'superadmin.usuarios.impersonate');
$router->get('/superadmin/configuracion', 'SuperAdmin@configuracion', 'superadmin.config');
$router->post('/superadmin/configuracion', 'SuperAdmin@guardarConfiguracion', 'superadmin.config.save');
$router->get('/superadmin/seguridad', 'SuperAdmin@seguridad', 'superadmin.security');
$router->post('/superadmin/seguridad', 'SuperAdmin@guardarSeguridad', 'superadmin.security.save');
$router->get('/superadmin/logs', 'SuperAdmin@logs', 'superadmin.logs');

// Admin routes
$router->get('/admin', 'Admin@dashboard', 'admin.dashboard');
$router->get('/admin/perfil', 'Admin@perfil', 'admin.profile');
$router->post('/admin/perfil', 'Admin@actualizarPerfil', 'admin.profile.update');

// Rifas management
$router->get('/admin/rifas', 'Admin@rifas', 'admin.rifas');
$router->get('/admin/rifas/crear', 'Admin@crearRifa', 'admin.rifas.crear');
$router->post('/admin/rifas/crear', 'Admin@guardarRifa', 'admin.rifas.store');
$router->get('/admin/rifas/([0-9]+)/editar', 'Admin@editarRifa', 'admin.rifas.editar');
$router->post('/admin/rifas/([0-9]+)/editar', 'Admin@actualizarRifa', 'admin.rifas.update');
$router->get('/admin/rifas/([0-9]+)', 'Admin@verRifa', 'admin.rifas.show');
$router->post('/admin/rifas/([0-9]+)/publicar', 'Admin@publicarRifa', 'admin.rifas.publish');
$router->post('/admin/rifas/([0-9]+)/suspender', 'Admin@suspenderRifa', 'admin.rifas.suspend');

// Vendedores management
$router->get('/admin/vendedores', 'Admin@vendedores', 'admin.vendedores');
$router->get('/admin/vendedores/crear', 'Admin@crearVendedor', 'admin.vendedores.crear');
$router->post('/admin/vendedores/crear', 'Admin@guardarVendedor', 'admin.vendedores.store');
$router->get('/admin/vendedores/([0-9]+)/editar', 'Admin@editarVendedor', 'admin.vendedores.editar');
$router->post('/admin/vendedores/([0-9]+)/editar', 'Admin@actualizarVendedor', 'admin.vendedores.update');
$router->post('/admin/vendedores/([0-9]+)/asignar-rifa', 'Admin@asignarRifa', 'admin.vendedores.assign');

// Sales and statistics
$router->get('/admin/ventas', 'Admin@ventas', 'admin.ventas');
$router->get('/admin/estadisticas', 'Admin@estadisticas', 'admin.stats');

// Vendedor routes
$router->get('/vendedor', 'Vendedor@dashboard', 'vendedor.dashboard');
$router->get('/vendedor/perfil', 'Vendedor@perfil', 'vendedor.profile');
$router->post('/vendedor/perfil', 'Vendedor@actualizarPerfil', 'vendedor.profile.update');
$router->get('/vendedor/rifas', 'Vendedor@rifas', 'vendedor.rifas');
$router->get('/vendedor/rifas/([0-9]+)', 'Vendedor@verRifa', 'vendedor.rifas.show');
$router->post('/vendedor/vender', 'Vendedor@vender', 'vendedor.vender');
$router->get('/vendedor/ventas', 'Vendedor@ventas', 'vendedor.ventas');

// API routes
$router->get('/api/notificaciones', 'Api@notificaciones', 'api.notifications');
$router->post('/api/notificaciones/marcar-leida', 'Api@marcarNotificacionLeida', 'api.notifications.read');
$router->get('/api/rifas/([0-9]+)/numeros', 'Api@numerosRifa', 'api.rifas.numbers');
$router->get('/api/estadisticas/dashboard', 'Api@estadisticasDashboard', 'api.stats.dashboard');

// Installation route (only if not installed)
if (!file_exists(__DIR__ . '/../.env')) {
    $router->get('/install', 'Install@index', 'install');
    $router->post('/install', 'Install@process', 'install.process');
}
