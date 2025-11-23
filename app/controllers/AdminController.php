<?php

require_once __DIR__ . '/../models/User.php';

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($this->userModel->verifyPassword($username, $password)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                header('Location: /admin/dashboard');
                exit;
            } else {
                $error = 'Невірний логін або пароль';
            }
        }
        
        require __DIR__ . '/../views/admin/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /admin');
        exit;
    }

    public function dashboard() {
        $this->requireAuth();
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
            header('Location: /admin');
            exit;
        }
    }
}
