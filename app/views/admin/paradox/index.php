<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління парадоксами</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Управління парадоксами</h1>
            <div class="admin-nav">
                <a href="/admin/dashboard">Панель управління</a>
                <a href="/admin/paradoxes/create">Додати парадокс</a>
                <a href="/admin/users">Користувачі</a>
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
                        <th>Порядок</th>
                        <th>Назва</th>
                        <th>Опис</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paradoxes as $paradox): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paradox->order); ?></td>
                            <td><?php echo htmlspecialchars($paradox->title); ?></td>
                            <td><?php echo htmlspecialchars(substr($paradox->description, 0, 100)); ?>...</td>
                            <td class="actions">
                                <a href="/paradox/<?php echo htmlspecialchars($paradox->_id); ?>" class="btn btn-small" target="_blank">Переглянути</a>
                                <a href="/admin/paradoxes/edit/<?php echo htmlspecialchars($paradox->_id); ?>" class="btn btn-small">Редагувати</a>
                                <a href="/admin/paradoxes/delete/<?php echo htmlspecialchars($paradox->_id); ?>" class="btn btn-small btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
