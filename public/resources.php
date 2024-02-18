<?php
include('../cfg.php');
session_start();
if (isset($_SESSION['username'])) {
    $activeUser = ucfirst($_SESSION['username']);
    $userid = $_SESSION['userid'];
} else {
    $activeUser = "Unknown user";
}

//get user favorite pokemon if it exists
$getFav = "select * from fav_pokemon where id = $1";
$id = intval($userid);

$fPResult = pg_query_params($connxn, $getFav, array($userid));
if (!$fPResult) {
    die("Error in query: ") . pg_last_error($connxn);
}

$row = pg_fetch_assoc($fPResult);
$favPokemon = $row['pokemon'];


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $query = "insert into fav_pokemon (id, pokemon) 
                values ($1, $2) 
                on conflict (id) do update
                set pokemon = $2";
    $result = pg_query_params($connxn, $query, array($userid, $_POST['fav-pokemon']));
}

$userFav = $_POST['fav-pokemon'];

$addFav = isset($userFav) ? htmlspecialchars($userFav) : '';
if (is_null($favPokemon)) {
    $favPokemon = 'undecided';
    $pokeFormTitle = 'Add a favorite Pokemon!';
    $button = 'Add it!';
} else {
    $pokeFormTitle = 'Do you have a new fav?';
    $button = 'Change it!';
}

error_log('favorite pokemon: ' . $favPokemon);

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
        <h1><?= $activeUser ?>'s Resources</h1>
        <p>Your favorite Pokemon is <?= $favPokemon ?></p>
        <label for="fav-pokemon-form"><?= $pokeFormTitle ?> </label>
        <form class="form-control" action="/public/resources.php" method='post'>
            <input class="input-form" name="fav-pokemon" id="fav-pokemon-form" type="text">
            <input class="input-button" type="submit" value="<?= $button ?>">
        </form>
        <a href="/public/">Home</a>
        <a href='/public/logout.php'>Sign out</a>
    </div>


    <script>

    </script>

</body>

</html>