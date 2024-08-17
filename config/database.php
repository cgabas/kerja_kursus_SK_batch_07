<?php
    // database configuration
    $config = parse_ini_file("mysql_config_server/server.ini", true);

    //create a connection to database
    $cDB = new mysqli(
        $config['database']['host'],
        $config['database']['username'],
        $config['database']['password'],
        $config['database']['database']
    );

    //check connection
    if(!$cDB) {
        die("Terdapat Kesalahan Berlaku, Sila Semak Kod Anda.");
    }