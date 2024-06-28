<?php
    require "database.php";
    // set default timezone for Malaysia zone
    date_default_timezone_set("Asia/Kuching");

    // declare a variables for date and time
    $nowDate = date("d-m-Y");
    $nowDateDB = date("Y-m-d");
    $nowTime = date("H:i:s");

    // useful variables embed inside HTML code
    $logoInHTML = "<h3 id=\"logo\" >Sistem<br>Program<br>Intervensi</h3>";
    $backButton = "
    <button id=\"back-button\" onclick=\"window.location='main_page.php'\">
        <img src=\"style/image/arrow_left.png\" alt=\"Balik Ke Menu Utama\">
        <h2>Menu Utama</h2>
    </button>
    ";
    $backButtonA = "
    <button id=\"back-button\" onclick=\"window.location='main_page_admin.php'\">
        <img src=\"style/image/arrow_left.png\" alt=\"Balik Ke Menu Utama\">
        <h2>Menu Utama</h2>
    </button>
    ";
    $headClient = "
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"style/client.css\">
        <title>E-Kehadiran</title>
    </head>
    ";
    $headAdmin = "
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"style/admin.css\">
        <title>E-Admin</title>
    </head>
    ";