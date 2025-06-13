<?php

class InstallController extends Controller {
    
    public function __construct() {
        // Don't call parent constructor to avoid database dependency
        $this->view = new View();
    }
    
    public function index() {
        // Check if already installed
        if (file_exists(__DIR__ . '/../../.env')) {
            $this->redirect('/');
            return;
        }
        
        $this->renderInstallView('install/welcome', [
            'title' => 'Instalación - Rifas Chile',
            'step' => 1
        ]);
    }
    
    public function process() {
        if (file_exists(__DIR__ . '/../../.env')) {
            $this->json(['error' => 'La aplicación ya está instalada'], 400);
            return;
        }
        
        $step = $this->getInput('step', 1);
        
        switch ($step) {
            case 1:
                return $this->processSystemCheck();
            case 2:
                return $this->processDatabaseConfig();
            case 3:
                return $this->processMailerConfig();
            case 4:
                return $this->processSuperAdminConfig();
            case 5:
                return $this->finishInstallation();
            default:
                $this->json(['error' => 'Paso de instalación inválido'], 400);
        }
    }
    
    private function processSystemCheck() {
        $checks = [
            'php_version' => version_compare(PHP_VERSION, '7.4.0', '>='),
            'pdo_mysql' => extension_loaded('pdo_mysql'),
            'openssl' => extension_loaded('openssl'),
            'fileinfo' => extension_loaded('fileinfo'),
            'writable_storage' => is_writable(__DIR__ . '/../../storage'),
            'writable_root' => is_writable(__DIR__ . '/../../'),
        ];
        
        $allPassed = !in_array(false, $checks);
        
        if ($allPassed) {
            $this->json([
                'success' => true,
                'message' => 'Todos los requisitos del sistema se cumplen',
                'next_step' => 2
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => 'Algunos requisitos del sistema no se cumplen',
                'checks' => $checks
            ]);
        }
    }
    
    private function processDatabaseConfig() {
        $rules = [
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_password' => ''
        ];
        
        $data = $this->getAllInput();
        
        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $this->json([
                'success' => false,
                'message' => 'Datos de base de datos inválidos',
                'errors' => $validator->getErrors()
            ]);
            return;
        }
        
