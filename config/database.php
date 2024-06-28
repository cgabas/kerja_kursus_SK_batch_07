<?php
    // database configuration
    $host = "localhost"; //or 127.0.0.1
    $user = "root";
    $pass = "";
    $DB = "programintervensi";

    //create a connection to database
    $cDB = new mysqli($host, $user, $pass, $DB);

    //check connection
    if(!$cDB) {
        die("Terdapat Kesalahan Berlaku, Sila Semak Kod Anda.");
    }