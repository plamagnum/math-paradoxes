<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати парадокс</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Додати парадокс</h1>
            <div class="admin-nav">
                <a href="/admin/dashboard">Панель управління</a>
                <a href="/admin/paradoxes">Список парадоксів</a>
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
            <form method="POST" action="/admin/paradoxes/create">
                <div class="form-group">
                    <label for="title">Назва парадоксу:</label>
                    <input type="text" id="title" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="description">Короткий опис:</label>
                    <textarea id="description" name="description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Детальний зміст:</label>
                    <textarea id="content" name="content" required style="min-height: 300px;"><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="order">Порядок відображення:</label>
                    <input type="number" id="order" name="order" value="<?php echo isset($_POST['order']) ? htmlspecialchars($_POST['order']) : '0'; ?>">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Створити</button>
                    <a href="/admin/paradoxes" class="btn">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
