<?php

require __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// $host = 'localhost'; //set the host
// $port = "5432";
// $dbname = 'dec2023phpapp'; //set the db name
// $user = 'postgres'; //db user
// $password = 'postgres'; //db password
// // $connxnStr = "host={$host} port={$port} dbname={$dbname} password={$password}";
// // $dbConn = pg_connect($connxnStr);

// $db = new PDO("pgsql:host=$host;port=$port; dbname=$dbname; user=$user; password=$password"); //PDO = PHP Data Objects, this is how php will gain access to the DB
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //

// if (!$dbConn){
//     // echo 'dbConn failed' . pg_last_error();
//     echo 'dbConn failed';
// }else{
//     echo 'here we go';
// }

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
}else{

    error_log("connxn sucsfl");
}

?>


