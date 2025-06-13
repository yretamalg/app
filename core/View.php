<?php

class View {
    private $viewsPath;
    private $data = [];
    
    public function __construct() {
        $this->viewsPath = __DIR__ . '/../app/Views/';
    }
    
    public function render($view, $data = []) {
        $this->data = array_merge($this->data, $data);
        
        $viewFile = $this->viewsPath . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            throw new Exception("Vista no encontrada: {$view}");
        }
        
        // Extract data to variables
        extract($this->data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include $viewFile;
        
        // Get the buffered content
        $content = ob_get_clean();
        
        return $content;
    }
    
    public function renderWithLayout($view, $layout = 'app', $data = []) {
        $this->data = array_merge($this->data, $data);
        
        // Render the main content
        $content = $this->render($view, $this->data);
        
        // Add content to data for layout
        $this->data['content'] = $content;
        
        // Render with layout
        return $this->render("layouts/{$layout}", $this->data);
    }
    
    public function share($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function include($view, $data = []) {
        echo $this->render($view, $data);
    }
      public function asset($path) {
        return asset($path);
    }
    
    public function url($path = '') {
        return url($path);
    }
    
    public function route($name, $params = []) {
        global $router;
        return $router->url($name, $params);
    }
      public function csrf() {
        $session = new Session();
        return $session->get('csrf_token');
    }
    
    public function old($key, $default = '') {
        $session = new Session();
        return $session->getFlash('old_' . $key, $default);
    }
    
    public function errors($key = null) {
        $session = new Session();
        $errors = $session->getFlash('errors', []);
        
        if ($key) {
            return isset($errors[$key]) ? $errors[$key] : [];
        }
        
        return $errors;
    }
    
    public function hasError($key) {
        $errors = $this->errors();
        return isset($errors[$key]) && !empty($errors[$key]);
    }
    
    public function success() {
        $session = new Session();
        return $session->getFlash('success');
    }
      public function message() {
        $session = new Session();
        return $session->getFlash('message');
    }
    
    public function user() {
        $session = new Session();
        return $session->get('user');
    }
    
    public function isLoggedIn() {
        $session = new Session();
        return $session->has('user');
    }
    
    public function hasRole($role) {
        $user = $this->user();
        return $user && $user['tipo'] === $role;
    }
    
    public function can($permission) {
        $user = $this->user();
        if (!$user) return false;
        
        // Superadmin can do everything
        if ($user['tipo'] === 'superadmin') return true;
        
        // Add permission logic here
        return true;
    }
}
