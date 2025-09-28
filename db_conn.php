<?php
    $dbhost = "localhost";
    $dbname = "flic_db";
    $dbuser = "uth";
    $dbpass = "uth1234@";

    try{
        $db = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Can't connect to the database";
    }

    $apiKey = "a42405df"; //OMDB API key

?>