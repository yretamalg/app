<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Base de Datos - RifApp Plus</title>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Configuración de Base de Datos</h1>
                <p class="text-gray-300">Ingresa los datos de conexión a tu base de datos MySQL</p>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span class="text-blue-300">Bienvenida</span>
                    <span class="text-blue-300">Requisitos</span>
                    <span class="text-blue-300">Base de Datos</span>
                    <span>Administrador</span>
                    <span>Finalizar</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: 60%"></div>
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

            <!-- Database Form -->
            <form method="POST" action="?step=database">
                <h2 class="text-lg font-semibold text-white mb-4">Datos de Conexión</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                            Host del Servidor
                        </label>
                        <input type="text" name="db_host" value="<?php echo $_POST['db_host'] ?? 'localhost'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="localhost">
                        <p class="text-xs text-gray-400 mt-1">Generalmente 'localhost' en servidores locales</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Puerto
                        </label>
                        <input type="text" name="db_port" value="<?php echo $_POST['db_port'] ?? '3306'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="3306">
                        <p class="text-xs text-gray-400 mt-1">Puerto estándar de MySQL es 3306</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                            Nombre de la Base de Datos
                        </label>
                        <input type="text" name="db_name" value="<?php echo $_POST['db_name'] ?? 'rifapp_plus'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="rifapp_plus">
                        <p class="text-xs text-gray-400 mt-1">Se creará automáticamente si no existe</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Usuario de la Base de Datos
                        </label>
                        <input type="text" name="db_user" value="<?php echo $_POST['db_user'] ?? 'root'; ?>" required
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="root">
                        <p class="text-xs text-gray-400 mt-1">Usuario con permisos para crear bases de datos</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Contraseña
                        </label>
                        <input type="password" name="db_password" value="<?php echo $_POST['db_password'] ?? ''; ?>"
                               class="w-full px-4 py-2 glassmorphism rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               placeholder="Contraseña de la base de datos">
                        <p class="text-xs text-gray-400 mt-1">Deja en blanco si no tienes contraseña (no recomendado)</p>
                    </div>
                </div>

                <!-- Test Connection Notice -->
                <div class="glassmorphism rounded-xl p-4 mt-6 border-l-4 border-blue-400">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-blue-300 font-medium text-sm">Verificación de Conexión</h3>
                            <p class="text-gray-300 text-xs mt-1">
                                Probaremos la conexión y crearemos la base de datos si es necesario.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-4 mt-6">
                    <a href="?step=requirements" class="flex-1 px-4 py-2 bg-gray-600 bg-opacity-50 hover:bg-opacity-70 text-white font-medium rounded-lg transition-all duration-200 text-center">
                        Atrás
                    </a>
                    
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Probar Conexión
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                RifApp Plus v1.0 - Configuración de Base de Datos
            </div>
        </div>
    </div>
</body>
</html>
