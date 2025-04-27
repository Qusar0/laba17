<?php
$date1 = $_GET['date1'] ?? '';
$date2 = $_GET['date2'] ?? '';

if ($date1 && $date2) {
    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);
    
    if ($timestamp1 !== false && $timestamp2 !== false) {
        $diff = abs($timestamp2 - $timestamp1);
        $days = floor($diff / (60 * 60 * 24));
        echo json_encode(['days_diff' => $days]);
    } else {
        echo json_encode(['error' => 'Invalid date format']);
    }
}
