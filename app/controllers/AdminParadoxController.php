<?php

require_once __DIR__ . '/../models/Paradox.php';

class AdminParadoxController {
    private $paradoxModel;

    public function __construct() {
        $this->paradoxModel = new Paradox();
        $this->requireAuth();
    }

    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
            header('Location: /admin');
            exit;
        }
    }

    public function index() {
        $paradoxes = $this->paradoxModel->findAll();
        require __DIR__ . '/../views/admin/paradox/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $this->sanitize($_POST['title'] ?? '');
            $description = $this->sanitize($_POST['description'] ?? '');
            $content = $this->sanitize($_POST['content'] ?? '');
            $order = (int)($_POST['order'] ?? 0);
            
            $errors = [];
            if (empty($title)) $errors[] = 'Назва є обов\'язковою';
            if (empty($description)) $errors[] = 'Опис є обов\'язковим';
            if (empty($content)) $errors[] = 'Зміст є обов\'язковим';
            
            if (empty($errors)) {
                if ($this->paradoxModel->create($title, $description, $content, $order)) {
                    $_SESSION['success'] = 'Парадокс успішно створено';
                    header('Location: /admin/paradoxes');
                    exit;
                } else {
                    $errors[] = 'Помилка при створенні парадоксу';
                }
            }
        }
        
        require __DIR__ . '/../views/admin/paradox/create.php';
    }

    public function edit($id) {
        if (!$id) {
            header('Location: /admin/paradoxes');
            exit;
        }

        try {
            $paradox = $this->paradoxModel->findById($id);
            if (!$paradox) {
                header('Location: /admin/paradoxes');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $this->sanitize($_POST['title'] ?? '');
                $description = $this->sanitize($_POST['description'] ?? '');
                $content = $this->sanitize($_POST['content'] ?? '');
                $order = (int)($_POST['order'] ?? 0);
                
                $errors = [];
                if (empty($title)) $errors[] = 'Назва є обов\'язковою';
                if (empty($description)) $errors[] = 'Опис є обов\'язковим';
                if (empty($content)) $errors[] = 'Зміст є обов\'язковим';
                
                if (empty($errors)) {
                    if ($this->paradoxModel->update($id, $title, $description, $content, $order)) {
                        $_SESSION['success'] = 'Парадокс успішно оновлено';
                        header('Location: /admin/paradoxes');
                        exit;
                    } else {
                        $errors[] = 'Помилка при оновленні парадоксу';
                    }
                }
            }
            
            require __DIR__ . '/../views/admin/paradox/edit.php';
        } catch (Exception $e) {
            header('Location: /admin/paradoxes');
            exit;
        }
    }

    public function delete($id) {
        if (!$id) {
            header('Location: /admin/paradoxes');
            exit;
        }

        try {
            if ($this->paradoxModel->delete($id)) {
                $_SESSION['success'] = 'Парадокс успішно видалено';
            } else {
                $_SESSION['error'] = 'Помилка при видаленні парадоксу';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Помилка при видаленні парадоксу';
        }
        
        header('Location: /admin/paradoxes');
        exit;
    }

    private function sanitize($value) {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }
}
