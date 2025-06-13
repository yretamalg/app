<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Requisitos - RifApp Plus</title>
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
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-2xl w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Verificación de Requisitos</h1>
                <p class="text-gray-300">Comprobando que tu servidor cumple con los requisitos mínimos</p>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span class="text-blue-300">Bienvenida</span>
                    <span class="text-blue-300">Requisitos</span>
                    <span>Base de Datos</span>
                    <span>Administrador</span>
                    <span>Finalizar</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: 40%"></div>
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

            <!-- Requirements Check -->
            <?php $requirements = checkSystemRequirements(); ?>
            
            <div class="space-y-4 mb-6">
                <h2 class="text-lg font-semibold text-white mb-4">Estado de los Requisitos del Sistema</h2>
                
                <!-- PHP Version -->
                <div class="glassmorphism rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="<?php echo $requirements['php_version'] ? 'bg-green-500' : 'bg-red-500'; ?> w-3 h-3 rounded-full mr-3"></div>
                        <div>
                            <span class="text-white font-medium">PHP Version</span>
                            <p class="text-gray-300 text-sm">Requerido: PHP 7.4+, Actual: <?php echo PHP_VERSION; ?></p>
                        </div>
                    </div>
                    <?php if ($requirements['php_version']): ?>
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- PDO MySQL -->
                <div class="glassmorphism rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="<?php echo $requirements['pdo_mysql'] ? 'bg-green-500' : 'bg-red-500'; ?> w-3 h-3 rounded-full mr-3"></div>
                        <div>
                            <span class="text-white font-medium">PDO MySQL</span>
                            <p class="text-gray-300 text-sm">Extensión necesaria para la base de datos</p>
                        </div>
                    </div>
                    <?php if ($requirements['pdo_mysql']): ?>
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- Mbstring -->
                <div class="glassmorphism rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="<?php echo $requirements['mbstring'] ? 'bg-green-500' : 'bg-red-500'; ?> w-3 h-3 rounded-full mr-3"></div>
                        <div>
                            <span class="text-white font-medium">Mbstring</span>
                            <p class="text-gray-300 text-sm">Para el manejo de caracteres especiales</p>
                        </div>
                    </div>
                    <?php if ($requirements['mbstring']): ?>
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- OpenSSL -->
                <div class="glassmorphism rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="<?php echo $requirements['openssl'] ? 'bg-green-500' : 'bg-red-500'; ?> w-3 h-3 rounded-full mr-3"></div>
                        <div>
                            <span class="text-white font-medium">OpenSSL</span>
                            <p class="text-gray-300 text-sm">Para encriptación y seguridad</p>
                        </div>
                    </div>
                    <?php if ($requirements['openssl']): ?>
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- Writable Storage -->
                <div class="glassmorphism rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="<?php echo $requirements['writable_storage'] ? 'bg-green-500' : 'bg-red-500'; ?> w-3 h-3 rounded-full mr-3"></div>
                        <div>
                            <span class="text-white font-medium">Directorio Storage</span>
                            <p class="text-gray-300 text-sm">Permisos de escritura en /storage/</p>
                        </div>
                    </div>
                    <?php if ($requirements['writable_storage']): ?>
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    <?php else: ?>
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4">
                <a href="?" class="flex-1 px-4 py-2 bg-gray-600 bg-opacity-50 hover:bg-opacity-70 text-white font-medium rounded-lg transition-all duration-200 text-center">
                    Volver
                </a>
                
                <?php if ($requirements['all_passed']): ?>
                    <form method="POST" action="?step=requirements" class="flex-1">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                            Continuar
                        </button>
                    </form>
                <?php else: ?>
                    <button onclick="location.reload()" class="flex-1 px-4 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Verificar Nuevamente
                    </button>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                RifApp Plus v1.0 - Verificación de Sistema
            </div>
        </div>
    </div>
</body>
</html>
