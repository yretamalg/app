<?php

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

// Check if installation is complete
if (!file_exists(__DIR__ . '/../.env')) {
    // No .env file, redirect to installer
    if (file_exists(__DIR__ . '/../install/index.php')) {
        header('Location: ../install/');
    } else {
        die('Error: La aplicación no está instalada y el instalador no está disponible.');
    }
    exit;
}

// Check if install directory still exists (security warning)
if (file_exists(__DIR__ . '/../install/')) {
    // Application is installed but install directory exists
    $installWarning = true;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Load autoloader for automatic class loading
require_once __DIR__ . '/../core/Autoloader.php';

// Load configuration files that are not classes
require_once __DIR__ . '/../config/mailer.php';

// Initialize session
$session = new Session();

// Check for install directory security warning
if (isset($installWarning) && $installWarning) {
    $session->setFlash('security_warning', 'SEGURIDAD: El directorio /install/ aún existe. Debes eliminarlo inmediatamente por seguridad.');
}

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

// Check if database connection works, if not redirect to installer
try {
    $db = Database::getInstance();
    // Test if the main tables exist
    $stmt = $db->query("SHOW TABLES LIKE 'usuarios'");
    if (!$stmt->fetch()) {
        // Database exists but tables are missing, redirect to installer
        if (file_exists(__DIR__ . '/../install/index.php')) {
            header('Location: ../install/');
        } else {
            // Show detailed error page
            include __DIR__ . '/../app/Views/errors/database_error.php';
        }
        exit;
    }
} catch (Exception $e) {
    // Database connection failed, redirect to installer
    if (file_exists(__DIR__ . '/../install/index.php')) {
        header('Location: ../install/');
    } else {
        // Show detailed error page with connection details
        include __DIR__ . '/../app/Views/errors/connection_error.php';
    }
    exit;
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
