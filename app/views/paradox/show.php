<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($paradox->title); ?> - Математичні Парадокси</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Математичні Парадокси</h1>
        </div>
    </header>

    <div class="container">
        <a href="/" class="btn btn-back">← Назад до списку</a>
        
        <div class="paradox-detail">
            <h1><?php echo htmlspecialchars($paradox->title); ?></h1>
            <div class="description">
                <?php echo htmlspecialchars($paradox->description); ?>
            </div>
            <div class="content">
                <?php echo htmlspecialchars($paradox->content); ?>
            </div>
        </div>
    </div>
</body>
</html>
