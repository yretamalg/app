<?php

class ActionLogger {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }      public function log($userId = null, $module = 'system', $action = 'general', $description = '', $details = []) {
        try {
            // Si no se proporciona userId, intentar obtenerlo de la sesión
            if ($userId === null) {
                $session = new Session();
                $userId = $session->getUserId();
                $userType = $session->userType();
            } else {
                $userType = 'system'; // Valor por defecto
            }
            
            $ip = $this->getClientIP();
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
              // Check if action_logs table exists and its structure
            try {
                $describeTable = $this->db->query("DESCRIBE action_logs", []);
                // Extract column names
                $columns = [];
                foreach ($describeTable as $col) {
                    $columns[] = $col['Field'];
                }
                
                // Log the table structure for debugging
                error_log('[LOGGER] Action_logs columns: ' . implode(', ', $columns));
                
                // Based on the actual table structure, build the query
                if (in_array('module', $columns)) {
                    $sql = "INSERT INTO action_logs (user_id, user_type, module, action, description, details, ip_address, user_agent, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                    
                    $this->db->query($sql, [
                        $userId,
                        $userType,
                        $module,
                        $action,
                        $description,
                        json_encode($details),
                        $ip,
                        $userAgent
                    ]);
                } else {
                    // Assume a simplified structure without the 'module' column
                    $sql = "INSERT INTO action_logs (user_id, user_type, action, description, details, ip_address, user_agent, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
                    
                    $this->db->query($sql, [
                        $userId,
                        $userType,
                        $action,
                        $description,
                        json_encode($details),
                        $ip,
                        $userAgent
                    ]);
                }
            } catch (Exception $e) {
                error_log('[LOGGER] Error checking action_logs structure: ' . $e->getMessage());
            }
            
            // También escribir en archivo de log si está habilitado el debug
            if ($_ENV['APP_DEBUG'] === 'true') {
                $this->writeToFile($action, $details, $userId, $userType, $ip);
            }
            
        } catch (Exception $e) {
            error_log("Error logging action: " . $e->getMessage());
        }
    }
    
    public function getRecentActions($limit = 50, $userId = null, $userType = null) {
        $sql = "SELECT al.*, u.nombre, u.apellidos, u.email 
                FROM action_logs al 
                LEFT JOIN usuarios u ON al.user_id = u.id 
                WHERE 1=1";
        
        $params = [];
        
        if ($userId) {
            $sql .= " AND al.user_id = ?";
            $params[] = $userId;
        }
        
        if ($userType) {
            $sql .= " AND al.user_type = ?";
            $params[] = $userType;
        }
        
        $sql .= " ORDER BY al.created_at DESC LIMIT ?";
        $params[] = $limit;
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getNotifications($userId, $userType, $limit = 20) {
        $notifications = [];
        
        switch ($userType) {
            case 'superadmin':
                $notifications = $this->getSuperAdminNotifications($limit);
                break;
            case 'admin':
                $notifications = $this->getAdminNotifications($userId, $limit);
                break;
            case 'vendedor':
                $notifications = $this->getVendorNotifications($userId, $limit);
                break;
        }
        
        return $notifications;
    }
    
    private function getSuperAdminNotifications($limit) {
        // Notificaciones para superadmin: nuevos registros, problemas del sistema, etc.
        $sql = "SELECT al.*, u.nombre, u.apellidos 
                FROM action_logs al 
                LEFT JOIN usuarios u ON al.user_id = u.id 
                WHERE al.action IN ('user_registered', 'rifa_completed', 'system_error', 'login_failed') 
                ORDER BY al.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    private function getAdminNotifications($adminId, $limit) {
        // Notificaciones para admin: ventas en sus rifas, rifas próximas a sorteo, etc.
        $sql = "SELECT DISTINCT al.*, u.nombre, u.apellidos, r.nombre as rifa_nombre
                FROM action_logs al 
                LEFT JOIN usuarios u ON al.user_id = u.id 
                LEFT JOIN rifas r ON JSON_EXTRACT(al.details, '$.rifa_id') = r.id
                WHERE (r.admin_id = ? OR al.user_id = ?)
                AND al.action IN ('sale_made', 'rifa_near_draw', 'rifa_completed', 'vendor_assigned')
                ORDER BY al.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->query($sql, [$adminId, $adminId, $limit]);
        return $stmt->fetchAll();
    }
    
    private function getVendorNotifications($vendorId, $limit) {
        // Notificaciones para vendedor: asignaciones a rifas, pagos pendientes, etc.
        $sql = "SELECT al.*, r.nombre as rifa_nombre
                FROM action_logs al 
                LEFT JOIN rifas r ON JSON_EXTRACT(al.details, '$.rifa_id') = r.id
                WHERE al.user_id = ?
                AND al.action IN ('assigned_to_rifa', 'payment_pending_expired', 'rifa_near_draw')
                ORDER BY al.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->query($sql, [$vendorId, $limit]);
        return $stmt->fetchAll();
    }
    
    public function markNotificationAsRead($notificationId, $userId) {
        $sql = "UPDATE action_logs SET read_at = NOW() WHERE id = ? AND user_id = ?";
        $this->db->query($sql, [$notificationId, $userId]);
    }
    
    public function getUnreadCount($userId, $userType) {
        $notifications = $this->getNotifications($userId, $userType, 1000);
        return count(array_filter($notifications, function($notification) {
            return !$notification['read_at'];
        }));
    }
    
    private function getClientIP() {
        $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) && !empty($_SERVER[$key])) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
    
    private function writeToFile($action, $details, $userId, $userType, $ip) {
        $logFile = __DIR__ . '/../storage/logs/actions.log';
        $timestamp = date('Y-m-d H:i:s');
        
        $logEntry = "[{$timestamp}] User: {$userId} ({$userType}) | Action: {$action} | IP: {$ip} | Details: " . json_encode($details) . PHP_EOL;
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
