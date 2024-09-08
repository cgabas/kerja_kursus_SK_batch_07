<?php
require_once "config/config.php"; // Make sure this file sets up $DB
require_once "config/functions.php";

$func = new globalFunc;

if(isset($_POST['delete'])) {
    // Ensure kodProgram is an array
    $listCode = isset($_POST['kodProgram']) ? $_POST['kodProgram'] : [];

    // if form recived a checkbox input
    if(!empty($listCode)) {
        foreach($listCode as $x) {
            if(!$func->fromDB($cDB, $x, 'DELETE_PROGRAM')) {
                echo "<script>alert('Terdapat Berlaku Kesalahan, Sila Cuba Lagi.');window.location = 'program.php';</script>";
            }
        }
        echo "<script>alert('Program Berjaya Dihapuskan.'); window.location = 'program.php';</script>";
    }
    else {
        echo "<script>alert('Tiada program yang dipilih'); window.location = 'program.php';</script>";
    }
}
