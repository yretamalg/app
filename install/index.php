<?php
/**
 * RifApp Plus - Instalador Principal
 * Sistema de instalación asistida para RifApp Plus
 * 
 * IMPORTANTE: Este directorio debe ser eliminado después de completar la instalación
 * para garantizar la seguridad de la aplicación.
 */

session_start();

// Verificar si la aplicación ya está instalada
if (file_exists(__DIR__ . '/../.env') && !isset($_GET['reinstall'])) {
    // Si ya está instalado, mostrar mensaje y opciones
    include 'views/already_installed.php';
    exit;
}

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load core classes needed for installer
require_once __DIR__ . '/../core/ChileanHelper.php';

$step = $_GET['step'] ?? 'welcome';
$error = '';
$success = '';

// Process installation steps
if ($_POST) {
    switch ($step) {
        case 'requirements':
            // Check system requirements
            $requirements = checkSystemRequirements();
            if ($requirements['all_passed']) {
                $step = 'database';
                $success = "Todos los requisitos del sistema han sido verificados.";
            } else {
                $error = "Algunos requisitos del sistema no se cumplen. Por favor, revisa los detalles.";
            }
            break;
            
        case 'database':
            // Database configuration
            $dbConfig = [
                'host' => $_POST['db_host'] ?? 'localhost',
                'port' => $_POST['db_port'] ?? '3306',
                'name' => $_POST['db_name'] ?? 'rifapp_plus',
                'user' => $_POST['db_user'] ?? 'root',
                'password' => $_POST['db_password'] ?? ''
            ];
            
            // Test database connection
            try {
                $pdo = new PDO(
                    "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset=utf8mb4",
                    $dbConfig['user'],
                    $dbConfig['password'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                // Create database if it doesn't exist
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbConfig['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Test connection to the database
                $pdo = new PDO(
                    "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['name']};charset=utf8mb4",
                    $dbConfig['user'],
                    $dbConfig['password'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                $_SESSION['db_config'] = $dbConfig;
                $step = 'admin';
                $success = "Conexión a la base de datos exitosa. Database '{$dbConfig['name']}' creada/verificada.";
                
            } catch (PDOException $e) {
                $error = "Error de conexión: " . $e->getMessage();
            }
            break;
            
        case 'admin':
            // Admin user configuration
            $adminConfig = [
                'email' => $_POST['admin_email'] ?? 'admin@rifappplus.cl',
                'password' => $_POST['admin_password'] ?? '',
                'confirm_password' => $_POST['admin_confirm_password'] ?? '',
                'rut' => $_POST['admin_rut'] ?? '',
                'nombres' => $_POST['admin_nombres'] ?? 'Administrador',
                'apellidos' => $_POST['admin_apellidos'] ?? 'Sistema'
            ];
            
            // Validate admin data
            if (empty($adminConfig['password']) || strlen($adminConfig['password']) < 8) {
                $error = "La contraseña debe tener al menos 8 caracteres.";
                break;
            }
            
            if ($adminConfig['password'] !== $adminConfig['confirm_password']) {
                $error = "Las contraseñas no coinciden.";
                break;
            }
            
            if (!filter_var($adminConfig['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "El email no es válido.";
                break;
            }
            
            $_SESSION['admin_config'] = $adminConfig;
            $step = 'config';
            $success = "Configuración de administrador validada correctamente.";
            break;
            
        case 'config':
            // Application configuration
            $appConfig = [
                'app_name' => $_POST['app_name'] ?? 'RifApp Plus',
                'app_url' => $_POST['app_url'] ?? 'http://localhost/app',
                'mail_host' => $_POST['mail_host'] ?? 'smtp.gmail.com',
                'mail_port' => $_POST['mail_port'] ?? '587',
                'mail_username' => $_POST['mail_username'] ?? '',
                'mail_password' => $_POST['mail_password'] ?? '',
                'mail_from_name' => $_POST['mail_from_name'] ?? 'RifApp Plus'
            ];
            
            $_SESSION['app_config'] = $appConfig;
            $step = 'install';
            $success = "Configuración de la aplicación guardada.";
            break;
            
        case 'install':
            // Final installation step
            try {
                $dbConfig = $_SESSION['db_config'];
                $adminConfig = $_SESSION['admin_config'];
                $appConfig = $_SESSION['app_config'];
                
                // Create .env file
                $envContent = createEnvFile($dbConfig, $adminConfig, $appConfig);
                file_put_contents(__DIR__ . '/../.env', $envContent);
                
                // Import database schema and create admin user
                importDatabaseSchema($dbConfig);
                createAdminUser($dbConfig, $adminConfig);
                
                // Clear session data
                unset($_SESSION['db_config'], $_SESSION['admin_config'], $_SESSION['app_config']);
                
                $step = 'complete';
                $success = "¡Instalación completada exitosamente!";
                
            } catch (Exception $e) {
                $error = "Error durante la instalación: " . $e->getMessage();
            }
            break;
    }
}

/**
 * Check system requirements
 */
function checkSystemRequirements() {
    $requirements = [
        'php_version' => version_compare(PHP_VERSION, '7.4.0', '>='),
        'pdo_mysql' => extension_loaded('pdo_mysql'),
        'mbstring' => extension_loaded('mbstring'),
        'openssl' => extension_loaded('openssl'),
        'json' => extension_loaded('json'),
        'curl' => extension_loaded('curl'),
        'writable_env' => is_writable(__DIR__ . '/../'),
        'writable_storage' => is_writable(__DIR__ . '/../storage/'),
    ];
    
    $requirements['all_passed'] = !in_array(false, $requirements, true);
    
    return $requirements;
}

/**
 * Create .env file content
 */
function createEnvFile($dbConfig, $adminConfig, $appConfig) {
    return "APP_NAME=\"{$appConfig['app_name']}\"
APP_ENV=production
APP_DEBUG=false
APP_URL={$appConfig['app_url']}

DB_HOST={$dbConfig['host']}
DB_PORT={$dbConfig['port']}
DB_NAME={$dbConfig['name']}
DB_USER={$dbConfig['user']}
DB_PASSWORD={$dbConfig['password']}

MAIL_MAILER=smtp
MAIL_HOST={$appConfig['mail_host']}
MAIL_PORT={$appConfig['mail_port']}
MAIL_USERNAME={$appConfig['mail_username']}
MAIL_PASSWORD={$appConfig['mail_password']}
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS={$adminConfig['email']}
MAIL_FROM_NAME=\"{$appConfig['mail_from_name']}\"

APP_KEY=base64:" . base64_encode(random_bytes(32)) . "

ADMIN_EMAIL={$adminConfig['email']}
ADMIN_PASSWORD=" . password_hash($adminConfig['password'], PASSWORD_DEFAULT) . "

RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=

TIMEZONE=America/Santiago
LOCALE=es_CL
CURRENCY=CLP";
}

/**
 * Import database schema
 */
function importDatabaseSchema($dbConfig) {
    $sqlFile = __DIR__ . '/../scripts/database_schema.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("No se encontró el archivo de esquema de la base de datos.");
    }
    
    $sql = file_get_contents($sqlFile);
    
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['name']};charset=utf8mb4",
        $dbConfig['user'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Execute SQL in chunks (split by ;)
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
}

/**
 * Create admin user
 */
function createAdminUser($dbConfig, $adminConfig) {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['name']};charset=utf8mb4",
        $dbConfig['user'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Check if admin user already exists
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$adminConfig['email']]);
    
    if (!$stmt->fetch()) {
        // Create admin user
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (rut, nombres, apellidos, email, password, tipo_usuario, activo, email_verificado_en, creado_en, actualizado_en) 
            VALUES (?, ?, ?, ?, ?, 'super_admin', 1, NOW(), NOW(), NOW())
        ");
        
        $stmt->execute([
            $adminConfig['rut'],
            $adminConfig['nombres'],
            $adminConfig['apellidos'],
            $adminConfig['email'],
            password_hash($adminConfig['password'], PASSWORD_DEFAULT)
        ]);
    }
}

// Include the appropriate view
$viewFile = __DIR__ . "/views/{$step}.php";
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    include __DIR__ . '/views/welcome.php';
}
?>
