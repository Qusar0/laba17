<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $error = null;

    // Валидация данных
    if (empty($title)) {
        $error = "Заголовок не может быть пустым";
    } elseif (empty($content)) {
        $error = "Содержание статьи не может быть пустым";
    }

    if (!$error) {
        $result = pg_query_params(
            $conn,
            "INSERT INTO articles (title, content, created_at) VALUES ($1, $2, NOW())",
            [$title, $content]
        );

        if ($result) {
            header("Location: /pages/add_article.php?success=1");
            exit;
        } else {
            $error = "Ошибка при сохранении статьи: " . pg_last_error($conn);
        }
    }
}

$articles = pg_query($conn, "SELECT * FROM articles ORDER BY created_at DESC");
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
    <?php include '../includes/header.php'; ?>
    <main class="articles-page">
        <h1>Статьи</h1>
        
        <?php if (!empty($_GET['success'])): ?>
            <div class="alert success">Статья успешно добавлена!</div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <section class="article-form">
            <h2>Добавить новую статью</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Заголовок:</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Содержание:</label>
                    <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                </div>
                
                <button type="submit" class="btn">Опубликовать</button>
            </form>
        </section>
        
        <section class="articles-list">
            <h2>Последние статьи</h2>
            
            <?php if (pg_num_rows($articles) > 0): ?>
                <?php while ($article = pg_fetch_assoc($articles)): ?>
                    <article class="article">
                        <h3><?= htmlspecialchars($article['title']) ?></h3>
                        <time datetime="<?= $article['created_at'] ?>">
                            <?= date('d.m.Y H:i', strtotime($article['created_at'])) ?>
                        </time>
                        <div class="article-content">
                            <?= nl2br(htmlspecialchars($article['content'])) ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Пока нет статей. Будьте первым, кто добавит статью!</p>
            <?php endif; ?>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>