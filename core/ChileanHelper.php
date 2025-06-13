<?php

class ChileanHelper {
    
    public static function formatCurrency($amount) {
        return '$' . number_format($amount, 0, ',', '.') . ' CLP';
    }

    public static function formatDate($date, $format = 'd/m/Y') {
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        return $date->format($format);
    }

    public static function formatDateTime($datetime, $format = 'd/m/Y H:i') {
        if (is_string($datetime)) {
            $datetime = new DateTime($datetime);
        }
        return $datetime->format($format);
    }

    public static function validateRUT($rut) {
        $rut = preg_replace('/[^0-9kK]/', '', strtoupper($rut));
        
        if (strlen($rut) < 8 || strlen($rut) > 9) {
            return false;
        }

        $dv = substr($rut, -1);
        $numero = substr($rut, 0, -1);

        $suma = 0;
        $multiplicador = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $numero[$i] * $multiplicador;
            $multiplicador = $multiplicador == 7 ? 2 : $multiplicador + 1;
        }

        $resto = $suma % 11;
        $dvCalculado = 11 - $resto;

        if ($dvCalculado == 11) {
            $dvCalculado = '0';
        } elseif ($dvCalculado == 10) {
            $dvCalculado = 'K';
        }

        return $dv == $dvCalculado;
    }

    public static function formatRUT($rut) {
        $rut = preg_replace('/[^0-9kK]/', '', strtoupper($rut));
        
        if (strlen($rut) < 8) {
            return $rut;
        }

        $dv = substr($rut, -1);
        $numero = substr($rut, 0, -1);
        
        return number_format($numero, 0, '', '.') . '-' . $dv;
    }

    public static function getChileanMonths() {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
    }

    public static function getChileanDays() {
        return [
            'Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'
        ];
    }

    public static function timeAgo($datetime) {
        $time = time() - strtotime($datetime);

        if ($time < 60) {
            return 'hace unos segundos';
        } elseif ($time < 3600) {
            $minutes = floor($time / 60);
            return "hace {$minutes} minuto" . ($minutes > 1 ? 's' : '');
        } elseif ($time < 86400) {
            $hours = floor($time / 3600);
            return "hace {$hours} hora" . ($hours > 1 ? 's' : '');
        } elseif ($time < 2592000) {
            $days = floor($time / 86400);
            return "hace {$days} día" . ($days > 1 ? 's' : '');
        } elseif ($time < 31536000) {
            $months = floor($time / 2592000);
            return "hace {$months} mes" . ($months > 1 ? 'es' : '');
        } else {
            $years = floor($time / 31536000);
            return "hace {$years} año" . ($years > 1 ? 's' : '');
        }
    }

    public static function generateSlug($text) {
        // Convert to lowercase
        $text = strtolower($text);
        
        // Replace Spanish characters
        $replacements = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
            'ñ' => 'n', 'ç' => 'c'
        ];
        
        $text = strtr($text, $replacements);
        
        // Remove special characters and replace spaces with hyphens
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhoneNumber($phone) {
        // Chilean phone number validation (mobile and landline)
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Mobile: +56 9 XXXX XXXX or 9 XXXX XXXX
        // Landline: +56 X XXXX XXXX or X XXXX XXXX (where X is not 9)
        
        if (preg_match('/^\+?56?[2-9]\d{7,8}$/', $phone) || preg_match('/^\+?56?9\d{8}$/', $phone)) {
            return true;
        }
        
        return false;
    }
}
