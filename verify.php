<?php
/**
 * Script de Verificación de Despliegue
 * Ejecutar en: https://www.vbox.pro/rifapp/verify.php
 */

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Despliegue - RifApp Plus</title>
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
        <div class="glassmorphism rounded-3xl shadow-2xl p-8 max-w-4xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">🔍 Verificación de Despliegue</h1>
                <p class="text-blue-200">RifApp Plus - Estado del Sistema</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                $checks = [];
                
                // 1. Verificar PHP
                $checks['PHP Version'] = [
                    'status' => version_compare(PHP_VERSION, '7.4.0', '>='),
                    'value' => PHP_VERSION,
                    'expected' => '>= 7.4.0'
                ];
                
                // 2. Verificar archivos principales
                $checks['index.php'] = [
                    'status' => file_exists(__DIR__ . '/index.php'),
                    'value' => file_exists(__DIR__ . '/index.php') ? 'Presente' : 'Falta',
                    'expected' => 'Presente'
                ];
                
                $checks['.htaccess'] = [
                    'status' => file_exists(__DIR__ . '/.htaccess'),
                    'value' => file_exists(__DIR__ . '/.htaccess') ? 'Presente' : 'Falta',
                    'expected' => 'Presente'
                ];
                
                $checks['.env'] = [
                    'status' => file_exists(__DIR__ . '/.env'),
                    'value' => file_exists(__DIR__ . '/.env') ? 'Presente' : 'Falta',
                    'expected' => 'Presente'
                ];
                
                // 3. Verificar directorios
                $checks['Directorio storage/'] = [
                    'status' => is_dir(__DIR__ . '/storage') && is_writable(__DIR__ . '/storage'),
                    'value' => is_dir(__DIR__ . '/storage') ? (is_writable(__DIR__ . '/storage') ? 'Escribible' : 'Solo lectura') : 'No existe',
                    'expected' => 'Escribible'
                ];
                
                $checks['Directorio public/'] = [
                    'status' => is_dir(__DIR__ . '/public'),
                    'value' => is_dir(__DIR__ . '/public') ? 'Presente' : 'Falta',
                    'expected' => 'Presente'
                ];
                
                // 4. Verificar autoloader
                $checks['Composer Autoloader'] = [
                    'status' => file_exists(__DIR__ . '/vendor/autoload.php'),
                    'value' => file_exists(__DIR__ . '/vendor/autoload.php') ? 'Instalado' : 'Falta',
                    'expected' => 'Instalado'
                ];
                
                // 5. Verificar extensiones PHP
                $checks['PDO Extension'] = [
                    'status' => extension_loaded('pdo'),
                    'value' => extension_loaded('pdo') ? 'Habilitada' : 'Deshabilitada',
                    'expected' => 'Habilitada'
                ];
                
                $checks['MySQL Extension'] = [
                    'status' => extension_loaded('pdo_mysql'),
                    'value' => extension_loaded('pdo_mysql') ? 'Habilitada' : 'Deshabilitada',
                    'expected' => 'Habilitada'
                ];
                
                // 6. Verificar configuración .env
                if (file_exists(__DIR__ . '/.env')) {
                    $envContent = file_get_contents(__DIR__ . '/.env');
                    $checks['APP_URL configurada'] = [
                        'status' => strpos($envContent, 'APP_URL=') !== false,
                        'value' => strpos($envContent, 'APP_URL=') !== false ? 'Configurada' : 'Falta',
                        'expected' => 'Configurada'
                    ];
                    
                    $checks['DB_HOST configurada'] = [
                        'status' => strpos($envContent, 'DB_HOST=') !== false,
                        'value' => strpos($envContent, 'DB_HOST=') !== false ? 'Configurada' : 'Falta',
                        'expected' => 'Configurada'
                    ];
                }
                
                // Mostrar resultados
                foreach ($checks as $name => $check) {
                    $statusColor = $check['status'] ? 'text-green-400' : 'text-red-400';
                    $icon = $check['status'] ? '✅' : '❌';
                    
                    echo "<div class='glassmorphism rounded-xl p-4 border-l-4 " . 
                         ($check['status'] ? 'border-green-400' : 'border-red-400') . "'>";
                    echo "<div class='flex items-center justify-between'>";
                    echo "<span class='text-white font-medium'>$icon $name</span>";
                    echo "<span class='$statusColor'>{$check['value']}</span>";
                    echo "</div>";
                    echo "<div class='text-xs text-gray-400 mt-1'>Esperado: {$check['expected']}</div>";
                    echo "</div>";
                }
                ?>
            </div>
            
            <div class="mt-8 text-center">
                <div class="glassmorphism rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold mb-2">🌐 URLs de Acceso</h3>
                    <div class="space-y-2 text-sm">
                        <div><span class="text-blue-200">Aplicación:</span> <a href="./" class="text-yellow-400 hover:underline">https://www.vbox.pro/rifapp/</a></div>
                        <div><span class="text-blue-200">Instalador:</span> <a href="./install/" class="text-yellow-400 hover:underline">https://www.vbox.pro/rifapp/install/</a></div>
                        <div><span class="text-blue-200">Público:</span> <a href="./public/" class="text-yellow-400 hover:underline">https://www.vbox.pro/rifapp/public/</a></div>
                    </div>
                </div>
                
                <div class="space-x-4">
                    <a href="./" class="px-6 py-2 bg-blue-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Ir a la Aplicación
                    </a>
                    <a href="./install/" class="px-6 py-2 bg-green-600 bg-opacity-80 hover:bg-opacity-100 text-white font-medium rounded-lg transition-all duration-200">
                        Ejecutar Instalador
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
