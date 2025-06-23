<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Usuario.php';

class AuthController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
        // El mailer ya está disponible desde la clase padre como $this->mailer
    }

    /**
     * Mostrar formulario de login
     */
    public function login()
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/login', [
            'title' => 'Iniciar Sesión - Rifas Chile',
            'meta_description' => 'Inicia sesión en tu cuenta de Rifas Chile',
            'page_class' => 'auth-page'
        ]);
    }

    /**
     * Procesar login
     */
    public function processLogin()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // Validación básica
            if (empty($email) || empty($password)) {
                throw new Exception('Email y contraseña son requeridos');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Email no válido');
            }

            // Intentar autenticar
            $usuario = $this->usuarioModel->authenticate($email, $password);

            if (!$usuario) {
                throw new Exception('Credenciales incorrectas');
            }

            // Verificar si el usuario está activo
            if ($usuario['estado'] !== 'activo') {
                throw new Exception('Su cuenta no está activa. Contacte al administrador.');
            }

            // Iniciar sesión
            $this->session->login($usuario['id'], $remember);

            // Log de acción
            $this->actionLogger->log(
                $usuario['id'],
                'auth',
                'login',
                'Usuario inició sesión',
                ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']
            );

            // Respuesta JSON para AJAX
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');                echo json_encode([
                    'success' => true,
                    'message' => 'Bienvenido de vuelta',
                    'redirect' => url('dashboard')
                ]);
                exit;
            }

            $this->session->setFlash('success', 'Bienvenido de vuelta');
            $this->redirect(url('dashboard'));

        } catch (Exception $e) {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }            $this->session->setFlash('error', $e->getMessage());
            $this->redirect(url('login'));
        }
    }

    /**
     * Mostrar formulario de registro
     */    public function register()
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect(url('dashboard'));
        }

        $this->view('auth/register', [
            'title' => 'Crear Cuenta de Administrador - Rifas Chile',
            'meta_description' => 'Crea tu cuenta de Administrador en Rifas Chile y gestiona tus rifas',
            'page_class' => 'auth-page'
        ]);
    }

    /**
     * Procesar registro
     */    public function processRegister()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }            // Re-enable CSRF validation now that we've fixed the redirect URLs
            $this->validateCSRF();
            
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellido'] ?? ''), // Note: DB field is 'apellidos'
                'email' => trim($_POST['email'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'rut' => trim($_POST['rut'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? '',
                'acepta_terminos' => isset($_POST['acepta_terminos'])
            ];

            // Validaciones
            $this->validateRegistrationData($data);

            // Verificar si el email ya existe
            if ($this->usuarioModel->existsByEmail($data['email'])) {
                throw new Exception('El email ya está registrado');
            }

            // Verificar si el RUT ya existe
            if ($this->usuarioModel->existsByRut($data['rut'])) {
                throw new Exception('El RUT ya está registrado');
            }            // Crear usuario como Administrador (según los requisitos, los registros públicos deben ser Admin)
            $userId = $this->usuarioModel->create([
                'nombre' => $data['nombre'],
                'apellidos' => $data['apellidos'], // Using correct DB field name
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'rut' => $data['rut'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'tipo' => 'admin',
                'estado' => 'activo'
            ]);

            // Log de acción
            $this->actionLogger->log(
                $userId,
                'auth',
                'register',
                'Usuario se registró',
                ['email' => $data['email'], 'rut' => $data['rut']]
            );

            // Respuesta exitosa
            if ($this->isAjaxRequest()) {                header('Content-Type: application/json');                echo json_encode([
                    'success' => true,
                    'message' => 'Cuenta de Administrador creada exitosamente. Ya puedes iniciar sesión.',
                    'redirect' => url('login')
                ]);
                exit;
            }            $this->session->setFlash('success', 'Cuenta de Administrador creada exitosamente. Ya puedes iniciar sesión.');
            $this->redirect(url('login'));

        } catch (Exception $e) {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }

            $this->session->setFlash('error', $e->getMessage());
            $this->redirect('/register');
        }
    }

    /**
     * Cerrar sesión
     */    public function logout()
    {
        $userId = $this->session->getUserId();
        
        if ($userId) {
            $this->actionLogger->log(
                $userId,
                'auth',
                'logout',
                'Usuario cerró sesión'
            );
        }        
        $this->session->logout();
        $this->session->setFlash('success', 'Sesión cerrada exitosamente');
        // Fix to ensure we redirect to the correct base URL
        $this->redirect(url(''));
    }

    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function forgotPassword()
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/forgot-password', [
            'title' => 'Recuperar Contraseña - Rifas Chile',
            'meta_description' => 'Recupera tu contraseña de Rifas Chile',
            'page_class' => 'auth-page'
        ]);
    }

    /**
     * Procesar solicitud de recuperación
     */
    public function processForgotPassword()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $email = trim($_POST['email'] ?? '');

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Email válido es requerido');
            }

            // Verificar si el usuario existe
            $usuario = $this->usuarioModel->findByEmail($email);
            if (!$usuario) {
                throw new Exception('No se encontró una cuenta con ese email');
            }

            // Generar token de recuperación
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->usuarioModel->createPasswordResetToken($usuario['id'], $token, $expires);

            // Enviar email (implementar con PHPMailer)
            $this->sendPasswordResetEmail($usuario, $token);

            // Log de acción
            $this->actionLogger->log(
                $usuario['id'],
                'auth',
                'password_reset_request',
                'Usuario solicitó recuperación de contraseña'
            );

            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Se ha enviado un enlace de recuperación a tu email'
                ]);
                exit;
            }

            $this->session->setFlash('success', 'Se ha enviado un enlace de recuperación a tu email');
            $this->redirect('/login');

        } catch (Exception $e) {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }

            $this->session->setFlash('error', $e->getMessage());
            $this->redirect('/forgot-password');
        }
    }

    /**
     * Validar datos de registro
     */
    private function validateRegistrationData($data)
    {
        if (empty($data['nombre'])) {
            throw new Exception('El nombre es requerido');
        }        if (empty($data['apellidos'])) {
            throw new Exception('El apellido es requerido');
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email válido es requerido');
        }        if (empty($data['rut']) || !ChileanHelper::validateRUT($data['rut'])) {
            throw new Exception('RUT válido es requerido');
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            throw new Exception('La contraseña debe tener al menos 6 caracteres');
        }

        if ($data['password'] !== $data['password_confirm']) {
            throw new Exception('Las contraseñas no coinciden');
        }

        if (!$data['acepta_terminos']) {
            throw new Exception('Debe aceptar los términos y condiciones');
        }
    }    /**
     * Enviar email de recuperación de contraseña
     */
    private function sendPasswordResetEmail($usuario, $token)
    {
        return $this->mailer->sendPasswordReset($usuario['email'], $usuario['nombre'], $token);    }
}
