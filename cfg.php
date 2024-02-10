<?php
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

$host = 'localhost';
$port = '5432';
$dbname = 'phpPlayground';
$user = 'postgres';
$password = 'postgres';

$connxnString = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$connxn = pg_connect($connxnString);

if (!$connxn) {
    die("Connection failed: " . pg_last_error());
    error_log("$connxn failed");
}else{

    error_log("connxn sucsfl");
}

?>