        // Test database connection
        try {
            $pdo = new PDO(
                "mysql:host={$data['db_host']};charset=utf8mb4",
                $data['db_user'],
                $data['db_password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            // Check if database exists, create if not
            $stmt = $pdo->query("SHOW DATABASES LIKE '{$data['db_name']}'");
            if ($stmt->rowCount() === 0) {
                $pdo->exec("CREATE DATABASE `{$data['db_name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            }
            
            // Switch to the database
            $pdo->exec("USE `{$data['db_name']}`");
            
            // Store database config in session for later use
            Session::set('install_db_config', $data);
            
            $this->json([
                'success' => true,
                'message' => 'Conexión a base de datos exitosa',
                'next_step' => 3
            ]);
            
        } catch (PDOException $e) {
            $this->json([
                'success' => false,
                'message' => 'Error de conexión a base de datos: ' . $e->getMessage()
            ]);
        }
    }
    
    private function processMailerConfig() {
        $rules = [
            'mail_host' => 'required',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|email',
            'mail_password' => 'required',
            'mail_encryption' => 'required|in:tls,ssl',
            'mail_from_name' => 'required'
        ];
        
        $data = $this->getAllInput();
        
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $this->json([
                'success' => false,
                'message' => 'Configuración de correo inválida',
                'errors' => $validator->getErrors()
            ]);
            return;
        }
        
        // Test email configuration
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $data['mail_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $data['mail_username'];
            $mail->Password = $data['mail_password'];
            $mail->SMTPSecure = $data['mail_encryption'];
            $mail->Port = $data['mail_port'];
            
            // Test connection
            $mail->smtpConnect();
            $mail->smtpClose();
            
            // Store mailer config in session
            Session::set('install_mail_config', $data);
            
            $this->json([
                'success' => true,
                'message' => 'Configuración de correo validada exitosamente',
                'next_step' => 4
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'message' => 'Error en configuración de correo: ' . $e->getMessage()
            ]);
        }
    }
    
    private function processSuperAdminConfig() {
        $rules = [
            'admin_nombre' => 'required|min:2',
            'admin_apellidos' => 'required|min:2',
            'admin_email' => 'required|email',
            'admin_rut' => 'required|rut',
            'admin_telefono' => 'required|phone',
            'admin_password' => 'required|min:6',
            'admin_password_confirmation' => 'required|confirmed'
        ];
        
        $data = $this->getAllInput();
        
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $this->json([
                'success' => false,
                'message' => 'Datos del super administrador inválidos',
                'errors' => $validator->getErrors()
            ]);
            return;
        }
        
        // Store super admin config in session
        Session::set('install_admin_config', $data);
        
        $this->json([
            'success' => true,
            'message' => 'Configuración de super administrador validada',
            'next_step' => 5
        ]);
    }
    
    private function finishInstallation() {
        try {
            // Get all configurations from session
            $dbConfig = Session::get('install_db_config');
            $mailConfig = Session::get('install_mail_config');
            $adminConfig = Session::get('install_admin_config');
            
            if (!$dbConfig || !$mailConfig || !$adminConfig) {
                throw new Exception('Configuraciones incompletas');
            }
            
            // Create .env file
            $this->createEnvFile($dbConfig, $mailConfig);
            
            // Create database schema
            $this->createDatabaseSchema($dbConfig);
            
            // Create super admin user
            $this->createSuperAdmin($dbConfig, $adminConfig);
            
            // Clear installation session data
            Session::remove('install_db_config');
            Session::remove('install_mail_config');
            Session::remove('install_admin_config');
            
            $this->json([
                'success' => true,
                'message' => 'Instalación completada exitosamente',
                'redirect' => '/superadmin/login'
            ]);
            
        } catch (Exception $e) {
            $this->json([
                'success' => false,
                'message' => 'Error durante la instalación: ' . $e->getMessage()
            ]);
        }
    }
    
    private function createEnvFile($dbConfig, $mailConfig) {
        $envContent = "# Configuración de Base de Datos\n";
        $envContent .= "DB_HOST={$dbConfig['db_host']}\n";
        $envContent .= "DB_NAME={$dbConfig['db_name']}\n";
        $envContent .= "DB_USER={$dbConfig['db_user']}\n";
        $envContent .= "DB_PASSWORD={$dbConfig['db_password']}\n\n";
        
        $envContent .= "# Configuración de PHPMailer\n";
        $envContent .= "MAIL_HOST={$mailConfig['mail_host']}\n";
        $envContent .= "MAIL_PORT={$mailConfig['mail_port']}\n";
        $envContent .= "MAIL_USERNAME={$mailConfig['mail_username']}\n";
        $envContent .= "MAIL_PASSWORD={$mailConfig['mail_password']}\n";
        $envContent .= "MAIL_ENCRYPTION={$mailConfig['mail_encryption']}\n";
        $envContent .= "MAIL_FROM_ADDRESS={$mailConfig['mail_username']}\n";
        $envContent .= "MAIL_FROM_NAME=\"{$mailConfig['mail_from_name']}\"\n\n";
        
        $envContent .= "# Configuración de la Aplicación\n";
        $envContent .= "APP_NAME=\"Rifas Chile\"\n";
        $envContent .= "APP_URL=http://localhost/app/public\n";
        $envContent .= "APP_DEBUG=false\n";
        $envContent .= "APP_TIMEZONE=America/Santiago\n\n";
        
        $envContent .= "# Configuración de Seguridad\n";
        $envContent .= "APP_KEY=" . bin2hex(random_bytes(32)) . "\n";
        $envContent .= "SESSION_LIFETIME=120\n\n";
        
        $envContent .= "# Configuración SEO y Analytics\n";
        $envContent .= "GOOGLE_ANALYTICS_ID=\n";
        $envContent .= "GOOGLE_TAG_MANAGER_ID=\n";
        $envContent .= "FACEBOOK_PIXEL_ID=\n\n";
        
        $envContent .= "# Configuración de Archivos\n";
        $envContent .= "UPLOAD_MAX_SIZE=5242880\n";
        $envContent .= "ALLOWED_FILE_TYPES=jpg,jpeg,png,gif,pdf\n";
        
        if (!file_put_contents(__DIR__ . '/../../.env', $envContent)) {
            throw new Exception('No se pudo crear el archivo .env');
        }
    }
    
    private function createDatabaseSchema($dbConfig) {
        $pdo = new PDO(
            "mysql:host={$dbConfig['db_host']};dbname={$dbConfig['db_name']};charset=utf8mb4",
            $dbConfig['db_user'],
            $dbConfig['db_password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        $schema = file_get_contents(__DIR__ . '/../../scripts/database_schema.sql');
        
        // Execute schema in chunks to handle multiple statements
        $statements = array_filter(array_map('trim', explode(';', $schema)));
        
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
    }
    
    private function createSuperAdmin($dbConfig, $adminConfig) {
        $pdo = new PDO(
            "mysql:host={$dbConfig['db_host']};dbname={$dbConfig['db_name']};charset=utf8mb4",
            $dbConfig['db_user'],
            $dbConfig['db_password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        $hashedPassword = password_hash($adminConfig['admin_password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rut, telefono, tipo, datos_completos, estado) 
                VALUES (?, ?, ?, ?, ?, ?, 'superadmin', 1, 'activo')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $adminConfig['admin_nombre'],
            $adminConfig['admin_apellidos'],
            $adminConfig['admin_email'],
            $hashedPassword,
            $adminConfig['admin_rut'],
            $adminConfig['admin_telefono']
        ]);
    }
    
    private function renderInstallView($view, $data = []) {
        $viewFile = __DIR__ . '/../../app/Views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            echo "Vista no encontrada: {$view}";
            return;
        }
        
        extract($data);
        include $viewFile;
    }
}
