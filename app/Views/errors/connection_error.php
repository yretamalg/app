<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-900 via-orange-900 to-red-800 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-2xl w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-red-500 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Error de Conexión a la Base de Datos</h1>
                <p class="text-red-200">No se puede establecer conexión con MySQL</p>
            </div>

            <!-- Error Details -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Detalles del Error</h3>
                <div class="space-y-3">
                    <?php if (isset($e)): ?>
                        <div class="bg-black bg-opacity-30 rounded-lg p-3">
                            <code class="text-red-200 text-sm break-all"><?= htmlspecialchars($e->getMessage()) ?></code>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-gray-300 text-sm">
                        <p><strong>Configuración actual (.env):</strong></p>
                        <ul class="mt-2 space-y-1">
                            <li>• Host: <?= $_ENV['DB_HOST'] ?? 'No configurado' ?></li>
                            <li>• Puerto: <?= $_ENV['DB_PORT'] ?? 'No configurado' ?></li>
                            <li>• Base de Datos: <?= $_ENV['DB_NAME'] ?? 'No configurado' ?></li>
                            <li>• Usuario: <?= $_ENV['DB_USER'] ?? 'No configurado' ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Solutions -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Posibles Soluciones</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="text-yellow-400 font-bold mr-3">1.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Verificar que MySQL esté ejecutándose</strong></p>
                            <p class="text-gray-400 text-xs mt-1">En XAMPP: Iniciar el servicio MySQL desde el panel de control</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-yellow-400 font-bold mr-3">2.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Verificar que la base de datos existe</strong></p>
                            <p class="text-gray-400 text-xs mt-1">Crear la base de datos '<?= $_ENV['DB_NAME'] ?? 'rifapp' ?>' en phpMyAdmin</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-yellow-400 font-bold mr-3">3.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Verificar credenciales en .env</strong></p>
                            <p class="text-gray-400 text-xs mt-1">Revisar usuario y contraseña de MySQL</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-yellow-400 font-bold mr-3">4.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Reinstalar la aplicación</strong></p>
                            <p class="text-gray-400 text-xs mt-1">Usar el instalador para configurar todo desde cero</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Fixes -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Comandos de Verificación</h3>
                <div class="bg-black bg-opacity-30 rounded-lg p-3 space-y-2">
                    <p class="text-gray-300 text-xs mb-2">Ejecutar en terminal/CMD:</p>
                    <code class="block text-yellow-200 text-sm">
                        # Verificar si MySQL está ejecutándose:<br>
                        netstat -an | findstr :3306
                    </code>
                    <code class="block text-yellow-200 text-sm">
                        # Conectar a MySQL:<br>
                        c:\xampp\mysql\bin\mysql.exe -u root
                    </code>
                    <code class="block text-yellow-200 text-sm">
                        # Mostrar bases de datos:<br>
                        SHOW DATABASES;
                    </code>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center space-y-4">
                <button onclick="location.reload()" 
                        class="w-full px-6 py-3 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-xl transition-all duration-200">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reintentar Conexión
                </button>
                
                <a href="http://localhost/phpmyadmin/" target="_blank"
                   class="block w-full px-4 py-2 bg-green-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-xl transition-all duration-200">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    Abrir phpMyAdmin
                </a>
                
                <?php if (file_exists(__DIR__ . '/../../install/index.php')): ?>
                <a href="../install/" 
                   class="block w-full px-4 py-2 bg-purple-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-xl transition-all duration-200">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Reinstalar Aplicación
                </a>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                <p>RifApp Plus v1.0 - Error de Conexión a Base de Datos</p>
                <p class="mt-1">Si el problema persiste, contacta al administrador del sistema</p>
            </div>
        </div>
    </div>
</body>
</html>
