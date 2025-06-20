<?php

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];
    protected $timestamps = true;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    public function findOrFail($id) {
        $result = $this->find($id);
        if (!$result) {
            throw new Exception("Registro no encontrado en {$this->table} con ID: {$id}");
        }
        return $result;
    }
    
    public function findBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ? AND deleted_at IS NULL";
        $stmt = $this->db->query($sql, [$slug]);
        return $stmt->fetch();
    }
    
    public function all() {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }    public function where($column, $operator, $value = null) {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }        
        try {
            // Handle IN operator with arrays
            if (strtoupper($operator) === 'IN' && is_array($value)) {
                $placeholders = str_repeat('?,', count($value) - 1) . '?';
                $sql = "SELECT * FROM {$this->table} WHERE {$column} IN ({$placeholders}) AND deleted_at IS NULL";
                $stmt = $this->db->query($sql, $value);
            } else {
                // CORRECCIÓN: Usar parámetros con nombre correctamente
                $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :whereValue AND deleted_at IS NULL";
                // Usar un valor nulo como cadena vacía para evitar errors
                if ($value === null) {
                    $value = '';
                }
                $stmt = $this->db->query($sql, ['whereValue' => $value]);
            }
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            // Reenviar la excepción para debugging
            error_log("Error en where para {$column} {$operator} {$value}: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function whereFirst($column, $operator, $value = null) {
        $results = $this->where($column, $operator, $value);
        return $results ? $results[0] : null;
    }
    
    public function create($data) {
        $data = $this->filterFillable($data);
        
        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->query($sql, $data);
        
        $id = $this->db->lastInsertId();
        return $this->find($id);
    }
    
    public function update($id, $data) {
        $data = $this->filterFillable($data);
        
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setParts);
        
        $data['id'] = $id;
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";
        $this->db->query($sql, $data);
        
        return $this->find($id);
    }
    
    public function delete($id) {
        // Soft delete
        $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function forceDelete($id) {
        // Hard delete
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function restore($id) {
        $sql = "UPDATE {$this->table} SET deleted_at = NULL WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id]);
    }
    
    public function withTrashed() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function onlyTrashed() {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function count($column = '*') {
        $sql = "SELECT COUNT({$column}) as total FROM {$this->table} WHERE deleted_at IS NULL";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function paginate($page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT {$perPage} OFFSET {$offset}";
        $stmt = $this->db->query($sql);
        $data = $stmt->fetchAll();
        
        $total = $this->count();
        $totalPages = ceil($total / $perPage);
        
        return [
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ];
    }
    
    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return array_diff_key($data, array_flip($this->guarded));
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
    
    public function generateSlug($text, $column = 'slug') {
        $baseSlug = ChileanHelper::generateSlug($text);
        $slug = $baseSlug;
        $counter = 1;
        
        while ($this->whereFirst($column, $slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}
