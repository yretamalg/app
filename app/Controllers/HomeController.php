<?php

class HomeController extends Controller {
    
    public function index() {
        $rifaModel = new Rifa();
        
        // Get public raffles
        $rifasPublicas = $rifaModel->getPublic();
        
        // Get general statistics
        $stats = $rifaModel->getStats();
        
        $this->render('home.index', [
            'title' => 'Rifas Chile - Sistema de Gestión de Rifas',
            'description' => 'Descubre las mejores rifas de Chile. Sistema confiable y seguro para participar en sorteos.',
            'keywords' => 'rifas chile, sorteos, premios, participar, números',
            'rifas' => $rifasPublicas,
            'stats' => $stats
        ], 'public');
    }
}
