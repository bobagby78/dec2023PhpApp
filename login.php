<?php
session_set_cookie_params(0, '/', '', true, true); // Lifetime 0 means until the browser is closed
session_start();

include('cfg.php'); 

$username = $_POST['username'];
$password = $_POST['password'];
$hashPass = password_hash($password, PASSWORD_BCRYPT);

$query = "SELECT * FROM users WHERE username =$1;";
$result = pg_query_params($connxn, $query, array($username)); //this gives the params to connect to the DB

if($result){
    
    $row = pg_fetch_assoc($result); //the pg_fetch_assoc() uses the params set aside earlier to connect, returning the $row value, which can be used to access values from the query above. 
    if (password_verify($password, $row['hashpass'])){
        $_SESSION["username"] = $row['username'];
        $_SESSION["userid"] = $row['id'];
        $activeUser = $_SESSION['username'];
        var_dump($_SESSION);
        error_log('***   session started for ' . $_SESSION['username']);
        header("location: welcome.php");
        exit();
    }else{
        session_destroy();
        echo ("
        <h3> Uh-oh</h3>
        <p?> Looks like there was a problem with the credentials you entered</p>
        <a href='/login.html'> Try again? </a>
        <br>
        <a href='/register.html'> Register </a>
        ");
    }

}else{
    echo "no result from DB";
}

?>

