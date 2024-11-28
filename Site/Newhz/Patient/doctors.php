<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM doctors");
$doctors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стоматологическая Клиника</title>
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
    <h1>Наши врачи</h1>
    <ul>
        <?php foreach ($doctors as $doctor): ?>
            <li>ID: <?php echo $doctor['doctor_id']; ?> - <?php echo $doctor['specialisation']; ?>: <?php echo $doctor['FIO_doc']; ?></li>
        <?php endforeach; ?>
    </ul>
    <footer>
        <p>&copy; 2024 Стоматологическая Клиника</p>
    </footer>
</body>
</html>
