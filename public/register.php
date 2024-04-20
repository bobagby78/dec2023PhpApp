<?php
include '../cfg.php';
session_set_cookie_params(0, '/', '', true, true); // Lifetime 0 means until the browser is closed
session_start();
// error_log($_SESSION['username'] . ' IS THE CURRENT USER');

//no users with mult accounts
// function userExists($emailAddress, $username, $conn)
// {
//     $existingUser = false;

//     $queryEmail = 'SELECT COUNT(*) FROM users WHERE email = $1;';
//     $queryUsername = 'SELECT COUNT(*) FROM users WHERE username = $1;';

//     $resultEmail = pg_query_params($conn, $queryEmail, array($emailAddress));
//     $resultUsername = pg_query_params($conn, $queryUsername, array($username));

//     if (pg_fetch_result($resultUsername, 0) > 0 || pg_fetch_result($resultEmail, 0) > 0) {
//         $existingUser = true;
//     }


//     die(pg_fetch_result($resultUsername ));
//     return $existingUser;
// }

$username = $_POST['username'];
$password = $_POST['password'];
$hashPass = password_hash($password, PASSWORD_BCRYPT);

$query = "SELECT * FROM users WHERE username =$1;";
$result = pg_query_params($connxn, $query, array($username)); //

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $hashPassword = password_hash($password, PASSWORD_BCRYPT);

    //  validate
    // if ($password === $confirm && !userExists($password, $username, $connxn)) {
    if ($password === $confirm) {

        $postQuery = "INSERT INTO users (username, email, hashpass, created) values ($1, $2, $3, current_timestamp)";
        $resultPost = pg_query_params($connxn, $postQuery, array($username, $email, $hashPassword));

        if ($resultPost) {
            //refactor session params to get from DB after registration to get user, email, and id

            $getQuery = "SELECT * FROM users WHERE username = $1;";
            $getResult = pg_query_params($connxn, $getQuery, array($username));

            if ($getResult) {
                $getRow = pg_fetch_assoc($getResult);
                $userid = $getRow['id'];
                $email = $getRow['email'];

                $_SESSION['username'] = $getRow['username'];
                $_SESSION['userid'] = $getRow['id'];
                $_SESSION['email'] = $getRow['email'];
                var_dump("USER USER USER" . $_SESSION['username']);
                echo "<script> alert('Registration successful! Welcome to the club')</script>";
                header("Location: /public/welcome.php");
            } else {
                echo ('There was an issue connecting to the database');
            }
        } else {
            echo "Something went wrong";
        }
    } else {
        if ($password !== $confirm) {
            echo ('Passwords do not match.');
        }
        if ($userExists($password, $username, $connxn)) {
            echo ('That username or email already exists');
        }
    }
}
