<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

$connxnString = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$connxn = pg_connect($connxnString);

if (!$connxn) {
    die("Connection failed: " . pg_last_error());
    error_log("$connxn failed");
} else {

    error_log("connxn sucsfl");
}
