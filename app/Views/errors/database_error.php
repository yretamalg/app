<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Base de Datos - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-900 via-red-900 to-pink-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-2xl w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Tablas de Base de Datos Faltantes</h1>
                <p class="text-orange-200">La base de datos existe pero las tablas no están instaladas</p>
            </div>

            <!-- Problem Description -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">¿Qué está pasando?</h3>
                <div class="space-y-3 text-gray-300">
                    <p>La aplicación puede conectarse a la base de datos, pero no encuentra las tablas necesarias para funcionar.</p>
                    <p>Esto generalmente sucede cuando:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1 text-sm">
                        <li>Es una instalación nueva sin completar</li>
                        <li>Las tablas fueron eliminadas accidentalmente</li>
                        <li>Se está usando una base de datos vacía</li>
                        <li>El proceso de instalación anterior falló</li>
                    </ul>
                </div>
            </div>

            <!-- Current Configuration -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Configuración Actual</h3>
                <div class="bg-black bg-opacity-30 rounded-lg p-3">
                    <div class="text-gray-300 text-sm space-y-1">
                        <p><strong>Base de Datos:</strong> <?= $_ENV['DB_NAME'] ?? 'No configurado' ?></p>
                        <p><strong>Host:</strong> <?= $_ENV['DB_HOST'] ?? 'No configurado' ?></p>
                        <p><strong>Usuario:</strong> <?= $_ENV['DB_USER'] ?? 'No configurado' ?></p>
                        <p><strong>Estado:</strong> <span class="text-green-400">Conectado ✓</span></p>
                        <p><strong>Tablas:</strong> <span class="text-red-400">Faltantes ✗</span></p>
                    </div>
                </div>
            </div>

            <!-- Required Tables -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Tablas Requeridas</h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">usuarios</span>
                    </div>
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">rifas</span>
                    </div>
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">ventas</span>
                    </div>
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">premios</span>
                    </div>
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">vendedores</span>
                    </div>
                    <div class="bg-black bg-opacity-30 rounded-lg p-2">
                        <span class="text-red-400">✗</span> <span class="text-gray-300">configuraciones</span>
                    </div>
                </div>
            </div>

            <!-- Solutions -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4">Soluciones</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">1.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Ejecutar el Instalador (Recomendado)</strong></p>
                            <p class="text-gray-400 text-xs mt-1">El instalador creará automáticamente todas las tablas necesarias</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">2.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Importar Esquema SQL Manualmente</strong></p>
                            <p class="text-gray-400 text-xs mt-1">Usar phpMyAdmin para importar el archivo scripts/database_schema.sql</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">3.</span>
                        <div>
                            <p class="text-gray-300 text-sm"><strong>Cambiar Base de Datos</strong></p>
                            <p class="text-gray-400 text-xs mt-1">Modificar .env para usar una base de datos que ya tenga las tablas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center space-y-4">
                <?php if (file_exists(__DIR__ . '/../../install/index.php')): ?>
                <a href="../install/?reinstall=1" 
                   class="block w-full px-6 py-3 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-xl transition-all duration-200">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Ejecutar Instalador
                </a>
                <?php endif; ?>
                
                <a href="http://localhost/phpmyadmin/" target="_blank"
                   class="block w-full px-4 py-2 bg-green-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-xl transition-all duration-200">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    Abrir phpMyAdmin
                </a>
                
                <button onclick="location.reload()" 
                        class="w-full px-4 py-2 bg-purple-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                    <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Verificar Nuevamente
                </button>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                <p>RifApp Plus v1.0 - Error de Estructura de Base de Datos</p>
                <p class="mt-1">Las tablas se crearán automáticamente al ejecutar el instalador</p>
            </div>
        </div>
    </div>
</body>
</html>
