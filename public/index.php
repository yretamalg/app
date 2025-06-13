<?php

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Load core classes
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/ChileanHelper.php';
require_once __DIR__ . '/../config/mailer.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Validator.php';
require_once __DIR__ . '/../core/ActionLogger.php';

// Initialize session
$session = new Session();

// Set timezone
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Santiago');

// Error reporting based on environment
if ($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Create router instance
$router = new Router();

// Load routes
require_once __DIR__ . '/../routes/web.php';

try {
    // Resolve route
    $router->resolve();
} catch (Exception $e) {
    if ($_ENV['APP_DEBUG'] === 'true') {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        http_response_code(500);
        $view = new View();
        echo $view->render('errors/500', ['title' => 'Error del servidor']);
    }
}
