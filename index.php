<?php
/**
 * RifApp Plus - Punto de Entrada Principal
 * 
 * Este archivo redirige automáticamente a la carpeta public/
 * donde se encuentra la aplicación principal.
 * 
 * Acceso correcto:
 * - http://localhost/app/ (redirige automáticamente)
 * - http://localhost/app/public/ (acceso directo)
 */

// Verificar si estamos en el directorio correcto
if (!file_exists(__DIR__ . '/public/index.php')) {
    die('Error: No se encontró el archivo public/index.php. Verifica la instalación.');
}

// Verificar si la aplicación está instalada
if (!file_exists(__DIR__ . '/.env')) {
    // No hay .env, verificar si existe el instalador
    if (file_exists(__DIR__ . '/install/index.php')) {
        // Redirigir al instalador
        header('Location: install/');
        exit;
    } else {
        // No hay instalador ni .env
        die('Error: La aplicación no está instalada y no se encontró el instalador.');
    }
}

// Verificar si el directorio de instalación aún existe (advertencia de seguridad)
if (file_exists(__DIR__ . '/install/')) {
    // Mostrar advertencia pero continuar a la aplicación
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advertencia de Seguridad - RifApp Plus</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .glassmorphism {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-red-900 via-orange-900 to-yellow-900 min-h-screen">
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-lg w-full">
                <div class="text-center mb-6">
                    <div class="mx-auto h-16 w-16 bg-red-500 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">⚠️ RIESGO DE SEGURIDAD</h1>
                    <p class="text-red-200">El directorio de instalación aún existe</p>
                </div>
                
                <div class="glassmorphism rounded-xl p-4 mb-6 border-l-4 border-red-400">
                    <p class="text-white mb-3">
                        El directorio <code class="bg-black bg-opacity-40 px-2 py-1 rounded text-yellow-200">/install/</code> 
                        debe ser eliminado inmediatamente por seguridad.
                    </p>
                    
                    <div class="bg-black bg-opacity-30 rounded-lg p-3 mb-3">
                        <p class="text-xs text-gray-300 mb-2">Comandos para eliminar:</p>
                        <code class="block text-yellow-200 text-sm">
                            # Windows:<br>
                            rmdir /s "<?= __DIR__ ?>\install"
                        </code>
                        <code class="block text-yellow-200 text-sm mt-1">
                            # Linux/Mac:<br>
                            rm -rf "<?= __DIR__ ?>/install/"
                        </code>
                    </div>
                </div>
                
                <div class="text-center space-y-3">
                    <a href="public/" class="block w-full px-4 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Continuar a la Aplicación
                    </a>
                    <p class="text-gray-400 text-xs">
                        (Se recomienda eliminar /install/ antes de continuar)
                    </p>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Todo está correcto, redirigir a public/
header('Location: public/');
exit;
?>
