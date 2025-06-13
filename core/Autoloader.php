<?php
/**
 * Autoloader Simple para RifApp Plus
 * 
 * Carga automáticamente las clases cuando son requeridas
 */

class Autoloader {
    private static $paths = [
        'core/',
        'app/Models/',
        'app/Controllers/',
        'config/'
    ];
    
    public static function register() {
        spl_autoload_register([self::class, 'load']);
    }
    
    public static function load($className) {
        $basePath = __DIR__ . '/../';
        
        foreach (self::$paths as $path) {
            $filePath = $basePath . $path . $className . '.php';
            
            if (file_exists($filePath)) {
                require_once $filePath;
                return true;
            }
        }
        
        return false;
    }
    
    public static function addPath($path) {
        if (!in_array($path, self::$paths)) {
            self::$paths[] = $path;
        }
    }
}

// Registrar el autoloader
Autoloader::register();

// Cargar funciones helper globales
require_once __DIR__ . '/helpers.php';
?>
