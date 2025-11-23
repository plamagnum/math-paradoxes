<?php

require_once __DIR__ . '/../models/Paradox.php';

class HomeController {
    private $paradoxModel;

    public function __construct() {
        $this->paradoxModel = new Paradox();
    }

    public function index() {
        $paradoxes = $this->paradoxModel->findAll();
        require __DIR__ . '/../views/home/index.php';
    }
}
