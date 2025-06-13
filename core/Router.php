<?php

class Router {
    private $routes = [];
    private $namedRoutes = [];
    
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
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/') {
            $uri = substr($uri, strlen($basePath));
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
            throw new Exception("Ruta con nombre '{$name}' no encontrada");
        }
        
        $pattern = $this->namedRoutes[$name];
        
        // Replace parameters in pattern
        foreach ($params as $key => $value) {
            $pattern = str_replace("{{$key}}", $value, $pattern);
        }
        
        return $_ENV['APP_URL'] . $pattern;
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
