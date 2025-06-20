<?php

class Session {
    
    public function __construct() {
        $this->start();
    }
      public function start() {
        if (session_status() === PHP_SESSION_NONE) {
            // Ensure all session parameters are correct
            try {
                session_start();
                // Log session information for debugging
                error_log('[SESSION] Started session with ID: ' . session_id());
            } catch (Exception $e) {
                error_log('[SESSION] Error starting session: ' . $e->getMessage());
                // Try to recover from session errors by creating a new session
                session_regenerate_id(true);
            }
        }
    }
    
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public function destroy() {
        session_destroy();
        session_regenerate_id(true);
    }
    
    public function regenerate() {
        session_regenerate_id(true);
    }
    
    public function flash($key, $value) {
        $this->set('flash_' . $key, $value);
    }
    
    public function setFlash($key, $value) {
        $this->flash($key, $value);
    }
    
    public function getFlash($key, $default = null) {
        $flashKey = 'flash_' . $key;
        $value = $this->get($flashKey, $default);
        $this->remove($flashKey);
        return $value;
    }
    
    public function hasFlash($key) {
        return $this->has('flash_' . $key);
    }
    
    public function keepFlash($key) {
        $value = $this->getFlash($key);
        if ($value !== null) {
            $this->flash($key, $value);
        }
    }
      public function generateCSRFToken() {
        // Generate a new token if one doesn't exist
        if (!$this->has('csrf_token')) {
            $token = bin2hex(random_bytes(32));
            $this->set('csrf_token', $token);
            error_log('[CSRF] Generated new token: ' . substr($token, 0, 8) . '...');
        } else {
            $token = $this->get('csrf_token');
            error_log('[CSRF] Using existing token: ' . substr($token, 0, 8) . '...');
        }
        return $token;
    }
    
    public function validateCSRFToken($token) {
        $sessionToken = $this->get('csrf_token');
        
        // Enhanced security: generate a new token after validation
        $result = $sessionToken && !empty($token) && hash_equals($sessionToken, $token);
        
        if ($result) {
            error_log('[CSRF] Token validated successfully');
            // Only regenerate on successful validations to prevent session fixation
            // but keep the current token after failed validations
            $newToken = bin2hex(random_bytes(32));
            $this->set('csrf_token', $newToken);
        } else {
            error_log('[CSRF] Token validation failed - Session: ' . substr($sessionToken ?? 'null', 0, 8) . 
                      ' | Received: ' . substr($token ?? 'null', 0, 8));
        }
        
        return $result;
    }
    
    public function login($userId, $remember = false) {
        $this->regenerate();
        
        // Load user data
        require_once __DIR__ . '/../app/Models/Usuario.php';
        $usuarioModel = new Usuario();
        $user = $usuarioModel->find($userId);
        
        $this->set('user', $user);
        $this->set('logged_in_at', time());
        
        if ($remember) {
            // Set remember token (implement later if needed)
        }
    }
    
    public function logout() {
        $this->remove('user');
        $this->remove('logged_in_at');
        $this->destroy();
    }
    
    public function isLoggedIn() {
        return $this->has('user');
    }
    
    public function user() {
        return $this->get('user');
    }
    
    public function getUserId() {
        $user = $this->user();
        return $user ? $user['id'] : null;
    }
    
    public function userType() {
        $user = $this->user();
        return $user ? $user['tipo'] : null;
    }
    
    public function updateUser($userData) {
        $this->set('user', $userData);
    }
    
    public function isTimeout($minutes = 120) {
        $loginTime = $this->get('logged_in_at');
        if (!$loginTime) return true;
        
        return (time() - $loginTime) > ($minutes * 60);
    }
    
    public function refreshLoginTime() {
        if ($this->isLoggedIn()) {
            $this->set('logged_in_at', time());
        }
    }
}
