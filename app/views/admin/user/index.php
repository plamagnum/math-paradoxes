<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління користувачами</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Управління користувачами</h1>
            <div class="admin-nav">
                <a href="/admin/dashboard">Панель управління</a>
                <a href="/admin/paradoxes">Парадокси</a>
                <a href="/admin/users/create">Додати користувача</a>
                <a href="/admin/logout">Вихід</a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Логін</th>
                        <th>Роль</th>
                        <th>Дата створення</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->username); ?></td>
                            <td><?php echo htmlspecialchars($user->role); ?></td>
                            <td><?php echo isset($user->created_at) ? date('Y-m-d H:i', $user->created_at->toDateTime()->getTimestamp()) : 'N/A'; ?></td>
                            <td class="actions">
                                <a href="/admin/users/edit/<?php echo htmlspecialchars($user->_id); ?>" class="btn btn-small">Редагувати</a>
                                <a href="/admin/users/delete/<?php echo htmlspecialchars($user->_id); ?>" class="btn btn-small btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
