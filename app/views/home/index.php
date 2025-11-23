<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Математичні Парадокси</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Математичні Парадокси</h1>
            <p>Дивовижні парадоксальні результати у математиці</p>
        </div>
    </header>

    <div class="container">
        <div class="paradox-grid">
            <?php foreach ($paradoxes as $paradox): ?>
                <a href="/paradox/<?php echo htmlspecialchars($paradox->_id); ?>" class="paradox-card">
                    <h2><?php echo htmlspecialchars($paradox->title); ?></h2>
                    <p><?php echo htmlspecialchars($paradox->description); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
