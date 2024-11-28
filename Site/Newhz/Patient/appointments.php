<?php
require 'db.php';
session_start();
$message = '';

if (!isset($_SESSION['user_id'])) {
    die("Пожалуйста, войдите в систему.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    
    $stmt = $pdo->prepare("INSERT INTO appointments (user_id, doctor_id, date) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$user_id, $doctor_id, $date])) {
        $message = "Запись на прием успешна!";
    } else {
        $message = "Ошибка записи на прием.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись ко врачу</title>
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
        <h2>Запись ко врачу</h2>
        <body>
            <h1>Запись на прием</h1>
            <form method="POST">
                <input type="number" name="doctor_id" placeholder="ID врача" required>
                <input type="date" name="date" required>
                <button type="submit">Записаться на прием</button>
            </form>
            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </body>
    </main>
    <footer>
        <p>&copy; 2024 Стоматологическая Клиника</p>
    </footer>
</body>
</html>
