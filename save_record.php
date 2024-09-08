<!-- to create attendance record -->
<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;

    if(isset($_POST['submit'])) {
        // this data is array
        $noicList = $_POST['noic'];
        $results = [];
        $errors = [];

        session_start();
        foreach($noicList as $noic) {
            $result = $func->saverecord($cDB, $_SESSION['nokp'], $noic);
            if($result) {
                $results[] = $result;
            }
            else {
                $errors[] = $noic;
            }
        }
        session_write_close();
    }
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
        <?php
        if (!empty($errors)) {
            echo "<div class=\"recordMessage\"><h1>Pendaftaran Gagal</h1>";
            echo "<p>🤕</p>";
            echo "<h3>Terdapat masalah yang berlaku untuk noic berikut:</h3>";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "<small>Penyelesaian Terdekat: Cuba log keluar dahulu dan log masuk semula.</small></div>";
        } elseif (!empty($results)) {
            echo "<div class=\"recordMessage\"><h1>Pendaftaran Berjaya!</h1>";
            echo "<p>🥳</p>";
            echo "<h3>Berikut adalah butiran pendaftaran:</h3>";
            echo "<ul>";
            foreach ($results as $result) {
                echo "<li>noic: {$result['noic']}, kodKehadiran: {$result['kodKehadiran']}, masa_direkod: {$result['masa_direkod']}</li>";
            }
            echo "</ul>";
            echo "<small><a href=\"main_page.php\">Menu Utama</a></small></div>";
        } else {
            echo "<div class=\"recordMessage\"><h1>Tiada pendaftaran yang dilakukan.</h1>";
            echo "<small><a href=\"main_page.php\">Menu Utama</a></small></div>";
        }
        ?>
    </body>
</html>
