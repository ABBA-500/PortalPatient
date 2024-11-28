<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    if ($stmt->execute([$username, $password])) {
        $message = "Регистрация успешна!";
    } else {
        $message = "Ошибка регистрации.";
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
        <h2>Регистрация нового пользователя</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Зарегистрироваться</button>
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
