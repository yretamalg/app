<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Instalación Completada! - RifApp Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bounce {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0,-30px,0);
            }
            70% {
                transform: translate3d(0,-15px,0);
            }
            90% {
                transform: translate3d(0,-4px,0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-2xl w-full">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-gradient-to-r from-green-500 to-blue-600 rounded-3xl flex items-center justify-center mb-6 bounce">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">¡Instalación Completada!</h1>
                <p class="text-gray-300 text-lg">RifApp Plus ha sido instalado exitosamente</p>
            </div>

            <!-- Success Message -->
            <?php if ($success): ?>
                <div class="mb-6 p-4 bg-green-500 bg-opacity-20 border border-green-300 rounded-xl text-green-100">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span><?php echo htmlspecialchars($success); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Important Security Notice -->
            <div class="glassmorphism rounded-xl p-6 mb-6 border-l-4 border-red-400">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-red-400 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-300 font-bold text-lg mb-2">¡ACCIÓN REQUERIDA PARA SEGURIDAD!</h3>
                        <p class="text-gray-300 mb-3">
                            Por razones de seguridad, debes <strong class="text-red-300">eliminar completamente</strong> 
                            el directorio <code class="bg-black bg-opacity-40 px-2 py-1 rounded text-yellow-200">/install/</code> 
                            antes de usar la aplicación.
                        </p>
                        
                        <div class="bg-black bg-opacity-30 rounded-lg p-3 mb-3">
                            <p class="text-xs text-gray-300 mb-2">Comandos para eliminar el directorio:</p>
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
                            <strong>Importante:</strong> La aplicación no funcionará correctamente hasta que elimines este directorio.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Installation Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="glassmorphism rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                        <span class="text-white font-medium">Base de Datos</span>
                    </div>
                    <p class="text-gray-300 text-sm">Tablas creadas y configuradas correctamente</p>
                </div>
                
                <div class="glassmorphism rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-white font-medium">Administrador</span>
                    </div>
                    <p class="text-gray-300 text-sm">Usuario administrador creado exitosamente</p>
                </div>
                
                <div class="glassmorphism rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-white font-medium">Configuración</span>
                    </div>
                    <p class="text-gray-300 text-sm">Archivo .env generado con tus configuraciones</p>
                </div>
                
                <div class="glassmorphism rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-white font-medium">Seguridad</span>
                    </div>
                    <p class="text-gray-300 text-sm">Claves de seguridad generadas automáticamente</p>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="glassmorphism rounded-xl p-6 mb-6">
                <h3 class="text-white font-semibold text-lg mb-4">Próximos Pasos:</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">1.</span>
                        <p class="text-gray-300 text-sm">
                            <strong>Elimina el directorio /install/</strong> por seguridad
                        </p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">2.</span>
                        <p class="text-gray-300 text-sm">
                            Accede al panel de administración con tus credenciales
                        </p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">3.</span>
                        <p class="text-gray-300 text-sm">
                            Configura los ajustes adicionales (email, SEO, etc.)
                        </p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-400 font-bold mr-3">4.</span>
                        <p class="text-gray-300 text-sm">
                            ¡Comienza a crear y gestionar tus rifas!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                <a href="../public/" 
                   class="block w-full px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ir a RifApp Plus
                </a>
                
                <p class="text-gray-400 text-sm">
                    Recuerda eliminar el directorio <code class="bg-black bg-opacity-30 px-2 py-1 rounded">/install/</code> 
                    antes de usar la aplicación en producción.
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-400">
                <p>¡Gracias por elegir RifApp Plus!</p>
                <p class="mt-1">© 2024 - Sistema de Gestión de Rifas para Chile</p>
            </div>
        </div>
    </div>
</body>
</html>
