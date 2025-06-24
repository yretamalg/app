<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/ChileanHelper.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Rifa.php';
require_once __DIR__ . '/../Models/Vendedor.php';

class Admin extends Controller
{
    private $usuarioModel;
    private $rifaModel;
    private $vendedorModel;    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
        $this->rifaModel = new Rifa();
        $this->vendedorModel = new Vendedor();
    }

    /**
     * Verificación de permisos para acciones de administrador
     */
    private function checkAdminPermission()
    {
        if (!$this->session->isLoggedIn() || $this->session->userType() !== 'admin') {
            $this->session->setFlash('error', 'No tienes permisos para acceder a esta sección');
            redirect(url('login'));
        }
    }

    /**
     * Dashboard para administradores
     */    public function dashboard()
    {
        $this->checkAdminPermission();
        
        // Obtener datos para el dashboard
        $userId = $this->session->user()['id'];
        $stats = [
            'rifas_activas' => $this->rifaModel->countRifasByAdminAndStatus($userId, 'activa'),
            'rifas_total' => $this->rifaModel->countRifasByAdmin($userId),
            'vendedores_activos' => $this->vendedorModel->countActiveVendedoresByAdmin($userId),
            'ventas_mes' => $this->rifaModel->getTotalSalesForCurrentMonth($userId)
        ];
        
        // Obtener rifas recientes
        $recentRifas = $this->rifaModel->getLatestRifasByAdmin($userId, 5);
        
        // Obtener aprobaciones pendientes
        $pendingApprovals = $this->rifaModel->getPendingApprovalsByAdmin($userId);
        
        $this->render('dashboard/admin', [
            'user' => $this->session->user(),
            'stats' => $stats,
            'recentRifas' => $recentRifas,
            'pendingApprovals' => $pendingApprovals,
            'pageTitle' => 'Panel de Administración'
        ]);
    }

    /**
     * Perfil del administrador
     */
    public function perfil()
    {
        $this->checkAdminPermission();
        $usuario = $this->usuarioModel->getById($this->session->user()['id']);
        
        $this->render('admin/perfil', [
            'usuario' => $usuario,
            'pageTitle' => 'Mi Perfil'
        ]);
    }

    /**
     * Actualizar perfil del administrador
     */
    public function actualizarPerfil()
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/perfil'));
        }
        
        $data = [
            'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'rut' => filter_input(INPUT_POST, 'rut', FILTER_SANITIZE_STRING),
            'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
        ];        
        // Validar RUT chileno
        if (!ChileanHelper::validateRUT($data['rut'])) {
            $this->session->setFlash('error', 'El RUT ingresado no es válido');
            redirect(url('admin/perfil'));
        }
        
        // Actualizar contraseña si se proporcionó
        $password = filter_input(INPUT_POST, 'password');
        if (!empty($password)) {
            $confirmPassword = filter_input(INPUT_POST, 'confirm_password');
            
            if ($password !== $confirmPassword) {
                $this->session->setFlash('error', 'Las contraseñas no coinciden');
                redirect(url('admin/perfil'));
            }
            
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Actualizar imagen de perfil si se proporcionó
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadProfileImage($_FILES['profile_image']);
            
            if ($uploadResult['success']) {
                $data['imagen'] = $uploadResult['path'];
            } else {
                $this->session->setFlash('error', $uploadResult['message']);
                redirect(url('admin/perfil'));
            }
        }
        
        $result = $this->usuarioModel->update($this->session->user()['id'], $data);
        
        if ($result) {
            // Actualizar datos de sesión
            $updatedUser = $this->usuarioModel->getById($this->session->user()['id']);
            $this->session->setUser($updatedUser);
            
            $this->actionLogger->log('perfil_actualizado', 'Usuario actualizó su perfil', $this->session->user()['id']);
            $this->session->setFlash('success', 'Perfil actualizado correctamente');
        } else {
            $this->session->setFlash('error', 'No se pudo actualizar el perfil');
        }
        
        redirect(url('admin/perfil'));
    }    /**
     * Listado de rifas con filtrado y paginación
     */
    public function rifas()
    {
        $this->checkAdminPermission();
        
        // Parámetros de paginación
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;
        
        // Filtros
        $filters = [
            'admin_id' => $this->session->user()['id'],
            'estado' => !empty($_GET['estado']) ? $_GET['estado'] : null,
            'tipo' => !empty($_GET['tipo']) ? $_GET['tipo'] : null,
            'search' => !empty($_GET['q']) ? $_GET['q'] : null,
            'fecha_desde' => !empty($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null,
            'fecha_hasta' => !empty($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null,
            'limit' => $perPage,
            'offset' => $offset
        ];
        
        // Obtener rifas con filtro y paginación
        $rifas = $this->rifaModel->filterRifas($filters);
        
        // Obtener total para paginación
        $total = $this->rifaModel->countFilteredRifas($filters);
        $totalPages = ceil($total / $perPage);
        
        $this->render('admin/rifas/index', [
            'rifas' => $rifas,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'pageTitle' => 'Gestión de Rifas'
        ]);
    }

    /**
     * Formulario para crear rifa
     */
    public function crearRifa()
    {
        $this->checkAdminPermission();
        
        $this->render('admin/rifas/crear', [
            'pageTitle' => 'Crear Nueva Rifa'
        ]);
    }

    /**
     * Guardar nueva rifa
     */
    public function guardarRifa()
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/rifas/crear'));
        }
        
        $data = [
            'titulo' => filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING),
            'descripcion' => $_POST['descripcion'], // Usar htmlpurifier más adelante
            'fecha_sorteo' => filter_input(INPUT_POST, 'fecha_sorteo', FILTER_SANITIZE_STRING),
            'precio_numero' => filter_input(INPUT_POST, 'precio_numero', FILTER_SANITIZE_NUMBER_INT),
            'numeros_desde' => filter_input(INPUT_POST, 'numeros_desde', FILTER_SANITIZE_NUMBER_INT),
            'numeros_hasta' => filter_input(INPUT_POST, 'numeros_hasta', FILTER_SANITIZE_NUMBER_INT),
            'premio_principal' => filter_input(INPUT_POST, 'premio_principal', FILTER_SANITIZE_STRING),
            'premios_secundarios' => $_POST['premios_secundarios'] ?? '', // Usar htmlpurifier más adelante
            'estado' => 'borrador', // Por defecto es borrador
            'id_admin' => $this->session->user()['id'],
            'slug' => $this->generateSlug(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING))
        ];
        
        // Validaciones
        if (empty($data['titulo']) || empty($data['descripcion']) || empty($data['fecha_sorteo'])) {
            $this->session->setFlash('error', 'Todos los campos son obligatorios');
            redirect(url('admin/rifas/crear'));
        }
        
        // Validar que la fecha de sorteo sea futura
        $fechaSorteo = new DateTime($data['fecha_sorteo']);
        $hoy = new DateTime();
        
        if ($fechaSorteo <= $hoy) {
            $this->session->setFlash('error', 'La fecha del sorteo debe ser futura');
            redirect(url('admin/rifas/crear'));
        }
        
        // Validar rango de números
        if ((int)$data['numeros_desde'] >= (int)$data['numeros_hasta']) {
            $this->session->setFlash('error', 'El rango de números no es válido');
            redirect(url('admin/rifas/crear'));
        }
        
        // Subir imagen de la rifa
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadRifaImage($_FILES['imagen']);
            
            if ($uploadResult['success']) {
                $data['imagen'] = $uploadResult['path'];
            } else {
                $this->session->setFlash('error', $uploadResult['message']);
                redirect(url('admin/rifas/crear'));
            }
        } else {
            $this->session->setFlash('error', 'La imagen de la rifa es obligatoria');
            redirect(url('admin/rifas/crear'));
        }
        
        $rifaId = $this->rifaModel->create($data);
        
        if ($rifaId) {
            $this->actionLogger->log('rifa_creada', 'Rifa creada: ' . $data['titulo'], $this->session->user()['id']);
            $this->session->setFlash('success', 'Rifa creada correctamente');
            redirect(url('admin/rifas/' . $rifaId));
        } else {
            $this->session->setFlash('error', 'No se pudo crear la rifa');
            redirect(url('admin/rifas/crear'));
        }
    }

    /**
     * Ver detalles de una rifa
     */
    public function verRifa($id)
    {
        $this->checkAdminPermission();
        
        $rifa = $this->rifaModel->getById($id);
        
        if (!$rifa || $rifa['id_admin'] != $this->session->user()['id']) {
            $this->session->setFlash('error', 'Rifa no encontrada');
            redirect(url('admin/rifas'));
        }
        
        $estadisticas = $this->rifaModel->getStatistics($id);
        $vendedoresAsignados = $this->vendedorModel->getVendedoresByRifa($id);
        
        $this->render('admin/rifas/ver', [
            'rifa' => $rifa,
            'estadisticas' => $estadisticas,
            'vendedores' => $vendedoresAsignados,
            'pageTitle' => 'Rifa: ' . $rifa['titulo']
        ]);
    }

    /**
     * Formulario para editar rifa
     */
    public function editarRifa($id)
    {
        $this->checkAdminPermission();
        
        $rifa = $this->rifaModel->getById($id);
        
        if (!$rifa || $rifa['id_admin'] != $this->session->user()['id']) {
            $this->session->setFlash('error', 'Rifa no encontrada');
            redirect(url('admin/rifas'));
        }
        
        $this->render('admin/rifas/editar', [
            'rifa' => $rifa,
            'pageTitle' => 'Editar Rifa: ' . $rifa['titulo']
        ]);
    }

    /**
     * Actualizar rifa
     */
    public function actualizarRifa($id)
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/rifas/' . $id . '/editar'));
        }
        
        $rifa = $this->rifaModel->getById($id);
        
        if (!$rifa || $rifa['id_admin'] != $this->session->user()['id']) {
            $this->session->setFlash('error', 'Rifa no encontrada');
            redirect(url('admin/rifas'));
        }
        
        $data = [
            'titulo' => filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING),
            'descripcion' => $_POST['descripcion'], // Usar htmlpurifier más adelante
            'fecha_sorteo' => filter_input(INPUT_POST, 'fecha_sorteo', FILTER_SANITIZE_STRING),
            'precio_numero' => filter_input(INPUT_POST, 'precio_numero', FILTER_SANITIZE_NUMBER_INT),
            'premio_principal' => filter_input(INPUT_POST, 'premio_principal', FILTER_SANITIZE_STRING),
            'premios_secundarios' => $_POST['premios_secundarios'] ?? '', // Usar htmlpurifier más adelante
        ];
        
        // Validaciones básicas
        if (empty($data['titulo']) || empty($data['descripcion']) || empty($data['fecha_sorteo'])) {
            $this->session->setFlash('error', 'Todos los campos son obligatorios');
            redirect(url('admin/rifas/' . $id . '/editar'));
        }
        
        // No permitir cambiar los números si ya hay ventas
        if ($this->rifaModel->hasAnySold($id)) {
            unset($data['numeros_desde']);
            unset($data['numeros_hasta']);
        } else {
            $data['numeros_desde'] = filter_input(INPUT_POST, 'numeros_desde', FILTER_SANITIZE_NUMBER_INT);
            $data['numeros_hasta'] = filter_input(INPUT_POST, 'numeros_hasta', FILTER_SANITIZE_NUMBER_INT);
            
            // Validar rango de números
            if ((int)$data['numeros_desde'] >= (int)$data['numeros_hasta']) {
                $this->session->setFlash('error', 'El rango de números no es válido');
                redirect(url('admin/rifas/' . $id . '/editar'));
            }
        }
        
        // Actualizar slug si cambió el título
        if ($data['titulo'] !== $rifa['titulo']) {
            $data['slug'] = $this->generateSlug($data['titulo']);
        }
        
        // Subir nueva imagen si se proporciona
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadRifaImage($_FILES['imagen']);
            
            if ($uploadResult['success']) {
                $data['imagen'] = $uploadResult['path'];
                // Eliminar imagen anterior
                if (!empty($rifa['imagen']) && file_exists(PUBLIC_PATH . $rifa['imagen'])) {
                    unlink(PUBLIC_PATH . $rifa['imagen']);
                }
            } else {
                $this->session->setFlash('error', $uploadResult['message']);
                redirect(url('admin/rifas/' . $id . '/editar'));
            }
        }
        
        $result = $this->rifaModel->update($id, $data);
        
        if ($result) {
            $this->actionLogger->log('rifa_actualizada', 'Rifa actualizada: ' . $data['titulo'], $this->session->user()['id']);
            $this->session->setFlash('success', 'Rifa actualizada correctamente');
        } else {
            $this->session->setFlash('error', 'No se pudo actualizar la rifa');
        }
        
        redirect(url('admin/rifas/' . $id));
    }

    /**
     * Publicar una rifa
     */
    public function publicarRifa($id)
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/rifas/' . $id));
        }
        
        $rifa = $this->rifaModel->getById($id);
        
        if (!$rifa || $rifa['id_admin'] != $this->session->user()['id']) {
            $this->session->setFlash('error', 'Rifa no encontrada');
            redirect(url('admin/rifas'));
        }
        
        if ($rifa['estado'] === 'publicada') {
            $this->session->setFlash('info', 'La rifa ya está publicada');
            redirect(url('admin/rifas/' . $id));
        }
        
        $result = $this->rifaModel->updateStatus($id, 'publicada');
        
        if ($result) {
            $this->actionLogger->log('rifa_publicada', 'Rifa publicada: ' . $rifa['titulo'], $this->session->user()['id']);
            $this->session->setFlash('success', 'Rifa publicada correctamente');
        } else {
            $this->session->setFlash('error', 'No se pudo publicar la rifa');
        }
        
        redirect(url('admin/rifas/' . $id));
    }

    /**
     * Suspender una rifa
     */
    public function suspenderRifa($id)
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/rifas/' . $id));
        }
        
        $rifa = $this->rifaModel->getById($id);
        
        if (!$rifa || $rifa['id_admin'] != $this->session->user()['id']) {
            $this->session->setFlash('error', 'Rifa no encontrada');
            redirect(url('admin/rifas'));
        }
        
        if ($rifa['estado'] === 'suspendida') {
            $this->session->setFlash('info', 'La rifa ya está suspendida');
            redirect(url('admin/rifas/' . $id));
        }
        
        $result = $this->rifaModel->updateStatus($id, 'suspendida');
        
        if ($result) {
            $this->actionLogger->log('rifa_suspendida', 'Rifa suspendida: ' . $rifa['titulo'], $this->session->user()['id']);
            $this->session->setFlash('success', 'Rifa suspendida correctamente');
        } else {
            $this->session->setFlash('error', 'No se pudo suspender la rifa');
        }
        
        redirect(url('admin/rifas/' . $id));
    }

    // Métodos para gestión de vendedores
    public function vendedores()
    {
        $this->checkAdminPermission();
        
        $vendedores = $this->vendedorModel->getAllByAdmin($this->session->user()['id']);
        
        $this->render('admin/vendedores/index', [
            'vendedores' => $vendedores,
            'pageTitle' => 'Gestión de Vendedores'
        ]);
    }

    public function crearVendedor()
    {
        $this->checkAdminPermission();
        
        $this->render('admin/vendedores/crear', [
            'pageTitle' => 'Crear Nuevo Vendedor'
        ]);
    }

    public function guardarVendedor()
    {
        $this->checkAdminPermission();
        
        // Validar el token CSRF
        if (!$this->validateCsrfToken()) {
            $this->session->setFlash('error', 'Error de seguridad. Por favor intenta nuevamente.');
            redirect(url('admin/vendedores/crear'));
        }
        
        $data = [
            'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'rut' => filter_input(INPUT_POST, 'rut', FILTER_SANITIZE_STRING),
            'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
            'password' => password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT),
            'estado' => 'activo',
            'tipo' => 'vendedor',
            'id_admin' => $this->session->user()['id'],
            'slug' => $this->generateSlug(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING))
        ];
          // Validar RUT chileno
        if (!ChileanHelper::validateRUT($data['rut'])) {
            $this->session->setFlash('error', 'El RUT ingresado no es válido');
            redirect(url('admin/vendedores/crear'));
        }
        
        // Validar que el email no exista
        if ($this->usuarioModel->emailExists($data['email'])) {
            $this->session->setFlash('error', 'El email ya está registrado');
            redirect(url('admin/vendedores/crear'));
        }
        
        // Validar que el RUT no exista
        if ($this->usuarioModel->rutExists($data['rut'])) {
            $this->session->setFlash('error', 'El RUT ya está registrado');
            redirect(url('admin/vendedores/crear'));
        }
        
        $vendedorId = $this->usuarioModel->create($data);
        
        if ($vendedorId) {
            // Enviar email de bienvenida
            // TODO: Implement proper mailer
            // $this->mailer->enviarEmailBienvenidaVendedor($data['email'], $data['nombre'], filter_input(INPUT_POST, 'password'));
            
            $this->actionLogger->log('vendedor_creado', 'Vendedor creado: ' . $data['nombre'], $this->session->user()['id']);
            $this->session->setFlash('success', 'Vendedor creado correctamente');
            redirect(url('admin/vendedores'));
        } else {
            $this->session->setFlash('error', 'No se pudo crear el vendedor');
            redirect(url('admin/vendedores/crear'));
        }
    }    // Método auxiliar para generar slug único
    private function generateSlug($string)
    {
        // Reemplazar caracteres especiales y espacios
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', removeAccents($string))));
        
        // Verificar si el slug ya existe y añadir un número al final si es necesario
        $originalSlug = $slug;
        $count = 1;
        
        while ($this->rifaModel->slugExists($slug) || $this->usuarioModel->slugExists($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }

    // Método auxiliar para subir imagen de perfil
    private function uploadProfileImage($file)
    {
        $targetDir = '/uploads/usuarios/';
        $filename = uniqid() . '-' . basename($file['name']);
        $targetFile = PUBLIC_PATH . $targetDir . $filename;
        
        // Verificar que sea una imagen
        $check = getimagesize($file['tmp_name']);
        if (!$check) {
            return [
                'success' => false, 
                'message' => 'El archivo seleccionado no es una imagen válida'
            ];
        }
        
        // Verificar extensión
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return [
                'success' => false, 
                'message' => 'Solo se permiten archivos JPG, JPEG y PNG'
            ];
        }
        
        // Verificar tamaño (máximo 5MB)
        if ($file['size'] > 5000000) {
            return [
                'success' => false, 
                'message' => 'La imagen debe pesar menos de 5MB'
            ];
        }
        
        // Crear directorio si no existe
        if (!file_exists(PUBLIC_PATH . $targetDir)) {
            mkdir(PUBLIC_PATH . $targetDir, 0777, true);
        }
        
        // Subir archivo
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [
                'success' => true,
                'path' => $targetDir . $filename
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al subir la imagen'
            ];
        }
    }

    // Método auxiliar para subir imagen de rifa
    private function uploadRifaImage($file)
    {
        $targetDir = '/uploads/rifas/';
        $filename = uniqid() . '-' . basename($file['name']);
        $targetFile = PUBLIC_PATH . $targetDir . $filename;
        
        // Verificar que sea una imagen
        $check = getimagesize($file['tmp_name']);
        if (!$check) {
            return [
                'success' => false, 
                'message' => 'El archivo seleccionado no es una imagen válida'
            ];
        }
        
        // Verificar extensión
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return [
                'success' => false, 
                'message' => 'Solo se permiten archivos JPG, JPEG y PNG'
            ];
        }
        
        // Verificar tamaño (máximo 5MB)
        if ($file['size'] > 5000000) {
            return [
                'success' => false, 
                'message' => 'La imagen debe pesar menos de 5MB'
            ];
        }
        
        // Crear directorio si no existe
        if (!file_exists(PUBLIC_PATH . $targetDir)) {
            mkdir(PUBLIC_PATH . $targetDir, 0777, true);
        }
        
        // Subir archivo
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [
                'success' => true,
                'path' => $targetDir . $filename
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al subir la imagen'
            ];
        }
    }

    /**
     * Valida el token CSRF
     */
    private function validateCsrfToken()
    {
        $token = filter_input(INPUT_POST, 'csrf_token');
        return $this->session->validateCSRFToken($token);
    }
}
