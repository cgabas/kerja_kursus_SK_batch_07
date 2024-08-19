<?php
    // database configuration
    $config = parse_ini_file("mysql_config_server/server.ini", true);

    // create a connection to database
    $cDB = new mysqli(
        $config['database']['host'],
        $config['database']['username'],
        $config['database']['password'],
        $config['database']['database']
    );

    // check connection
    if(!$cDB) {
        die("<h1>Alamak! Terdapat Kesalahan Yang Berlaku, Sila Semak Kod Anda Encik Pembangun ;)</h1><br><h2>Mesej Ralat Untuk Pembangun: $cDB->error</h2>");
    }

    // check PHP version
    // Composer library requires PHP version 8.1.0 or above
    if(phpversion() < '8.1.0') {
        die("<h1>Anda perlu mengemas kini versi PHP anda kerana sistem ini menggunakan Library PHP yang memerlukan PHP versi 8.1.0 keatas!</h1>
        <br><h2>Versi PHP anda: ". phpversion() ."</h2>");
    }