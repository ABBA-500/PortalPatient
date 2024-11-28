<?php
require 'db.php';

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: appointments.php");
        exit();
    } else {
        $message = "Неверное имя пользователя или пароль.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация / Вход</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Стоматологическая Клиника</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="doctors.php">Наши врачи</a></li>
                <li><a href="register.php">Регистрация</a></li>
                <li><a href="login.php">Вход</a></li>
                <li><a href="appointments.php">Запись ко врачу</a></li>
                <li><a href="records.php">Проверка записей</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Вход</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Стоматологическая Клиника</p>
    </footer>
</body>
</html>
