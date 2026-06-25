<?php
/**
 * Nutze diese Funktion um einfach eine Ausgabe
 * mit htmlspecialchars() zu erstellen.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Nutze diese Funktion um auf einen POST-Wert
 * zuzugreifen.
 */
function post(string $key, $default = '')
{
    return $_POST[$key] ?? $default;
}

/**
 * Formatiert ein Datum einheitlich im Schweizer Format TT.MM.JJJJ.
 * Akzeptiert YYYY-MM-DD, Datetime-Strings etc. Leere Werte ergeben ''.
 */
function formatDate($value): string
{
    if ($value === null || $value === '' || $value === '0000-00-00') {
        return '';
    }
    try {
        return (new DateTime($value))->format('d.m.Y');
    } catch (Exception $e) {
        return (string) $value;
    }
}

/**
 * Stellt eine Verbindung zur Datenbank her und gibt die
 * Datenbankverbindung als PDO zurück.
 */
$dbInstance = null;

function db(): PDO
{
    global $dbInstance;

    if ($dbInstance) {
        return $dbInstance;
    }

    try {
        $dbInstance = new PDO('mysql:host=127.0.0.1;dbname=' . $db['name'], $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]);
    } catch (PDOException $e) {
        die('Keine Verbindung zur Datenbank möglich: ' . $e->getMessage());
    }
}