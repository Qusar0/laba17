<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name)) $errors[] = 'Укажите имя';
    if (empty($message)) $errors[] = 'Напишите сообщение';

    if (empty($errors)) {
        $success = true;
    }
}
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
<main class="contact-page">
    <h1>Контакты</h1>
    
    <?php if ($success): ?>
        <div class="alert success">Сообщение отправлено!</div>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Ваше имя:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Сообщение:</label>
                <textarea name="message" required></textarea>
            </div>
            
            <button type="submit">Отправить</button>
        </form>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
</body>