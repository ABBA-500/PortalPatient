<?php
require 'db.php';

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $stmt = $pdo->prepare("SELECT time_of_day FROM time_accessible WHERE time_id IN (SELECT time_id FROM date_accessible WHERE day_month = ? and doctor_id IS NULL)");
    $stmt->execute([$date]);
    $times = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($times);
}
?>
