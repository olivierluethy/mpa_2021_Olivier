<?php

function connectDatabase() {
    // Verbindungsdaten kommen aus Umgebungsvariablen (Docker),
    // mit Fallback auf die lokale Standard-Konfiguration.
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $name = getenv('DB_NAME') ?: 'minipa';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS');
    if ($pass === false) {
        $pass = '';
    }

    try {
        return new PDO("mysql:host=$host;dbname=$name", $user, $pass);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}