<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати користувача</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Редагувати користувача</h1>
            <div class="admin-nav">
                <a href="/admin/dashboard">Панель управління</a>
                <a href="/admin/users">Список користувачів</a>
                <a href="/admin/logout">Вихід</a>
            </div>
        </div>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <form method="POST" action="/admin/users/edit/<?php echo htmlspecialchars($user->_id); ?>">
                <div class="form-group">
                    <label for="username">Логін:</label>
                    <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : htmlspecialchars($user->username); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Новий пароль (залиште порожнім, щоб не змінювати):</label>
                    <input type="password" id="password" name="password" minlength="6">
                </div>

                <div class="form-group">
                    <label for="role">Роль:</label>
                    <select id="role" name="role">
                        <option value="admin" <?php echo (isset($_POST['role']) ? $_POST['role'] : $user->role) === 'admin' ? 'selected' : ''; ?>>Адміністратор</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Оновити</button>
                    <a href="/admin/users" class="btn">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
