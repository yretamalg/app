<?php
/**
 * Funciones helper globales para RifApp Plus
 */

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
