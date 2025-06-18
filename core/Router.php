<?php

class Router {
    private $routes = [];
    private $namedRoutes = [];
    private $baseUrl = '';
    
    public function __construct() {
        // Detectar la URL base automáticamente
        $this->baseUrl = $this->detectBaseUrl();
    }
      private function detectBaseUrl() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        
        // Obtener el directorio base del script
        $basePath = dirname($scriptName);
        
        // Si el script está en public/, remover /public del path base
        if (str_ends_with($basePath, '/public')) {
            $basePath = substr($basePath, 0, -7); // Remover '/public'
        }
        
        // Normalizar el path
        if ($basePath === '/' || $basePath === '\\') {
            $basePath = '';
        }
        
        return $basePath;
    }
    
    public function getBaseUrl() {
        return $this->baseUrl;
    }
    
    public function addRoute($method, $pattern, $handler, $name = null) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler,
            'name' => $name
        ];
        
        if ($name) {
            $this->namedRoutes[$name] = $pattern;
        }
    }
    
    public function get($pattern, $handler, $name = null) {
        $this->addRoute('GET', $pattern, $handler, $name);
    }
    
    public function post($pattern, $handler, $name = null) {
        $this->addRoute('POST', $pattern, $handler, $name);
    }
    
    public function put($pattern, $handler, $name = null) {
        $this->addRoute('PUT', $pattern, $handler, $name);
    }
    
    public function delete($pattern, $handler, $name = null) {
        $this->addRoute('DELETE', $pattern, $handler, $name);
    }
    
    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $pattern = '#^' . $route['pattern'] . '$#';
                
                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // Remove full match
                    return $this->executeHandler($route['handler'], $matches);
                }
            }
        }
        
        // Route not found
        http_response_code(404);
        return $this->handle404();
    }
      private function getUri() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path if application is in subdirectory
        $basePath = $this->baseUrl;
        if (!empty($basePath) && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Remove /public if present (since we're in public/index.php)
        if (strpos($uri, '/public') === 0) {
            $uri = substr($uri, 7); // Remove '/public'
        }
        
        return rtrim($uri, '/') ?: '/';
    }
      private function executeHandler($handler, $params = []) {
        if (is_string($handler)) {
            // Format: 'ControllerName@methodName'
            list($controllerName, $methodName) = explode('@', $handler);
            
            // If controller name doesn't end with "Controller", add it
            if (!str_ends_with($controllerName, 'Controller')) {
                $controllerClass = $controllerName . 'Controller';
            } else {
                $controllerClass = $controllerName;
            }
            
            $controllerFile = __DIR__ . '/../app/Controllers/' . $controllerClass . '.php';
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    
                    if (method_exists($controller, $methodName)) {
                        return call_user_func_array([$controller, $methodName], $params);
                    }
                }
            }
        } elseif (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }
        
        throw new Exception("Handler no válido: " . print_r($handler, true));
    }
    
    public function url($name, $params = []) {
        if (!isset($this->namedRoutes[$name])) {
            throw new Exception("Ruta con nombre '{$name}' no encontrada");        }
        
        $pattern = $this->namedRoutes[$name];
        
        // Replace parameters in pattern
        foreach ($params as $key => $value) {
            $pattern = str_replace("{{$key}}", $value, $pattern);
        }
        
        return $this->baseUrl . $pattern;
    }
    
    private function handle404() {
        $view = new View();
        return $view->render('errors/404', ['title' => 'Página no encontrada']);
    }
    
    public function redirect($url, $statusCode = 302) {
        header("Location: $url", true, $statusCode);
        exit;
    }
}
