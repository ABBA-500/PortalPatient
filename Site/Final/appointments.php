<?php
require 'db.php';
session_start();
$message = '';

if (!isset($_SESSION['user_id'])) {
    die("Пожалуйста, войдите в систему.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $doctor_FIO = $_POST['doctor_id'];
    $datem = $_POST['date_accessible'];
    $time = $_POST['time_accessible'];
    
    $stmt1 = $pdo->prepare("SELECT date_id FROM date_accessible WHERE (day_month = ? and (SELECT time_id FROM time_accessible WHERE time_of_day = ?))");
    $stmt1->execute([$datem, $time]);
    $date = $stmt1->fetchColumn();

    $stmt1 = $pdo->prepare("SELECT doctor_id FROM doctors WHERE FIO_doc = ?");
    $stmt1->execute([$doctor_FIO]);
    $doctor_id = $stmt1->fetchColumn();

    $stmt = $pdo->prepare("INSERT INTO patients (patient_id, doctor_id, date_id) VALUES (?, ?, ?)");

    if ($stmt->execute([$user_id, $doctor_id, $date])) {
        $stmt2 = $pdo->prepare("UPDATE date_accessible SET doctor_id = ?  WHERE (date_id = ?);");
        $stmt2-> execute([$doctor_id,$date]);
        $message = "Запись на прием успешна!";
    } else {
        $message = "Ошибка записи на прием.";
    }
}

// Получаем доступные даты
$stmt = $pdo->query("SELECT DISTINCT day_month FROM date_accessible WHERE doctor_id IS NULL");
$dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Получаем врачей с их ФИО и специальностями
$stmt = $pdo->query("SELECT FIO_doc, specialisation FROM doctors");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получаем доступные времена для первой даты (по умолчанию)
#$times = [];
#if (!empty($dates)) {
#    $stmt = $pdo->prepare("SELECT time_of_day FROM time_accessible WHERE time_id IN (SELECT time_id FROM date_accessible WHERE day_month = ?)");
#    $stmt->execute([$dates[0]]);
#    $times = $stmt->fetchAll(PDO::FETCH_COLUMN);
#}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись ко врачу</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateTimes() {
            const dateSelect = document.getElementById('date');
            const selectedDate = dateSelect.value;

            if (selectedDate) {
                fetch(`get_times.php?date=${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        const timeSelect = document.getElementById('time');
                        timeSelect.innerHTML = ''; // Очищаем предыдущие значения

                        if (data.length > 0) {
                            data.forEach(time => {
                                const option = document.createElement('option');
                                option.value = time;
                                option.textContent = time;
                                timeSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'Нет доступных времен';
                            timeSelect.appendChild(option);
                        }
                    })
                    .catch(error => console.error('Ошибка при получении времен:', error));
            }
        }
    </script>
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
        <h1>Запись на прием</h1>
        <form method="POST">
            <label for="doctor">Выберите врача:</label>
            <select name="doctor_id" id="doctor" required>
                <option value="">Выберите врача</option>
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?php echo htmlspecialchars($doctor['FIO_doc']); ?>">
                            <?php echo htmlspecialchars($doctor['FIO_doc'] . ' - ' . $doctor['specialisation']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Нет доступных врачей</option>
                <?php endif; ?>
            </select>
            <label for="dates">Выберите доступную дату:</label>
            <select name="date_accessible" id="date" required onchange="updateTimes()">
                <option value="">Выберите дату</option>
                <?php if (!empty($dates)): ?>
                    <?php foreach ($dates as $date): ?>
                        <option value="<?php echo htmlspecialchars($date); ?>"><?php echo htmlspecialchars($date); ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Нет доступных дат</option>
                <?php endif; ?>
            </select>
            <label for="times">Выберите доступное время:</label>
            <select name="time_accessible" id="time" required>
                <?php if (!empty($times)): ?>
                    <?php foreach ($times as $time): ?>
                        <option value="<?php echo htmlspecialchars($time); ?>"><?php echo htmlspecialchars($time); ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Нет доступных времен</option>
                <?php endif; ?>
            </select>
            <button type="submit">Записаться на прием</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Стоматологическая Клиника</p>
    </footer>
</body>
</html>