<?php
/**
 * Funciones helper globales para RifApp Plus
 */

/**
 * Redirige a una URL y termina la ejecución del script
 * 
 * @param string $url La URL a la que redirigir
 * @param int $statusCode El código de estado HTTP (301, 302, etc.)
 * @return void
 */
function redirect($url, $statusCode = 302) {
    header('Location: ' . $url, true, $statusCode);
    exit();
}

/**
 * Generar URL relativa al directorio base de la aplicación
 */
function url($path = '') {
    // Detectar si estamos en desarrollo (puerto 8000) o en XAMPP
    $isDevServer = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '8000';
    $isXAMPP = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '80';
    
    if ($isDevServer) {
        $baseUrl = '';
    } elseif ($isXAMPP || strpos($_SERVER['REQUEST_URI'] ?? '', '/app/') !== false) {
        $baseUrl = '/app';
    } else {
        // Default for production
        $baseUrl = '';
    }
    
    // Remover barra inicial si existe
    $path = ltrim($path, '/');
    
    return $baseUrl . ($path ? '/' . $path : '');
}

/**
 * Generar URL para assets (CSS, JS, imágenes)
 */
function asset($path) {
    // Detectar si estamos en desarrollo (puerto 8000) o en XAMPP
    $isDevServer = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '8000';
    $isXAMPP = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '80';
    
    if ($isDevServer) {
        // En el dev server, los assets están en /assets/ directamente
        return '/assets/' . ltrim($path, '/');
    } elseif ($isXAMPP || strpos($_SERVER['REQUEST_URI'] ?? '', '/app/') !== false) {
        // En XAMPP, usar la estructura completa
        return '/app/public/assets/' . ltrim($path, '/');
    } else {
        // En producción, usar la estructura normal
        return url('public/assets/' . ltrim($path, '/'));
    }
}

/**
 * Generar URL usando rutas nombradas
 */
function route($name, $params = []) {
    global $router;
    if ($router) {
        return $router->url($name, $params);
    }
    return url('');
}

/**
 * Obtener la URL actual
 */
function currentUrl() {
    return $_SERVER['REQUEST_URI'];
}

/**
 * Verificar si la URL actual coincide con un patrón
 */
function isCurrentRoute($pattern) {
    return preg_match($pattern, currentUrl());
}

/**
 * Generar CSRF token
 */
function csrf_token() {
    $session = new Session();
    return $session->get('csrf_token', $session->generateCSRFToken());
}

/**
 * Generar campo oculto CSRF para formularios
 */
function csrf_field() {
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

/**
 * Elimina acentos y caracteres especiales de un string
 * Útil para búsquedas y generación de slugs
 * 
 * @param string $string String a procesar
 * @return string String sin acentos ni caracteres especiales
 */
function removeAccents($string) {
    $unwanted_array = array(
        'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
        'ñ'=>'n', 'Ñ'=>'N', 'ü'=>'u', 'Ü'=>'U',
        'à'=>'a', 'è'=>'e', 'ì'=>'i', 'ò'=>'o', 'ù'=>'u', 'À'=>'A', 'È'=>'E', 'Ì'=>'I', 'Ò'=>'O', 'Ù'=>'U'
    );
    return strtr($string, $unwanted_array);
}
