<?php
// config.php — Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Change to your MySQL username
define('DB_PASS', '');            // Change to your MySQL password
define('DB_NAME', 'epidermis_db');
define('SITE_NAME', 'Epidermis');
define('SITE_URL', 'http://localhost/epidermis');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Return empty data instead of crashing in demo mode
            return null;
        }
    }
    return $pdo;
}

// Helper: safely fetch all rows
function dbFetchAll(string $sql, array $params = []): array {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

// Helper: safely insert a row, return last insert id
function dbInsert(string $sql, array $params = []): int {
    $db = getDB();
    if (!$db) return 0;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return (int) $db->lastInsertId();
    } catch (PDOException $e) {
        return 0;
    }
}
