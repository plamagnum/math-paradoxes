<?php
require_once __DIR__ . '/../../models/Paradox.php';
require_once __DIR__ . '/../../models/User.php';

$paradoxModel = new Paradox();
$userModel = new User();

$paradoxCount = $paradoxModel->count();
$userCount = count($userModel->findAll());
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управління</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Панель управління</h1>
            <div class="admin-nav">
                <a href="/admin/paradoxes">Парадокси</a>
                <a href="/admin/users">Користувачі</a>
                <a href="/">Головна сторінка</a>
                <a href="/admin/logout">Вихід</a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2>Парадоксів</h2>
                <div class="count"><?php echo $paradoxCount; ?></div>
                <a href="/admin/paradoxes">Управління парадоксами</a>
            </div>
            
            <div class="dashboard-card">
                <h2>Користувачів</h2>
                <div class="count"><?php echo $userCount; ?></div>
                <a href="/admin/users">Управління користувачами</a>
            </div>
        </div>
    </div>
</body>
</html>
