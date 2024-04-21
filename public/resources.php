<?php
// include('../node_modules/dist/jquery.js');
include('../cfg.php');
session_start();
if (isset($_SESSION['username'])) {
    $activeUser = ucfirst($_SESSION['username']);
    $userid = $_SESSION['userid'];
} else {
    $activeUser = "fav-pokemon-formUnknown user";
}

// $allPokemon = "SELECT name FROM all_pokemon";
// error_log(print_r($allPokemon));


//get user favorite pokemon if it exists
$getFav = "select * from fav_pokemon where id = $1"; //prepare a query to get user's fav pokemon
$id = intval($userid); //set var to user id
$favPokemonResult = pg_query_params($connxn, $getFav, array($userid)); //set result to fire query

if (!$favPokemonResult) {
    die("Error in query: ") . pg_last_error($connxn);
} else {
    $row = pg_fetch_assoc($favPokemonResult);
    $favPokemon = $row['pokemon'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") { //if user adds/changes a fav pokemon
    $userFav = strtolower($_POST['fav-pokemon']); //get fav pokemon from form when user triggers post
    $query = "insert into fav_pokemon (id, pokemon) values ($1, $2) on conflict (id) do update set pokemon = $2"; //prep query
    $result = pg_query_params($connxn, $query, array($userid, strtolower($_POST['fav-pokemon']))); //set result to fire query

    header("location:/public/resources.php");
}

$addFav = isset($userFav) ? htmlspecialchars($userFav) : ''; //ensure no user entered html makes it to page
if (is_null($favPokemon)) {  //set values for html form
    $favPokemon = 'undecided';
    $pokeFormTitle = 'Add a favorite Pokemon!';
    $button = 'Add it!';
} else {
    $pokeFormTitle = 'Do you have a new fav?';
    $button = 'Change it!';
}

// error_log('favorite pokemon: ' . $favPokemon);

//hit the free pokemon api and get stats for user's fav pokemon. 
$favPokemonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . strtolower($favPokemon));
$favPokemonDecode = json_decode($favPokemonObj);

//get all the pokemon from the pokeapi for autocomplete
$allPokemon = (file_get_contents('https://pokeapi.co/api/v2/pokemon/?limit=-1'));
// $allPokemon = json_decode($allPokemon);

$pokeResults = (json_decode($allPokemon)->results);
$pokeArray = [];
foreach ($pokeResults as $result) {
    array_push($pokeArray, $result->name);
}

error_log(in_array($favPokemon, $pokeArray) ? 'yes' : 'no');

$favPokemonName = $favPokemonDecode->name;
$favPokemonSpecies = $favPokemonDecode->species->name;
$favPokemonExp = $favPokemonDecode->base_experience;
// $favPokemonAbilities = ; //This one should be an array, handled accordingly
// $favPokemonType = ;

// die($favPokemonName);

// FUTURE ENRICHMENT: get page to reload if a user adds/changes fav pokemon. 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/styles.css">
    <link rel="icon" href="/public/assets/nerd.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Resources</title>
</head>

<!-- TODO: turn the text input into a select that matches what's in the array -->

<body>
    <div class="div-block">
        <h1><?= $activeUser ?>'s Resources</h1>
        <p>Your favorite Pokemon is <?= ucfirst($favPokemon) ?></p>
        <label for="fav-pokemon-form"><?= $pokeFormTitle ?> </label>
        <form class="form-control" action="/public/resources.php" method='post'>
            <input class="input-form" name="fav-pokemon" id="fav-pokemon-form" type="text" autofocus>
            <input class="input-button" type="submit" value="<?= $button ?>">
        </form>
        <a href="/public/">Home</a>
        <a href='/public/logout.php'>Sign out</a>
    </div>



    <h2>My Favorite Pokemon is <?= ucfirst($favPokemonName) ?></h2>
    <div class="fav-poke-stats">
        <div>
            <span>Species: </span>
            <span> <?= $favPokemonSpecies ?> </span>
        </div>
        <div>
            <span> Base Exp:</span>
            <span> <?= $favPokemonExp ?> </span>
        </div>

    </div>

    <script>
        //use jquery to autocomplete based on db table
        $('#fav-pokemon-form').on('keyup', function() {
            console.log('clickety clack')
        });
    </script>

</body>

</html>