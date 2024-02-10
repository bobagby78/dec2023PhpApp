<?php
session_start();


// echo ('Hello, ' . $_SESSION['username']);
$activeUser = ucfirst($_SESSION['username']); //ucfirst = upper case first of passed string.
$userid = $_SESSION['userid'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="icon" href="assets/nerd.jpg">
    <title>Welcome</title>
</head>
<body>
    <div class="div-block">
        <h1>Welcome, <?=$activeUser?></h1>
        <h2> Your user id is <?=$userid?></h2>
        <p>what would you like to do today?</p>
        <p>Go to my <a href='resources.php?=<?=$userid?>'>resources</a></p>
        <p><a href='logout.php'>Sign out</a></p>

    </div>
    
</body>
</html>


