<?php
session_start();
$savedFacts = isset($_SESSION['savedFacts']) ? $_SESSION['savedFacts'] : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link type="image/x-icon" href="/assets/images/favicon.ico" rel="shortcut icon">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h1>Добро пожаловать!</h1>

        <div class="advice-section">
            <button id="getAdviceBtn">Получить совет</button>
            <p id="advice"></p>
            <button id="saveAdviceBtn" style="display:none;">Сохранить совет</button>
        </div>

        <div class="saved-advice">
            <h3>Сохраненные советы:</h3>
            <ul id="savedAdviceList">
            </ul>
        </div>

        <div class="tabs">
            <button id="dogTab">Факты о собаках</button>
            <button id="catTab">Факты о кошках</button>
        </div>

        <div id="factSection">
            <p id="fact">Выберите вкладку для получения факта.</p>
            <button id="getFactBtn">Получить новый факт</button>
            <button id="saveFactBtn" style="display:none;">Сохранить факт</button>
        </div>

        <div class="saved-facts">
            <h3>Сохраненные факты:</h3>
            <ul id="savedFactsList">
                <?php foreach ($savedFacts as $fact): ?>
                    <li><?= htmlspecialchars($fact) ?> <button class="deleteFactBtn">Удалить</button></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="/assets/js/script.js"></script>
</body>
</html>