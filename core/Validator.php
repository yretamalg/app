<?php

class Validator {
    private $errors = [];
    
    public function validate($data, $rules) {
        $this->errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $this->validateField($field, $data[$field] ?? null, $fieldRules);
        }
        
        return empty($this->errors);
    }
    
    private function validateField($field, $value, $rules) {
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }
        
        foreach ($rules as $rule) {
            $this->applyRule($field, $value, $rule);
        }
    }
    
    private function applyRule($field, $value, $rule) {
        if (strpos($rule, ':') !== false) {
            list($ruleName, $parameter) = explode(':', $rule, 2);
        } else {
            $ruleName = $rule;
            $parameter = null;
        }
        
        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, 'El campo es obligatorio');
                }
                break;
                
            case 'email':
                if (!empty($value) && !ChileanHelper::validateEmail($value)) {
                    $this->addError($field, 'El formato del correo electrónico no es válido');
                }
                break;
                
            case 'min':
                if (!empty($value) && strlen($value) < $parameter) {
                    $this->addError($field, "Debe tener al menos {$parameter} caracteres");
                }
                break;
                
            case 'max':
                if (!empty($value) && strlen($value) > $parameter) {
                    $this->addError($field, "No puede tener más de {$parameter} caracteres");
                }
                break;
                
            case 'rut':
                if (!empty($value) && !ChileanHelper::validateRUT($value)) {
                    $this->addError($field, 'El RUT no es válido');
                }
                break;
                
            case 'phone':
                if (!empty($value) && !ChileanHelper::validatePhoneNumber($value)) {
                    $this->addError($field, 'El número de teléfono no es válido');
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, 'Debe ser un número válido');
                }
                break;
                
            case 'integer':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, 'Debe ser un número entero válido');
                }
                break;
                
            case 'date':
                if (!empty($value)) {
                    $date = DateTime::createFromFormat('Y-m-d', $value);
                    if (!$date || $date->format('Y-m-d') !== $value) {
                        $this->addError($field, 'Debe ser una fecha válida (YYYY-MM-DD)');
                    }
                }
                break;
                
            case 'after':
                if (!empty($value)) {
                    $inputDate = DateTime::createFromFormat('Y-m-d', $value);
                    $compareDate = DateTime::createFromFormat('Y-m-d', $parameter);
                    
                    if ($inputDate && $compareDate && $inputDate <= $compareDate) {
                        $this->addError($field, "La fecha debe ser posterior a {$parameter}");
                    }
                }
                break;
                
            case 'before':
                if (!empty($value)) {
                    $inputDate = DateTime::createFromFormat('Y-m-d', $value);
                    $compareDate = DateTime::createFromFormat('Y-m-d', $parameter);
                    
                    if ($inputDate && $compareDate && $inputDate >= $compareDate) {
                        $this->addError($field, "La fecha debe ser anterior a {$parameter}");
                    }
                }
                break;
                
            case 'in':
                if (!empty($value)) {
                    $allowedValues = explode(',', $parameter);
                    if (!in_array($value, $allowedValues)) {
                        $this->addError($field, 'El valor seleccionado no es válido');
                    }
                }
                break;
                
            case 'unique':
                if (!empty($value)) {
                    list($table, $column) = explode(',', $parameter);
                    if ($this->isUnique($table, $column, $value)) {
                        $this->addError($field, 'Este valor ya está en uso');
                    }
                }
                break;
                
            case 'confirmed':
                $confirmField = $field . '_confirmation';
                $confirmValue = $_POST[$confirmField] ?? null;
                
                if ($value !== $confirmValue) {
                    $this->addError($field, 'La confirmación no coincide');
                }
                break;
        }
    }
    
    private function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getFirstError($field) {
        return isset($this->errors[$field]) ? $this->errors[$field][0] : null;
    }
    
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    private function isUnique($table, $column, $value) {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ? AND deleted_at IS NULL", [$value]);
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }
}
