<?php

require_once __DIR__ . '/../../core/Model.php';

class Vendedor
{
    private $db;
    private $table = 'usuarios';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    /**
     * Obtiene todos los vendedores de un administrador
     * 
     * @param int $adminId ID del administrador
     * @return array Lista de vendedores
     */
    public function getAllByAdmin($adminId)
    {
        $query = "SELECT * FROM {$this->table} WHERE id_admin = :adminId AND tipo = 'vendedor' ORDER BY nombre ASC";
        $params = [':adminId' => $adminId];
        return $this->db->query($query, $params);
    }
    
    /**
     * Obtiene un vendedor por su ID
     * 
     * @param int $id ID del vendedor
     * @return array|bool Datos del vendedor o false si no existe
     */
    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id AND tipo = 'vendedor'";
        $params = [':id' => $id];
        $result = $this->db->query($query, $params);
        return $result ? $result[0] : false;
    }
    
    /**
     * Obtiene un vendedor por su slug
     * 
     * @param string $slug Slug del vendedor
     * @return array|bool Datos del vendedor o false si no existe
     */
    public function getBySlug($slug)
    {
        $query = "SELECT * FROM {$this->table} WHERE slug = :slug AND tipo = 'vendedor'";
        $params = [':slug' => $slug];
        $result = $this->db->query($query, $params);
        return $result ? $result[0] : false;
    }
    
    /**
     * Obtiene los vendedores asignados a una rifa
     * 
     * @param int $rifaId ID de la rifa
     * @return array Lista de vendedores
     */
    public function getVendedoresByRifa($rifaId)
    {
        $query = "SELECT u.* FROM {$this->table} u 
                  JOIN vendedor_rifa vr ON u.id = vr.id_vendedor 
                  WHERE vr.id_rifa = :rifaId AND u.tipo = 'vendedor'
                  ORDER BY u.nombre ASC";
        $params = [':rifaId' => $rifaId];
        return $this->db->query($query, $params);
    }
    
    /**
     * Cuenta el número de vendedores de un administrador
     * 
     * @param int $adminId ID del administrador
     * @return int Número de vendedores
     */
    public function countVendedoresByAdmin($adminId)
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE id_admin = :adminId AND tipo = 'vendedor'";
        $params = [':adminId' => $adminId];
        $result = $this->db->query($query, $params);
        return $result[0]['total'];
    }
      /**
     * Cuenta los vendedores activos de un administrador
     * 
     * @param int $adminId ID del administrador
     * @return int Número de vendedores activos
     */
    public function countActiveVendedoresByAdmin($adminId)
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table} 
                 WHERE id_admin = :adminId 
                 AND tipo = 'vendedor' 
                 AND estado = 'activo'";
                 
        $params = [':adminId' => $adminId];
        $result = $this->db->query($query, $params);
        return $result[0]['total'] ?? 0;
    }
    
    /**
     * Asigna un vendedor a una rifa
     * 
     * @param int $vendedorId ID del vendedor
     * @param int $rifaId ID de la rifa
     * @param string $comision Comisión por venta (porcentaje)
     * @return bool Resultado de la operación
     */
    public function asignarRifa($vendedorId, $rifaId, $comision)
    {
        // Verificar si ya está asignado
        $query = "SELECT * FROM vendedor_rifa WHERE id_vendedor = :vendedorId AND id_rifa = :rifaId";
        $params = [':vendedorId' => $vendedorId, ':rifaId' => $rifaId];
        $result = $this->db->query($query, $params);
        
        if ($result) {
            // Actualizar comisión
            $updateQuery = "UPDATE vendedor_rifa SET comision = :comision WHERE id_vendedor = :vendedorId AND id_rifa = :rifaId";
            $updateParams = [
                ':comision' => $comision,
                ':vendedorId' => $vendedorId,
                ':rifaId' => $rifaId
            ];
            $this->db->query($updateQuery, $updateParams);
            return true;
        } else {
            // Insertar nueva asignación
            $insertQuery = "INSERT INTO vendedor_rifa (id_vendedor, id_rifa, comision, fecha_asignacion) 
                           VALUES (:vendedorId, :rifaId, :comision, NOW())";
            $insertParams = [
                ':vendedorId' => $vendedorId,
                ':rifaId' => $rifaId,
                ':comision' => $comision
            ];
            $this->db->query($insertQuery, $insertParams);
            return true;
        }
    }
    
    /**
     * Desasigna un vendedor de una rifa
     * 
     * @param int $vendedorId ID del vendedor
     * @param int $rifaId ID de la rifa
     * @return bool Resultado de la operación
     */
    public function desasignarRifa($vendedorId, $rifaId)
    {
        $query = "DELETE FROM vendedor_rifa WHERE id_vendedor = :vendedorId AND id_rifa = :rifaId";
        $params = [':vendedorId' => $vendedorId, ':rifaId' => $rifaId];
        $this->db->query($query, $params);
        return true;
    }
}
