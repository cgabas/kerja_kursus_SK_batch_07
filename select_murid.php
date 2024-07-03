<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
        <div class="selectClass">
            <h1>Pilih Kelas</h1>
            <div>
                <button onclick="sendCookie('Arif')">Arif</button>
                <button onclick="sendCookie('Bestari')">Bestari</button>
                <button onclick="sendCookie('Cermelang')">Cermelang</button>
                <button onclick="sendCookie('Dedikasi')">Dedikasi</button>
                <button onclick="sendCookie('Efisien')">Efisien</button>
                <button onclick="sendCookie('Fikrah')">Fikrah</button>
                <button onclick="sendCookie('Gemilang')">Gemilang</button>
                <button onclick="sendCookie('Harmoni')">Harmoni</button>
                <button onclick="sendCookie('Iltizam')">Iltizam</button>
            </div>
        </div>
        <hr>
        <div class="seekAttendance">
            <h1>Pilihan Lain</h1>
            <button onclick="window.location='attendance.php'">Lihat Kehadiran Murid</button>
            <a href="main_page.php">Menu Utama</a>
        </div>
        <script>
            function sendCookie(name) {
                document.cookie = "kelas="+name+"; path=/";
                location.replace("murid.php");
            }
        </script>
    </body>
</html>