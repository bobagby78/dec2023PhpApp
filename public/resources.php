<?php
session_start();
if(isset($_SESSION['username'])){
    $activeUser = ucfirst($_SESSION['username']);
    $userid = $_SESSION['userid']; 
} else {
    $activeUser = "Unknown user";
}

/**
 * PICK UP HERE
 * TABLE HAS BEEN CREATED
 * add form to either add or update 
 * fav pokemon
*/
include ('../cfg.php');
$userFav = $_POST['fav-pokemon'];

$favPokemon;

/**get user's fav pokemon from fav pokemon table by userid
 * query the fav pokemon table with userid and set above var if exists
 * if fav pokemon, display its stats on page
 * form input, text on title reads "change fav pokemon?"
 * 
 * if no fav pokemon, form input, text on title reads "add fav pokemon"
*/  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/styles.css">
    <link rel="icon" href="/public/assets/nerd.jpg">
    <title>Resources</title>
</head>
<body>
    <div class="div-block">
        <h1><?=$activeUser?>'s Resources</h1>
        <p><?=$userid ?></p>
        <a href="/public/">Home</a>
        <a href='/public/logout.php'>Sign out</a>
    </div>
    
    <!-- <div class="div-block">
        <img src="http://192.168.1.199:8081" alt="fishcam">
    </div> -->

</body>
</html>