<?php

class Rifa extends Model {
    protected $table = 'rifas';
    protected $fillable = [
        'admin_id', 'nombre', 'slug', 'descripcion', 'tipo_inventario',
        'cantidad_numeros', 'valor_numero', 'fecha_inicio', 'fecha_fin',
        'fecha_sorteo', 'estado', 'imagen_rifa', 'configuracion_premios'
    ];

    public function createRifa($data) {
        // Generate slug
        $data['slug'] = $this->generateSlug($data['nombre']);
        
        // Set initial state
        $data['estado'] = 'borrador';
        
        // Encode premios configuration
        if (isset($data['premios'])) {
            $data['configuracion_premios'] = json_encode($data['premios']);
            unset($data['premios']);
        }

        // Initialize statistics
        $data['estadisticas'] = json_encode([
            'numeros_vendidos' => 0,
            'total_recaudado' => 0,
            'vendedores_activos' => 0
        ]);

        $rifa = $this->create($data);

        // Create numbers for the rifa
        $this->createNumbers($rifa['id'], $data['cantidad_numeros']);

        // Log action
        $logger = new ActionLogger();
        $logger->log('rifa_created', [
            'rifa_id' => $rifa['id'],
            'rifa_name' => $rifa['nombre']
        ]);

        return $rifa;
    }    /**
     * Cuenta las rifas creadas por un administrador
     * 
     * @param int $adminId ID del administrador
     * @return int Número de rifas
     */
    public function countRifasByAdmin($adminId) 
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE admin_id = :adminId";
        $params = [':adminId' => $adminId];
        $result = $this->db->query($query, $params);
        return $result[0]['total'] ?? 0;
    }
    
    /**
     * Obtiene las últimas rifas de un administrador
     * 
     * @param int $adminId ID del administrador
     * @param int $limit Límite de rifas a obtener
     * @return array Lista de rifas
     */
    public function getLatestRifasByAdmin($adminId, $limit = 5) 
    {
        $query = "SELECT * FROM {$this->table} WHERE admin_id = :adminId ORDER BY created_at DESC LIMIT :limit";
        $params = [':adminId' => $adminId, ':limit' => $limit];
        return $this->db->query($query, $params);
    }
    
    /**
     * Obtiene todas las rifas de un administrador
     * 
     * @param int $adminId ID del administrador
     * @return array Lista de rifas
     */
    public function getAllByAdmin($adminId) 
    {
        $query = "SELECT * FROM {$this->table} WHERE admin_id = :adminId ORDER BY created_at DESC";
        $params = [':adminId' => $adminId];
        return $this->db->query($query, $params);
    }
    
    /**
     * Verifica si un slug ya existe
     * 
     * @param string $slug Slug a verificar
     * @param int $excludeId ID a excluir de la búsqueda (para edición)
     * @return bool True si existe, false si no
     */
    public function slugExists($slug, $excludeId = null) 
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE slug = :slug";
        $params = [':slug' => $slug];
        
        if ($excludeId) {
            $query .= " AND id != :excludeId";
            $params[':excludeId'] = $excludeId;
        }
        
        $result = $this->db->query($query, $params);
        return $result[0]['count'] > 0;
    }
    
    /**
     * Actualiza el estado de una rifa
     * 
     * @param int $id ID de la rifa
     * @param string $estado Nuevo estado
     * @return bool Resultado de la operación
     */
    public function updateStatus($id, $estado) 
    {
        return $this->update($id, ['estado' => $estado]);
    }
    
    /**
     * Verifica si una rifa tiene números vendidos
     * 
     * @param int $id ID de la rifa
     * @return bool True si tiene números vendidos
     */
    public function hasAnySold($id) 
    {
        $query = "SELECT COUNT(*) as count FROM numeros_rifa 
                 WHERE id_rifa = :id AND estado = 'vendido'";
        $params = [':id' => $id];
        $result = $this->db->query($query, $params);
        return $result[0]['count'] > 0;
    }
    
    /**
     * Obtiene estadísticas de ventas por día para los últimos 30 días
     * 
     * @param int $adminId ID del administrador
     * @return array Datos de ventas por día
     */
    public function getSalesByDayForLast30Days($adminId) 
    {
        $query = "SELECT 
                    DATE(n.fecha_venta) as fecha,
                    COUNT(*) as numeros_vendidos,
                    SUM(r.valor_numero) as total_ventas
                  FROM numeros_rifa n
                  JOIN {$this->table} r ON n.id_rifa = r.id
                  WHERE r.admin_id = :adminId 
                    AND n.estado = 'vendido'
                    AND n.fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                  GROUP BY DATE(n.fecha_venta)
                  ORDER BY fecha";
        $params = [':adminId' => $adminId];
        return $this->db->query($query, $params);
    }
    
    /**
     * Obtiene estadísticas generales de una rifa
     * 
     * @param int $id ID de la rifa
     * @return array Estadísticas de la rifa
     */
    public function getStatistics($id) 
    {
        // Obtener datos básicos
        $rifa = $this->find($id);
        
        if (!$rifa) {
            return false;
        }
        
        // Obtener conteos
        $query = "SELECT 
                    COUNT(*) as total_numeros,
                    SUM(CASE WHEN estado = 'vendido' THEN 1 ELSE 0 END) as numeros_vendidos,
                    SUM(CASE WHEN estado = 'reservado' THEN 1 ELSE 0 END) as numeros_reservados,
                    SUM(CASE WHEN estado = 'disponible' THEN 1 ELSE 0 END) as numeros_disponibles
                  FROM numeros_rifa
                  WHERE id_rifa = :id";
        $params = [':id' => $id];
        $conteos = $this->db->query($query, $params);
        
        // Calcular ingreso total
        $ingresoTotal = $conteos[0]['numeros_vendidos'] * $rifa['valor_numero'];
        
        // Obtener top vendedores
        $queryVendedores = "SELECT 
                              u.id, u.nombre, COUNT(*) as numeros_vendidos
                            FROM numeros_rifa n
                            JOIN usuarios u ON n.id_vendedor = u.id
                            WHERE n.id_rifa = :id AND n.estado = 'vendido'
                            GROUP BY u.id
                            ORDER BY numeros_vendidos DESC
                            LIMIT 5";
        $topVendedores = $this->db->query($queryVendedores, $params);
        
        return [
            'total_numeros' => $conteos[0]['total_numeros'],
            'numeros_vendidos' => $conteos[0]['numeros_vendidos'],
            'numeros_reservados' => $conteos[0]['numeros_reservados'],
            'numeros_disponibles' => $conteos[0]['numeros_disponibles'],
            'porcentaje_vendido' => $conteos[0]['total_numeros'] > 0 
                ? round(($conteos[0]['numeros_vendidos'] / $conteos[0]['total_numeros']) * 100, 2)
                : 0,
            'ingreso_total' => $ingresoTotal,
            'top_vendedores' => $topVendedores
        ];
    }

    public function updateRifa($id, $data) {
        // Update slug if name changed
        if (isset($data['nombre'])) {
            $currentRifa = $this->find($id);
            if ($currentRifa['nombre'] !== $data['nombre']) {
                $data['slug'] = $this->generateSlug($data['nombre']);
            }
        }

        // Handle premios configuration
        if (isset($data['premios'])) {
            $data['configuracion_premios'] = json_encode($data['premios']);
            unset($data['premios']);
        }

        return $this->update($id, $data);
    }

    public function publish($id) {
        $rifa = $this->find($id);
        
        if (!$rifa) {
            throw new Exception('Rifa no encontrada');
        }

        if ($rifa['estado'] !== 'borrador') {
            throw new Exception('Solo se pueden publicar rifas en estado borrador');
        }

        // Validate rifa is complete
        $this->validateForPublication($rifa);

        $this->update($id, ['estado' => 'publicada']);

        // Log action
        $logger = new ActionLogger();
        $logger->log('rifa_published', [
            'rifa_id' => $id,
            'rifa_name' => $rifa['nombre']
        ]);

        return true;
    }

    public function suspend($id, $reason = null) {
        $this->update($id, ['estado' => 'suspendida']);

        // Log action
        $logger = new ActionLogger();
        $logger->log('rifa_suspended', [
            'rifa_id' => $id,
            'reason' => $reason
        ]);
    }

    public function complete($id) {
        $this->update($id, ['estado' => 'finalizada']);

        // Log action
        $logger = new ActionLogger();
        $logger->log('rifa_completed', [
            'rifa_id' => $id
        ]);
    }

    private function validateForPublication($rifa) {
        $errors = [];

        // Check required fields
        if (empty($rifa['descripcion'])) {
            $errors[] = 'La descripción es obligatoria';
        }

        if (empty($rifa['configuracion_premios'])) {
            $errors[] = 'Debe configurar al menos un premio';
        }

        // Check dates
        $fechaInicio = new DateTime($rifa['fecha_inicio']);
        $fechaFin = new DateTime($rifa['fecha_fin']);
        $fechaSorteo = new DateTime($rifa['fecha_sorteo']);
        $today = new DateTime();

        if ($fechaInicio <= $today) {
            $errors[] = 'La fecha de inicio debe ser futura';
        }

        if ($fechaFin <= $fechaInicio) {
            $errors[] = 'La fecha de fin debe ser posterior a la fecha de inicio';
        }

        if ($fechaSorteo <= $fechaFin) {
            $errors[] = 'La fecha de sorteo debe ser posterior a la fecha de fin';
        }

        // Check if has assigned vendors
        $vendedoresCount = $this->getAssignedVendedoresCount($rifa['id']);
        if ($vendedoresCount === 0) {
            $errors[] = 'Debe asignar al menos un vendedor';
        }

        if (!empty($errors)) {
            throw new Exception('Errores de validación: ' . implode(', ', $errors));
        }
    }

    private function createNumbers($rifaId, $cantidad) {
        $sql = "INSERT INTO numeros_rifa (rifa_id, numero, estado, created_at, updated_at) VALUES ";
        $values = [];
        $params = [];

        for ($i = 1; $i <= $cantidad; $i++) {
            $values[] = "(?, ?, 'disponible', NOW(), NOW())";
            $params[] = $rifaId;
            $params[] = $i;
        }

        $sql .= implode(', ', $values);
        $this->db->query($sql, $params);
    }

    public function getByAdmin($adminId) {
        return $this->where('admin_id', $adminId);
    }    public function getPublic() {
        $sql = "SELECT * FROM {$this->table} WHERE estado IN ('publicada', 'en_curso') AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, []);
        return $stmt->fetchAll();
    }

    public function getBySlugPublic($slug) {
        $sql = "SELECT * FROM rifas WHERE slug = ? AND estado IN ('publicada', 'en_curso') AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$slug]);
        return $stmt->fetch();
    }

    public function getNumbers($rifaId, $vendedorId = null) {
        $sql = "SELECT * FROM numeros_rifa WHERE rifa_id = ?";
        $params = [$rifaId];

        if ($vendedorId) {
            $sql .= " AND (vendedor_id = ? OR vendedor_id IS NULL)";
            $params[] = $vendedorId;
        }

        $sql .= " ORDER BY numero ASC";

        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function getAvailableNumbers($rifaId, $vendedorId = null) {
        $sql = "SELECT numero FROM numeros_rifa WHERE rifa_id = ? AND estado = 'disponible'";
        $params = [$rifaId];

        if ($vendedorId) {
            // For specific vendor, check their assigned range
            $assignment = $this->getVendorAssignment($rifaId, $vendedorId);
            if ($assignment) {
                $sql .= " AND numero BETWEEN ? AND ?";
                $params[] = $assignment['rango_inicio'];
                $params[] = $assignment['rango_fin'];
            }
        }

        $sql .= " ORDER BY numero ASC";

        $stmt = $this->db->query($sql, $params);
        return array_column($stmt->fetchAll(), 'numero');
    }

    public function assignVendedor($rifaId, $vendedorId, $assignment = null) {
        // Check if already assigned
        $existing = $this->getVendorAssignment($rifaId, $vendedorId);
        if ($existing) {
            throw new Exception('El vendedor ya está asignado a esta rifa');
        }

        $data = [
            'rifa_id' => $rifaId,
            'vendedor_id' => $vendedorId,
            'estado' => 'activo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($assignment) {
            $data = array_merge($data, $assignment);
        }

        $sql = "INSERT INTO rifa_vendedores (rifa_id, vendedor_id, rango_inicio, rango_fin, cantidad_asignada, estado, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $this->db->query($sql, [
            $data['rifa_id'],
            $data['vendedor_id'],
            $data['rango_inicio'] ?? null,
            $data['rango_fin'] ?? null,
            $data['cantidad_asignada'] ?? null,
            $data['estado'],
            $data['created_at'],
            $data['updated_at']
        ]);

        // Log action
        $logger = new ActionLogger();
        $logger->log('vendor_assigned', [
            'rifa_id' => $rifaId,
            'vendedor_id' => $vendedorId
        ]);
    }

    public function getVendorAssignment($rifaId, $vendedorId) {
        $sql = "SELECT * FROM rifa_vendedores WHERE rifa_id = ? AND vendedor_id = ? AND estado = 'activo'";
        $stmt = $this->db->query($sql, [$rifaId, $vendedorId]);
        return $stmt->fetch();
    }

    public function getAssignedVendedores($rifaId) {
        $sql = "SELECT rv.*, u.nombre, u.apellidos, u.email 
                FROM rifa_vendedores rv 
                JOIN usuarios u ON rv.vendedor_id = u.id 
                WHERE rv.rifa_id = ? AND rv.estado = 'activo'
                ORDER BY u.nombre, u.apellidos";

        $stmt = $this->db->query($sql, [$rifaId]);
        return $stmt->fetchAll();
    }

    public function getAssignedVendedoresCount($rifaId) {
        $sql = "SELECT COUNT(*) as count FROM rifa_vendedores WHERE rifa_id = ? AND estado = 'activo'";
        $stmt = $this->db->query($sql, [$rifaId]);
        $result = $stmt->fetch();
        return $result['count'];
    }

    public function getPremios($rifaId) {
        $sql = "SELECT * FROM premios WHERE rifa_id = ? ORDER BY posicion ASC";
        $stmt = $this->db->query($sql, [$rifaId]);
        return $stmt->fetchAll();
    }

    public function updatePremios($rifaId, $premios) {
        // Delete existing premios
        $sql = "DELETE FROM premios WHERE rifa_id = ?";
        $this->db->query($sql, [$rifaId]);

        // Insert new premios
        foreach ($premios as $index => $premio) {
            $sql = "INSERT INTO premios (rifa_id, posicion, nombre, descripcion, valor_estimado, imagen, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $this->db->query($sql, [
                $rifaId,
                $index + 1,
                $premio['nombre'],
                $premio['descripcion'] ?? null,
                $premio['valor_estimado'] ?? null,
                $premio['imagen'] ?? null
            ]);
        }
    }

    public function getStats($rifaId = null) {
        if ($rifaId) {
            // Stats for specific rifa
            $sql = "SELECT 
                        r.id,
                        r.nombre,
                        r.cantidad_numeros,
                        r.valor_numero,
                        COUNT(DISTINCT nr.id) as numeros_vendidos,
                        COUNT(DISTINCT v.id) as total_ventas,
                        COALESCE(SUM(v.total), 0) as total_recaudado,
                        COUNT(DISTINCT rv.vendedor_id) as vendedores_asignados                    FROM rifas r
                    LEFT JOIN numeros_rifa nr ON r.id = nr.rifa_id AND nr.estado = 'vendido'
                    LEFT JOIN ventas v ON r.id = v.rifa_id
                    LEFT JOIN rifa_vendedores rv ON r.id = rv.rifa_id AND rv.estado = 'activo'
                    WHERE r.id = ?
                    GROUP BY r.id";
            
            $stmt = $this->db->query($sql, [$rifaId]);
            return $stmt->fetch();
        } else {
            // General rifa stats
            $sql = "SELECT 
                        COUNT(*) as total_rifas,
                        SUM(CASE WHEN estado IN ('publicada', 'en_curso') THEN 1 ELSE 0 END) as rifas_activas,
                        SUM(CASE WHEN estado = 'finalizada' THEN 1 ELSE 0 END) as rifas_finalizadas,
                        COALESCE(SUM(cantidad_numeros), 0) as total_numeros,
                        COALESCE(AVG(valor_numero), 0) as precio_promedio
                    FROM rifas WHERE deleted_at IS NULL";

            $stmt = $this->db->query($sql);
            return $stmt->fetch();
        }
    }

    public function updateStatistics($rifaId) {
        $stats = $this->getStats($rifaId);
        
        $estadisticas = [
            'numeros_vendidos' => $stats['numeros_vendidos'],
            'total_recaudado' => $stats['total_recaudado'],
            'vendedores_activos' => $stats['vendedores_asignados'],
            'porcentaje_vendido' => ($stats['numeros_vendidos'] / $stats['cantidad_numeros']) * 100
        ];

        $this->update($rifaId, ['estadisticas' => json_encode($estadisticas)]);

        return $estadisticas;
    }

    public function countByStatus($estado)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE estado = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$estado]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getRecent($limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingApprovals()
    {
        $sql = "SELECT * FROM {$this->table} WHERE estado = 'pendiente' AND deleted_at IS NULL ORDER BY created_at ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByVendedor($vendedorId)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE admin_id = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$vendedorId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function countByVendedorAndStatus($vendedorId, $estado)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE admin_id = ? AND estado = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$vendedorId, $estado]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getByVendedor($vendedorId, $limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} WHERE admin_id = ? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->query($sql, [$vendedorId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    public function getActivas($limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} WHERE estado IN ('publicada', 'en_curso') AND deleted_at IS NULL ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->query($sql, [$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
