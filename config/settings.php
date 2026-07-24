<?php

require_once __DIR__ . "/database.php";

function getSetting($key)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT setting_value
        FROM settings
        WHERE setting_key = ?
    ");

    $stmt->execute([$key]);

    $value = $stmt->fetchColumn();

    return $value !== false ? $value : null;
}

function setSetting($key, $value)
{
    global $conn;

    $stmt = $conn->prepare("
        UPDATE settings
        SET setting_value = ?
        WHERE setting_key = ?
    ");

    return $stmt->execute([$value, $key]);
}