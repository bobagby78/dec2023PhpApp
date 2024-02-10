<?php
include 'cfg.php';
// session_set_cookie_params(0, '/', '', true, true); // Lifetime 0 means until the browser is closed
session_start();
error_log($_SESSION['username'] . ' IS THE CURRENT USER');

include('cfg.php'); 

$username = $_POST['username'];
$password = $_POST['password'];
$hashPass = password_hash($password, PASSWORD_BCRYPT);

$query = "SELECT * FROM users WHERE username =$1;";
$result = pg_query_params($connxn, $query, array($username)); //this gives the params to connect to the DB

if($_SERVER['REQUEST_METHOD']== 'POST'){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

//  validate
    if($password === $confirm){
        $query = "INSERT INTO users (username, email, hashpass, created) values ($1, $2, $3, current_timestamp)";
        $result = pg_query_params($connxn, $query, array($username, $email, $hashPassword));
        // $result ? echo "Registration successful, welcome to the club"; : "Something went wrong";
        if($result){
            echo "Registration successful! Welcome to the club";
            header("Location: /resources.php");
        } else {
            echo "Something went wrong";
        }
    }else{
        echo('Passwords do not match.');
    }
}    
