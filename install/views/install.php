<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalando - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-lg w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <div class="spinner">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Instalando RifApp Plus</h1>
                <p class="text-gray-300">Por favor espera mientras se completa la instalación...</p>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span class="text-blue-300">Bienvenida</span>
                    <span class="text-blue-300">Requisitos</span>
                    <span class="text-blue-300">Base de Datos</span>
                    <span class="text-blue-300">Administrador</span>
                    <span class="text-blue-300">Instalando</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                </div>
            </div>

            <!-- Messages -->
            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-300 rounded-xl text-red-100">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-medium">Error durante la instalación</h3>
                            <p class="text-sm mt-1"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="?step=config" class="px-4 py-2 bg-red-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                            Volver a Intentar
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Installation Steps -->
                <div class="space-y-4 mb-6">
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="spinner mr-3">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-white font-medium">Creando archivo de configuración</span>
                                <p class="text-gray-300 text-sm">Generando .env con tus configuraciones...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="spinner mr-3">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-white font-medium">Instalando base de datos</span>
                                <p class="text-gray-300 text-sm">Creando tablas y estructura inicial...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="spinner mr-3">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-white font-medium">Creando usuario administrador</span>
                                <p class="text-gray-300 text-sm">Configurando acceso inicial al sistema...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auto-submit form -->
                <form method="POST" action="?step=install" id="installForm">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Completar Instalación
                    </button>
                </form>

                <script>
                    // Auto-submit after 2 seconds for better UX
                    setTimeout(function() {
                        document.getElementById('installForm').submit();
                    }, 2000);
                </script>
            <?php endif; ?>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                RifApp Plus v1.0 - Proceso de Instalación
            </div>
        </div>
    </div>
</body>
</html>
