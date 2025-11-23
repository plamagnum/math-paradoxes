<?php

require_once __DIR__ . '/../models/User.php';

class AdminUserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        $this->requireAuth();
    }

    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
            header('Location: /admin');
            exit;
        }
    }

    public function index() {
        $users = $this->userModel->findAll();
        require __DIR__ . '/../views/admin/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $this->sanitize($_POST['role'] ?? 'admin');
            
            $errors = [];
            if (empty($username)) $errors[] = 'Логін є обов\'язковим';
            if (empty($password)) $errors[] = 'Пароль є обов\'язковим';
            if (strlen($password) < 6) $errors[] = 'Пароль має містити мінімум 6 символів';
            
            if (empty($errors)) {
                $existingUser = $this->userModel->findByUsername($username);
                if ($existingUser) {
                    $errors[] = 'Користувач з таким логіном вже існує';
                } else {
                    if ($this->userModel->create($username, $password, $role)) {
                        $_SESSION['success'] = 'Користувача успішно створено';
                        header('Location: /admin/users');
                        exit;
                    } else {
                        $errors[] = 'Помилка при створенні користувача';
                    }
                }
            }
        }
        
        require __DIR__ . '/../views/admin/user/create.php';
    }

    public function edit($id) {
        if (!$id) {
            header('Location: /admin/users');
            exit;
        }

        try {
            $user = $this->userModel->findById($id);
            if (!$user) {
                header('Location: /admin/users');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $this->sanitize($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $role = $this->sanitize($_POST['role'] ?? 'admin');
                
                $errors = [];
                if (empty($username)) $errors[] = 'Логін є обов\'язковим';
                if (!empty($password) && strlen($password) < 6) {
                    $errors[] = 'Пароль має містити мінімум 6 символів';
                }
                
                if (empty($errors)) {
                    $passwordToUpdate = !empty($password) ? $password : null;
                    if ($this->userModel->update($id, $username, $passwordToUpdate, $role)) {
                        $_SESSION['success'] = 'Користувача успішно оновлено';
                        header('Location: /admin/users');
                        exit;
                    } else {
                        $errors[] = 'Помилка при оновленні користувача';
                    }
                }
            }
            
            require __DIR__ . '/../views/admin/user/edit.php';
        } catch (Exception $e) {
            header('Location: /admin/users');
            exit;
        }
    }

    public function delete($id) {
        if (!$id) {
            header('Location: /admin/users');
            exit;
        }

        try {
            if ($this->userModel->delete($id)) {
                $_SESSION['success'] = 'Користувача успішно видалено';
            } else {
                $_SESSION['error'] = 'Помилка при видаленні користувача';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Помилка при видаленні користувача';
        }
        
        header('Location: /admin/users');
        exit;
    }

    private function sanitize($value) {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }
}
