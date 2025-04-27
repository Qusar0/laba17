<?php
$date = $_GET['date'] ?? '';
if ($date) {
    $timestamp = strtotime($date);
    if ($timestamp !== false) {
        echo json_encode(['day_of_week' => date('l', $timestamp)]);
    } else {
        echo json_encode(['error' => 'Invalid date format']);
    }
}
