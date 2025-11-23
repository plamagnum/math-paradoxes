<?php

require_once __DIR__ . '/../models/Paradox.php';

class ParadoxController {
    private $paradoxModel;

    public function __construct() {
        $this->paradoxModel = new Paradox();
    }

    public function show($id) {
        if (!$id) {
            header('Location: /');
            exit;
        }

        try {
            $paradox = $this->paradoxModel->findById($id);
            if (!$paradox) {
                header('Location: /');
                exit;
            }
            require __DIR__ . '/../views/paradox/show.php';
        } catch (Exception $e) {
            header('Location: /');
            exit;
        }
    }
}
