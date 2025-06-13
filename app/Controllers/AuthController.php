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
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Bienvenido de vuelta',
                    'redirect' => '/dashboard'
                ]);
                exit;
            }

            $this->session->setFlash('success', 'Bienvenido de vuelta');
            $this->redirect('/dashboard');

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
            $this->redirect('/login');
        }
    }

    /**
     * Mostrar formulario de registro
     */
    public function register()
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/register', [
            'title' => 'Crear Cuenta - Rifas Chile',
            'meta_description' => 'Crea tu cuenta en Rifas Chile y participa en nuestras rifas',
            'page_class' => 'auth-page'
        ]);
    }

    /**
     * Procesar registro
     */
    public function processRegister()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
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
            }

            // Crear usuario
            $userId = $this->usuarioModel->create([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'rut' => $data['rut'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'tipo' => 'comprador',
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
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Cuenta creada exitosamente. Ya puedes iniciar sesión.',
                    'redirect' => '/login'
                ]);
                exit;
            }

            $this->session->setFlash('success', 'Cuenta creada exitosamente. Ya puedes iniciar sesión.');
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
            $this->redirect('/register');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout()
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
        $this->redirect('/');
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
        }

        if (empty($data['apellido'])) {
            throw new Exception('El apellido es requerido');
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email válido es requerido');
        }

        if (empty($data['rut']) || !$this->chileanHelper->validateRut($data['rut'])) {
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
    }

    /**
     * Enviar email de recuperación de contraseña
     */
    private function sendPasswordResetEmail($usuario, $token)
    {
        $resetUrl = "http://{$_SERVER['HTTP_HOST']}/reset-password?token={$token}";
        
        $subject = 'Recuperación de Contraseña - Rifas Chile';
        $body = "
            <h2>Recuperación de Contraseña</h2>
            <p>Hola {$usuario['nombre']},</p>
            <p>Has solicitado recuperar tu contraseña. Haz clic en el siguiente enlace para crear una nueva contraseña:</p>
            <p><a href='{$resetUrl}' style='background: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Recuperar Contraseña</a></p>
            <p>Este enlace expirará en 1 hora.</p>
            <p>Si no solicitaste este cambio, puedes ignorar este email.</p>
            <br>
            <p>Saludos,<br>Equipo Rifas Chile</p>
        ";

        return $this->mailer->send($usuario['email'], $subject, $body);
    }

    /**
     * Verificar si es una petición AJAX
     */
    private function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
