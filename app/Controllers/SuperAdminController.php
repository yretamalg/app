<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Usuario.php';

class SuperAdminController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
        $this->requireAuth(['superadmin']);
    }

    /**
     * Formulario de login específico para SuperAdmin
     */
    public function loginForm()
    {
        if ($this->session->isLoggedIn() && $this->session->userType() === 'superadmin') {
            $this->redirect(url('superadmin'));
        }

        $this->view('auth/superadmin/login', [
            'title' => 'Acceso SuperAdmin - Rifas Chile',
            'meta_description' => 'Panel de SuperAdministrador de Rifas Chile',
            'page_class' => 'admin-page'
        ]);
    }

    /**
     * Procesa el login de superadmin
     */
    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            // Validate CSRF token
            $this->validateCSRF();

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validación básica
            if (empty($email) || empty($password)) {
                throw new Exception('Email y contraseña son requeridos');
            }

            // Intentar autenticar pero solo para superadmin
            $usuario = $this->usuarioModel->authenticateSuperAdmin($email, $password);

            if (!$usuario) {
                throw new Exception('Credenciales incorrectas o no tienes privilegios de SuperAdmin');
            }

            // Iniciar sesión
            $this->session->login($usuario['id']);

            // Log de acción
            $this->actionLogger->log(
                $usuario['id'],
                'auth',
                'superadmin_login',
                'SuperAdmin inició sesión',
                ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']
            );

            $this->redirect(url('superadmin'));

        } catch (Exception $e) {
            $this->session->setFlash('error', $e->getMessage());
            $this->redirect(url('superadmin/login'));
        }
    }

    /**
     * Dashboard del SuperAdmin
     */
    public function dashboard()
    {
        $stats = [
            'total_usuarios' => $this->usuarioModel->countAll(),
            'total_admins' => $this->usuarioModel->countByType('admin'),
            'total_vendedores' => $this->usuarioModel->countByType('vendedor'),
            'total_compradores' => $this->usuarioModel->countByType('comprador')
        ];

        $this->view('admin/superadmin/dashboard', [
            'title' => 'Panel SuperAdmin - Rifas Chile',
            'meta_description' => 'Panel de control del SuperAdministrador',
            'stats' => $stats
        ]);
    }

    /**
     * Lista de usuarios
     */
    public function usuarios()
    {
        $usuarios = $this->usuarioModel->getAll();

        $this->view('admin/superadmin/usuarios', [
            'title' => 'Gestión de Usuarios - SuperAdmin',
            'usuarios' => $usuarios
        ]);
    }

    /**
     * Formulario para crear usuario
     */
    public function crearUsuario()
    {
        $this->view('admin/superadmin/usuarios_crear', [
            'title' => 'Crear Usuario - SuperAdmin'
        ]);
    }

    /**
     * Guardar nuevo usuario
     */
    public function guardarUsuario()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $this->validateCSRF();

            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellidos'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'rut' => trim($_POST['rut'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'tipo' => trim($_POST['tipo'] ?? 'comprador'),
                'estado' => 'activo',
                'organizacion' => trim($_POST['organizacion'] ?? ''),
                'is_particular' => isset($_POST['is_particular']) ? 1 : 0,
                'datos_completos' => isset($_POST['datos_completos']) ? 1 : 0
            ];

            // Validaciones
            if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
                throw new Exception('Nombre, email y contraseña son campos obligatorios');
            }

            if ($this->usuarioModel->existsByEmail($data['email'])) {
                throw new Exception('Ya existe un usuario con este email');
            }

            if (!empty($data['rut']) && $this->usuarioModel->existsByRut($data['rut'])) {
                throw new Exception('Ya existe un usuario con este RUT');
            }

            // Crear usuario
            $userId = $this->usuarioModel->create([
                'nombre' => $data['nombre'],
                'apellidos' => $data['apellidos'],
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'rut' => $data['rut'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'tipo' => $data['tipo'],
                'estado' => $data['estado'],
                'organizacion' => $data['organizacion'],
                'is_particular' => $data['is_particular'],
                'datos_completos' => $data['datos_completos']
            ]);

            // Log de acción
            $this->actionLogger->log(
                $this->session->getUserId(),
                'admin',
                'create_user',
                'SuperAdmin creó un nuevo usuario',
                ['tipo' => $data['tipo'], 'email' => $data['email']]
            );

            $this->session->setFlash('success', 'Usuario creado correctamente');
            $this->redirect(url('superadmin/usuarios'));

        } catch (Exception $e) {
            $this->session->setFlash('error', $e->getMessage());
            $this->redirect(url('superadmin/usuarios/crear'));
        }
    }

    /**
     * Vista para personificar a un usuario (drill-down)
     */
    public function personificar($id)
    {
        try {
            $usuario = $this->usuarioModel->find($id);
            
            if (!$usuario) {
                throw new Exception('Usuario no encontrado');
            }

            // Guardar el ID del superadmin actual para poder volver
            $this->session->set('superadmin_id', $this->session->getUserId());
            
            // Iniciar sesión como el usuario seleccionado
            $this->session->login($usuario['id']);

            // Log de acción
            $this->actionLogger->log(
                $this->session->get('superadmin_id'),
                'admin',
                'impersonate',
                'SuperAdmin personificó a otro usuario',
                ['usuario_id' => $id, 'tipo' => $usuario['tipo']]
            );

            // Redirigir según el tipo de usuario
            switch ($usuario['tipo']) {
                case 'admin':
                    $this->redirect(url('admin'));
                    break;
                case 'vendedor':
                    $this->redirect(url('vendedor'));
                    break;
                default:
                    $this->redirect(url('dashboard'));
            }

        } catch (Exception $e) {
            $this->session->setFlash('error', $e->getMessage());
            $this->redirect(url('superadmin/usuarios'));
        }
    }

    /**
     * Volver a la sesión de superadmin después de personificar
     */
    public function volverSuperAdmin()
    {
        if ($this->session->has('superadmin_id')) {
            $superadminId = $this->session->get('superadmin_id');
            
            // Log de acción antes de cambiar la sesión
            $this->actionLogger->log(
                $this->session->getUserId(),
                'admin',
                'end_impersonate',
                'Fin de personificación de usuario',
                ['superadmin_id' => $superadminId]
            );

            // Iniciar sesión como el superadmin original
            $this->session->login($superadminId);
            $this->session->remove('superadmin_id');
            
            $this->session->setFlash('success', 'Has vuelto a tu sesión de SuperAdmin');
            $this->redirect(url('superadmin'));
        } else {
            $this->session->setFlash('error', 'No se encontró una sesión de SuperAdmin');
            $this->redirect(url(''));
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
                'SuperAdmin cerró sesión'
            );
        }

        $this->session->logout();
        $this->session->setFlash('success', 'Sesión cerrada exitosamente');
        $this->redirect(url('superadmin/login'));
    }
}
