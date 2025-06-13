<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador - RifApp Plus</title>
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
                <div class="mx-auto h-20 w-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">RifApp Plus</h1>
                <p class="text-gray-300 text-lg">Sistema de Gestión de Rifas para Chile</p>
            </div>

            <!-- Welcome Content -->
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-white mb-4">¡Bienvenido al Instalador!</h2>
                    <p class="text-gray-300 mb-6">
                        Este asistente te guiará a través del proceso de instalación de RifApp Plus, 
                        el sistema más completo para gestionar rifas en Chile.
                    </p>
                </div>

                <!-- Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-white text-sm font-medium">Gestión Completa</span>
                        </div>
                        <p class="text-gray-300 text-xs">Sistema multi-nivel con diferentes tipos de usuarios</p>
                    </div>
                    
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <span class="text-white text-sm font-medium">Moneda Chilena</span>
                        </div>
                        <p class="text-gray-300 text-xs">Totalmente localizado para Chile (CLP, RUT, etc.)</p>
                    </div>
                    
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 4h6l-6 6V4z"></path>
                            </svg>
                            <span class="text-white text-sm font-medium">Notificaciones</span>
                        </div>
                        <p class="text-gray-300 text-xs">Sistema de notificaciones en tiempo real</p>
                    </div>
                    
                    <div class="glassmorphism rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                            </svg>
                            <span class="text-white text-sm font-medium">SEO & Analytics</span>
                        </div>
                        <p class="text-gray-300 text-xs">Paneles avanzados para optimización y estadísticas</p>
                    </div>
                </div>

                <!-- Important Notice -->
                <div class="glassmorphism rounded-xl p-4 border-l-4 border-yellow-400">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-yellow-300 font-medium text-sm">¡Importante!</h3>
                            <p class="text-gray-300 text-xs mt-1">
                                Después de completar la instalación, debes eliminar este directorio 
                                <code class="bg-black bg-opacity-30 px-2 py-1 rounded text-yellow-200">/install/</code> 
                                por seguridad.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Start Installation -->
                <div class="text-center space-y-4">
                    <a href="?step=requirements" 
                       class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                        Comenzar Instalación
                    </a>
                    
                    <p class="text-gray-400 text-xs">
                        El proceso toma aproximadamente 2-3 minutos
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                <p>RifApp Plus v1.0 - Desarrollado para Chile</p>
                <p class="mt-1">© 2024 - Sistema de Gestión de Rifas</p>
            </div>
        </div>
    </div>
</body>
</html>
