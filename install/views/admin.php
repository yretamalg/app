<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Administrador - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-lg w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Crear Usuario Administrador</h1>
                <p class="text-gray-300">Configura la cuenta del administrador principal</p>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span class="text-blue-300">Bienvenida</span>
                    <span class="text-blue-300">Requisitos</span>
                    <span class="text-blue-300">Base de Datos</span>
                    <span class="text-blue-300">Administrador</span>
                    <span>Finalizar</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>

            <!-- Messages -->
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-300 rounded-xl text-red-100">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-300 rounded-xl text-green-100">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Admin Form -->
            <form method="POST" action="?step=admin">
                <h2 class="text-lg font-semibold text-white mb-4">Datos del Administrador</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nombres</label>
                            <input type="text" name="admin_nombres" value="<?php echo $_POST['admin_nombres'] ?? 'Administrador'; ?>" required
                                   class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                   placeholder="Juan Carlos">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Apellidos</label>
                            <input type="text" name="admin_apellidos" value="<?php echo $_POST['admin_apellidos'] ?? 'Sistema'; ?>" required
                                   class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                   placeholder="González López">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0V5a2 2 0 014 0v1"></path>
                            </svg>
                            RUT (opcional)
                        </label>
                        <input type="text" name="admin_rut" value="<?php echo $_POST['admin_rut'] ?? ''; ?>"
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="12.345.678-9"
                               pattern="[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9Kk]{1}">
                        <p class="text-xs text-gray-400 mt-1">Formato: 12.345.678-9 (opcional pero recomendado)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            Email
                        </label>
                        <input type="email" name="admin_email" value="<?php echo $_POST['admin_email'] ?? 'admin@rifappplus.cl'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="admin@midominio.cl">
                        <p class="text-xs text-gray-400 mt-1">Este será tu email para acceder al sistema</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Contraseña
                        </label>
                        <input type="password" name="admin_password" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Mínimo 8 caracteres"
                               minlength="8">
                        <p class="text-xs text-gray-400 mt-1">Mínimo 8 caracteres, recomendamos usar mayúsculas, números y símbolos</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Confirmar Contraseña
                        </label>
                        <input type="password" name="admin_confirm_password" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Repite la contraseña"
                               minlength="8">
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="glassmorphism rounded-xl p-4 mt-6 border-l-4 border-yellow-400">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-yellow-300 font-medium text-sm">Importante - Seguridad</h3>
                            <p class="text-gray-300 text-xs mt-1">
                                Este usuario tendrá acceso completo al sistema. Usa una contraseña segura y 
                                cambia las credenciales predeterminadas después de la instalación.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-4 mt-6">
                    <a href="?step=database" class="flex-1 px-4 py-2 bg-gray-600 bg-opacity-50 hover:bg-opacity-70 text-white font-medium rounded-lg transition-all duration-200 text-center">
                        Atrás
                    </a>
                    
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Continuar
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                RifApp Plus v1.0 - Configuración de Administrador
            </div>
        </div>
    </div>

    <script>
        // Validar que las contraseñas coincidan
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="admin_password"]').value;
            const confirmPassword = document.querySelector('input[name="admin_confirm_password"]').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>
