<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід - Адміністративна панель</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="login-form">
        <h1>Адміністративна панель</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/admin/login">
            <div class="form-group">
                <label for="username">Логін:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%;">Увійти</button>
        </form>
    </div>
</body>
</html>
