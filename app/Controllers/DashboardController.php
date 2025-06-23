<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Rifa.php';

class DashboardController extends Controller
{
    private $usuarioModel;
    private $rifaModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
        $this->rifaModel = new Rifa();
    }

    /**
     * Dashboard principal según tipo de usuario
     */
    public function index()
    {
        $this->requireAuth();
        
        $user = $this->session->user();
        $userType = $user['tipo'];

        // Redirigir según el tipo de usuario
        switch ($userType) {
            case 'superadmin':
                $this->superadminDashboard();
                break;
            case 'admin':
                $this->adminDashboard();
                break;
            case 'vendedor':
                $this->vendedorDashboard();
                break;
            case 'comprador':
            default:
                $this->compradorDashboard();
                break;
        }
    }

    /**
     * Dashboard del Super Administrador
     */    private function superadminDashboard()
    {
        $stats = [
            'usuarios_total' => $this->usuarioModel->count(),
            'rifas_activas' => 0, // Temporal: corregir cuando los métodos estén disponibles
            'rifas_total' => $this->rifaModel->count(),
            'ventas_mes' => 0, // Temporal
            'ingresos_mes' => 0 // Temporal
        ];

        $recentUsers = $this->usuarioModel->getRecent(10);
        $recentRifas = $this->rifaModel->getRecent(10);
        $topVendedores = $this->getTopVendedores();

        $this->view('dashboard/superadmin', [
            'title' => 'Dashboard Super Admin - Rifas Chile',
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentRifas' => $recentRifas,
            'topVendedores' => $topVendedores
        ]);
    }

    /**
     * Dashboard del Administrador
     */
    private function adminDashboard()
    {
        $stats = [
            'rifas_activas' => $this->rifaModel->countByStatus('activa'),
            'rifas_total' => $this->rifaModel->count(),
            'vendedores_activos' => $this->usuarioModel->countByType('vendedor'),
            'ventas_mes' => $this->getVentasMes()
        ];

        $recentRifas = $this->rifaModel->getRecent(10);
        $pendingApprovals = $this->rifaModel->getPendingApprovals();

        $this->view('dashboard/admin', [
            'title' => 'Dashboard Admin - Rifas Chile',
            'stats' => $stats,
            'recentRifas' => $recentRifas,
            'pendingApprovals' => $pendingApprovals
        ]);
    }

    /**
     * Dashboard del Vendedor
     */
    private function vendedorDashboard()
    {
        $user = $this->session->user();
        
        $stats = [
            'mis_rifas' => $this->rifaModel->countByVendedor($user['id']),
            'rifas_activas' => $this->rifaModel->countByVendedorAndStatus($user['id'], 'activa'),
            'tickets_vendidos' => $this->getTicketsVendidos($user['id']),
            'ingresos_mes' => $this->getIngresosMesVendedor($user['id'])
        ];

        $misRifas = $this->rifaModel->getByVendedor($user['id'], 10);
        $ventasRecientes = $this->getVentasRecientes($user['id']);

        $this->view('dashboard/vendedor', [
            'title' => 'Mi Dashboard - Rifas Chile',
            'stats' => $stats,
            'misRifas' => $misRifas,
            'ventasRecientes' => $ventasRecientes
        ]);
    }

    /**
     * Dashboard del Comprador
     */
    private function compradorDashboard()
    {
        $user = $this->session->user();
        
        $stats = [
            'mis_tickets' => $this->getMisTickets($user['id']),
            'rifas_participando' => $this->getRifasParticipando($user['id']),
            'premios_ganados' => $this->getPremiosGanados($user['id']),
            'gasto_total' => $this->getGastoTotal($user['id'])
        ];

        $misTickets = $this->getTicketsRecientes($user['id']);
        $rifasActivas = $this->rifaModel->getActivas(6);
        $proximosSorteos = $this->getProximosSorteos($user['id']);

        $this->view('dashboard/comprador', [
            'title' => 'Mi Dashboard - Rifas Chile',
            'stats' => $stats,
            'misTickets' => $misTickets,
            'rifasActivas' => $rifasActivas,
            'proximosSorteos' => $proximosSorteos
        ]);
    }

    /**
     * Mostrar perfil de usuario
     */
    public function profile()
    {
        $this->requireAuth();
        
        $user = $this->session->user();
        
        $this->view('dashboard/profile', [
            'title' => 'Mi Perfil - Rifas Chile',
            'user' => $user
        ]);
    }

    /**
     * Actualizar perfil de usuario
     */
    public function updateProfile()
    {
        $this->requireAuth();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $user = $this->session->user();
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'organizacion' => trim($_POST['organizacion'] ?? '')
            ];

            // Validaciones básicas
            if (empty($data['nombre'])) {
                throw new Exception('El nombre es requerido');
            }

            if (empty($data['apellido'])) {
                throw new Exception('El apellido es requerido');
            }

            // Actualizar usuario
            $this->usuarioModel->update($user['id'], $data);

            // Actualizar sesión
            $updatedUser = $this->usuarioModel->find($user['id']);
            $this->session->updateUser($updatedUser);

            // Log de acción
            $this->actionLogger->log(
                $user['id'],
                'profile',
                'update',
                'Usuario actualizó su perfil',
                ['fields' => array_keys($data)]
            );

            if ($this->isAjaxRequest()) {
                $this->json([
                    'success' => true,
                    'message' => 'Perfil actualizado exitosamente'
                ]);
            }

            $this->session->setFlash('success', 'Perfil actualizado exitosamente');
            $this->redirect('/perfil');

        } catch (Exception $e) {
            if ($this->isAjaxRequest()) {
                $this->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            $this->session->setFlash('error', $e->getMessage());
            $this->redirect('/perfil');
        }
    }

    // Helper methods for statistics

    private function getVentasMes()
    {
        // Implementar lógica para obtener ventas del mes actual
        return 0; // Placeholder
    }

    private function getIngresosMes()
    {
        // Implementar lógica para obtener ingresos del mes actual
        return 0; // Placeholder
    }

    private function getIngresosMesVendedor($vendedorId)
    {
        // Implementar lógica para obtener ingresos del vendedor en el mes actual
        return 0; // Placeholder
    }

    private function getTopVendedores()
    {
        // Implementar lógica para obtener top vendedores
        return []; // Placeholder
    }

    private function getTicketsVendidos($vendedorId)
    {
        // Implementar lógica para obtener tickets vendidos por el vendedor
        return 0; // Placeholder
    }

    private function getVentasRecientes($vendedorId)
    {
        // Implementar lógica para obtener ventas recientes del vendedor
        return []; // Placeholder
    }

    private function getMisTickets($compradorId)
    {
        // Implementar lógica para obtener tickets del comprador
        return 0; // Placeholder
    }

    private function getRifasParticipando($compradorId)
    {
        // Implementar lógica para obtener rifas en las que participa
        return 0; // Placeholder
    }

    private function getPremiosGanados($compradorId)
    {
        // Implementar lógica para obtener premios ganados
        return 0; // Placeholder
    }

    private function getGastoTotal($compradorId)
    {
        // Implementar lógica para obtener gasto total del comprador
        return 0; // Placeholder
    }

    private function getTicketsRecientes($compradorId)
    {
        // Implementar lógica para obtener tickets recientes del comprador
        return []; // Placeholder
    }

    private function getProximosSorteos($compradorId)
    {
        // Implementar lógica para obtener próximos sorteos donde participa
        return []; // Placeholder
    }    /**
     * Verificar si es una petición AJAX
     * Eliminado para usar la implementación de la clase base
     */
}
