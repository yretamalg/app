<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación Ya Instalada - RifApp Plus</title>
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
                <div class="mx-auto h-20 w-20 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">RifApp Plus Ya Está Instalado</h1>
                <p class="text-gray-300">La aplicación ha sido configurada anteriormente</p>
            </div>

            <!-- Warning Notice -->
            <div class="glassmorphism rounded-xl p-6 mb-6 border-l-4 border-yellow-400">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-yellow-400 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-yellow-300 font-bold text-lg mb-2">¡RIESGO DE SEGURIDAD!</h3>
                        <p class="text-gray-300 mb-3">
                            La aplicación está funcionando, pero el directorio de instalación 
                            <code class="bg-black bg-opacity-40 px-2 py-1 rounded text-yellow-200">/install/</code> 
                            aún existe. Esto representa un riesgo de seguridad.
                        </p>
                        
                        <div class="bg-black bg-opacity-30 rounded-lg p-3 mb-3">
                            <p class="text-xs text-gray-300 mb-2">Debes eliminar este directorio inmediatamente:</p>
                            <div class="space-y-1">
                                <code class="block text-yellow-200 text-sm">
                                    # En Windows (PowerShell o CMD):<br>
                                    rmdir /s "c:\xampp\htdocs\app\install"
                                </code>
                                <code class="block text-yellow-200 text-sm">
                                    # En Linux/Mac:<br>
                                    rm -rf /path/to/app/install/
                                </code>
                            </div>
                        </div>
                        
                        <p class="text-red-200 text-sm">
                            <strong>Importante:</strong> Los atacantes pueden usar este directorio para reinstalar 
                            la aplicación y comprometer tu sistema.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="space-y-4">
                <a href="../public/" 
                   class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 text-center">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ir a RifApp Plus
                </a>

                <div class="border-t border-gray-600 pt-4">
                    <p class="text-gray-400 text-sm mb-3 text-center">¿Necesitas reinstalar la aplicación?</p>
                    
                    <a href="?reinstall=1" 
                       class="block w-full px-4 py-2 bg-red-600 bg-opacity-20 hover:bg-opacity-30 border border-red-400 text-red-300 font-medium rounded-lg transition-all duration-200 text-center">
                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Forzar Reinstalación
                    </a>
                    
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        ⚠️ Esto eliminará todas las configuraciones actuales
                    </p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="glassmorphism rounded-xl p-4 mt-6">
                <h3 class="text-white font-medium text-sm mb-2">Cómo eliminar el directorio de instalación:</h3>
                <ol class="text-gray-300 text-xs space-y-1">
                    <li>1. Abre una terminal o símbolo del sistema</li>
                    <li>2. Navega al directorio de la aplicación</li>
                    <li>3. Ejecuta el comando de eliminación apropiado</li>
                    <li>4. Verifica que el directorio /install/ ya no existe</li>
                </ol>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                <p>RifApp Plus v1.0 - Sistema de Gestión de Rifas</p>
                <p class="mt-1">Elimina este directorio para mayor seguridad</p>
            </div>
        </div>
    </div>
</body>
</html>
