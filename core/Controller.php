<?php

require_once __DIR__ . '/View.php';
require_once __DIR__ . '/Session.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ActionLogger.php';
require_once __DIR__ . '/ChileanHelper.php';
require_once __DIR__ . '/../config/mailer.php';

abstract class Controller {
    protected $view;
    protected $db;
    protected $session;
    protected $actionLogger;
    protected $chileanHelper;
    protected $mailer;
    
    public function __construct() {
        $this->view = new View();
        $this->db = Database::getInstance();
        $this->session = new Session();
        $this->actionLogger = new ActionLogger();
        $this->chileanHelper = new ChileanHelper();
        $this->mailer = new Mailer();
          // Share common data with all views
        $this->view->share('user', $this->session->user());
        $this->view->share('isLoggedIn', $this->session->isLoggedIn());
        $this->view->share('userType', $this->session->userType());
        
        // Always generate a fresh CSRF token if needed and share it with views
        $csrfToken = $this->session->generateCSRFToken();
        $this->view->share('csrfToken', $csrfToken);
        error_log('[CONTROLLER] Shared CSRF token with view: ' . substr($csrfToken, 0, 8) . '...');
    }
      protected function render($view, $data = [], $layout = 'app') {
        echo $this->view->renderWithLayout($view, $layout, $data);
    }
    
    protected function view($view, $data = [], $layout = 'app') {
        echo $this->view->renderWithLayout($view, $layout, $data);
    }
    
    protected function renderView($view, $data = []) {
        echo $this->view->render($view, $data);
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function redirect($url, $statusCode = 302) {
        header("Location: $url", true, $statusCode);
        exit;
    }
      protected function redirectWithMessage($url, $message, $type = 'success') {
        $this->session->flash($type, $message);
        $this->redirect($url);
    }
    
    protected function redirectWithErrors($url, $errors) {
        $this->session->flash('errors', $errors);
        $this->session->flash('old_input', $_POST);
        $this->redirect($url);
    }
    
    protected function validate($data, $rules) {
        $validator = new Validator();
        return $validator->validate($data, $rules);
    }    protected function requireAuth($allowedTypes = []) {
        if (!$this->session->isLoggedIn()) {
            $this->redirect(url('login'));
        }
        
        if ($this->session->isTimeout()) {
            $this->session->logout();
            $this->session->flash('message', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            $this->redirect(url('login'));
        }
        
        if (!empty($allowedTypes) && !in_array($this->session->userType(), $allowedTypes)) {
            http_response_code(403);
            $this->render('errors/403', ['title' => 'Acceso denegado']);
            exit;
        }
        
        // Refresh login time
        $this->session->refreshLoginTime();
    }
    
    protected function requireGuest() {
        if ($this->session->isLoggedIn()) {
            $userType = $this->session->userType();            switch ($userType) {
                case 'superadmin':
                    $this->redirect(url('superadmin'));
                    break;
                case 'admin':
                    $this->redirect(url('admin'));
                    break;
                case 'vendedor':
                    $this->redirect(url('vendedor'));
                    break;
                default:
                    $this->redirect(url(''));
            }
        }    }    protected function validateCSRF() {
        // Check for CSRF token in:
        // 1. POST data
        // 2. GET data
        // 3. X-CSRF-TOKEN header (for AJAX requests)
        $headers = getallheaders();
        $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? $headers['X-CSRF-TOKEN'] ?? '';
        $sessionToken = $this->session->get('csrf_token');
        
        // Debug token information
        error_log('[CSRF] Validating - Session: ' . var_export($sessionToken, true) . ' | Received: ' . var_export($token, true));
        
        if (!$this->session->validateCSRFToken($token)) {
            // Debug output
            error_log('[CSRF] Invalid token! Session: ' . var_export($sessionToken, true) . ' | Received: ' . var_export($token, true));
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(['error' => 'Token CSRF inválido. Por favor, recarga la página e intenta nuevamente.']);
                exit;
            } else {                $this->session->setFlash('error', 'Token de seguridad inválido. Por favor, intenta nuevamente.');
                $this->redirect($_SERVER['HTTP_REFERER'] ?? url(''));
            }
        }
    }
    
    protected function logAction($action, $details = []) {
        $logger = new ActionLogger();
        $logger->log($action, $details);
    }
    
    protected function getInput($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    protected function getAllInput() {
        return array_merge($_GET, $_POST);
    }
    
    protected function hasInput($key) {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }
    
    protected function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
