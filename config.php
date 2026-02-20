<?php
// SQLite configuration: fully local database, no external DB server.
// The database file will be created in the data/ directory on first use.

$dbDir  = __DIR__ . DIRECTORY_SEPARATOR . 'data';
$dbFile = $dbDir . DIRECTORY_SEPARATOR . 'staff_biodata.sqlite';

if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
}

$dsn = 'sqlite:' . $dbFile;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, null, null, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Create the staff table on first run if it does not exist yet.
// Types are adapted for SQLite (TEXT/INTEGER) but the columns match the app logic.
$createSql = <<<SQL
CREATE TABLE IF NOT EXISTS staff (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    surname TEXT NOT NULL,
    first_name TEXT NOT NULL,
    other_name TEXT,
    date_of_birth TEXT NOT NULL,
    sex TEXT NOT NULL,
    marital_status TEXT NOT NULL,

    state_of_origin TEXT NOT NULL,
    lga_origin TEXT NOT NULL,
    state_of_origin_address TEXT NOT NULL,

    state_of_residence TEXT NOT NULL,
    lga_residence TEXT NOT NULL,
    residential_address TEXT NOT NULL,

    phone TEXT NOT NULL,
    email TEXT NOT NULL,

    psn_no TEXT NOT NULL,
    file_no TEXT NOT NULL,
    rank_position TEXT NOT NULL,
    date_of_first_appointment TEXT NOT NULL,
    gl_level TEXT NOT NULL,
    step_level TEXT NOT NULL,
    salary_structure TEXT NOT NULL,
    cadre TEXT NOT NULL,

    bank_name TEXT NOT NULL,
    account_number TEXT NOT NULL,
    bvn TEXT NOT NULL,
    nin TEXT NOT NULL,

    passport_path TEXT NOT NULL,
    fingerprint_path TEXT NOT NULL,

    created_at TEXT DEFAULT (datetime('now'))
);
SQL;

$pdo->exec($createSql);
