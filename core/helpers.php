<?php
/**
 * Funciones helper globales para RifApp Plus
 */

/**
 * Generar URL relativa al directorio base de la aplicación
 */
function url($path = '') {
    $baseUrl = '/app';
    
    // Remover barra inicial si existe
    $path = ltrim($path, '/');
    
    return $baseUrl . ($path ? '/' . $path : '');
}

/**
 * Generar URL para assets (CSS, JS, imágenes)
 */
function asset($path) {
    return url('public/assets/' . ltrim($path, '/'));
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
