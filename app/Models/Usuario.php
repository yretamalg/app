<?php

class Usuario extends Model {
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre', 'apellidos', 'email', 'password', 'rut', 'telefono', 
        'tipo', 'organizacion', 'is_particular', 'estado', 'datos_completos'
    ];
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];    public function authenticate($email, $password) {
        $user = $this->whereFirst('email', $email);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['estado'] != 'activo') {
                throw new Exception('Tu cuenta está inactiva. Contacta al administrador.');
            }
            
            // Update last access
            $this->update($user['id'], ['ultimo_acceso' => date('Y-m-d H:i:s')]);
            
            return $user;
        }
        
        return false;
    }

    public function createUser($data) {
        // Validate RUT uniqueness
        if (isset($data['rut']) && $this->whereFirst('rut', $data['rut'])) {
            throw new Exception('El RUT ya está registrado en el sistema');
        }

        // Validate email uniqueness
        if ($this->whereFirst('email', $data['email'])) {
            throw new Exception('El email ya está registrado en el sistema');
        }

        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Set defaults
        $data['estado'] = $data['estado'] ?? 'activo';
        $data['is_particular'] = $data['is_particular'] ?? true;
        $data['datos_completos'] = $this->hasCompleteData($data);

        return $this->create($data);
    }

    public function updateUser($id, $data) {
        // Remove password from update if empty
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        } elseif (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Check if data is complete
        $currentUser = $this->find($id);
        $mergedData = array_merge($currentUser, $data);
        $data['datos_completos'] = $this->hasCompleteData($mergedData);

        return $this->update($id, $data);
    }

    public function getByType($type) {
        return $this->where('tipo', $type);
    }

    public function getAdmins() {
        return $this->getByType('admin');
    }

    public function getVendedores() {
        return $this->getByType('vendedor');
    }

    public function getSuperAdmins() {
        return $this->getByType('superadmin');
    }

    public function hasCompleteData($data) {
        $requiredFields = ['nombre', 'apellidos', 'email', 'rut', 'telefono'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        
        return true;
    }

    public function generatePasswordResetToken($email) {
        $user = $this->whereFirst('email', $email);
        
        if (!$user) {
            throw new Exception('No se encontró un usuario con ese email');
        }

        $token = bin2hex(random_bytes(32));
        
        // Store token in password_resets table
        $sql = "INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())";
        $this->db->query($sql, [$email, $token]);

        return $token;
    }

    public function resetPassword($token, $newPassword) {
        // Find valid token (not older than 1 hour)
        $sql = "SELECT * FROM password_resets WHERE token = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        $stmt = $this->db->query($sql, [$token]);
        $resetData = $stmt->fetch();

        if (!$resetData) {
            throw new Exception('Token de recuperación inválido o expirado');
        }

        // Update user password
        $user = $this->whereFirst('email', $resetData['email']);
        if (!$user) {
            throw new Exception('Usuario no encontrado');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->update($user['id'], ['password' => $hashedPassword]);

        // Delete used token
        $sql = "DELETE FROM password_resets WHERE token = ?";
        $this->db->query($sql, [$token]);

        return true;
    }

    public function changePassword($userId, $currentPassword, $newPassword) {
        $user = $this->find($userId);
        
        if (!$user) {
            throw new Exception('Usuario no encontrado');
        }

        if (!password_verify($currentPassword, $user['password'])) {
            throw new Exception('La contraseña actual es incorrecta');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->update($userId, ['password' => $hashedPassword]);

        return true;
    }

    public function suspendUser($userId, $reason = null) {
        $this->update($userId, ['estado' => 'suspendido']);
        
        // Log action
        $logger = new ActionLogger();
        $logger->log('user_suspended', [
            'suspended_user_id' => $userId,
            'reason' => $reason
        ]);
    }

    public function activateUser($userId) {
        $this->update($userId, ['estado' => 'activo']);
        
        // Log action
        $logger = new ActionLogger();
        $logger->log('user_activated', [
            'activated_user_id' => $userId
        ]);
    }

    public function getUserStats($userId = null) {
        if ($userId) {
            // Stats for specific user
            $sql = "SELECT 
                        u.id,
                        u.nombre,
                        u.apellidos,
                        u.tipo,
                        COUNT(DISTINCT r.id) as rifas_creadas,
                        COUNT(DISTINCT v.id) as ventas_realizadas,
                        COALESCE(SUM(v.total), 0) as total_vendido
                    FROM usuarios u
                    LEFT JOIN rifas r ON u.id = r.admin_id AND r.deleted_at IS NULL
                    LEFT JOIN ventas v ON u.id = v.vendedor_id
                    WHERE u.id = ?
                    GROUP BY u.id";
            
            $stmt = $this->db->query($sql, [$userId]);
            return $stmt->fetch();
        } else {
            // General user stats
            $sql = "SELECT 
                        COUNT(*) as total_usuarios,
                        SUM(CASE WHEN tipo = 'admin' THEN 1 ELSE 0 END) as total_admins,
                        SUM(CASE WHEN tipo = 'vendedor' THEN 1 ELSE 0 END) as total_vendedores,
                        SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as usuarios_activos,
                        SUM(CASE WHEN ultimo_acceso > DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as usuarios_activos_mes
                    FROM usuarios 
                    WHERE deleted_at IS NULL";
            
            $stmt = $this->db->query($sql);
            return $stmt->fetch();
        }
    }

    public function searchUsers($query, $type = null) {
        $sql = "SELECT * FROM usuarios WHERE deleted_at IS NULL AND (
                    nombre LIKE ? OR 
                    apellidos LIKE ? OR 
                    email LIKE ? OR 
                    rut LIKE ?
                )";
        
        $params = ["%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%"];
        
        if ($type) {
            $sql .= " AND tipo = ?";
            $params[] = $type;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }    public function existsByEmail($email)
    {
        // Llamada explícita con tres parámetros para evitar confusión en el método where
        return $this->whereFirst('email', '=', $email) !== null;
    }

    public function existsByRut($rut)
    {
        // Llamada explícita con tres parámetros para evitar confusión en el método where
        return $this->whereFirst('rut', '=', $rut) !== null;
    }

    public function findByEmail($email)
    {
        return $this->whereFirst('email', $email);
    }

    public function createPasswordResetToken($userId, $token, $expires)
    {
        $sql = "
            INSERT INTO password_resets (user_id, token, expires_at, created_at) 
            VALUES (?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            token = VALUES(token), 
            expires_at = VALUES(expires_at), 
            created_at = NOW()
        ";
        
        return $this->db->query($sql, [$userId, $token, $expires]);
    }

    public function findByResetToken($token)
    {
        $sql = "
            SELECT u.*, pr.token, pr.expires_at 
            FROM {$this->table} u 
            INNER JOIN password_resets pr ON u.id = pr.user_id 
            WHERE pr.token = ? AND pr.expires_at > NOW()
        ";
        
        $stmt = $this->db->query($sql, [$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password
        $this->update($userId, ['password' => $hashedPassword]);
        
        // Delete reset token
        $sql = "DELETE FROM password_resets WHERE user_id = ?";
        $this->db->query($sql, [$userId]);
        
        return true;
    }

    public function getRecent($limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByType($tipo)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE tipo = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$tipo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
