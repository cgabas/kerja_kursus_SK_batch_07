<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <script type="module">
        import { callFunc } from "./library/progIntervensi-lib.js";
    </script>
    <body>
        <div class="selectClass">
            <h1>Pilih Kelas</h1>
            <div>
                <button onclick="callFunc.sendCookie('Arif')">Arif</button>
                <button onclick="callFunc.sendCookie('Bestari')">Bestari</button>
                <button onclick="callFunc.sendCookie('Cermelang')">Cermelang</button>
                <button onclick="callFunc.sendCookie('Dedikasi')">Dedikasi</button>
                <button onclick="callFunc.sendCookie('Efisien')">Efisien</button>
                <button onclick="callFunc.sendCookie('Fikrah')">Fikrah</button>
                <button onclick="callFunc.sendCookie('Gemilang')">Gemilang</button>
                <button onclick="callFunc.sendCookie('Harmoni')">Harmoni</button>
                <button onclick="callFunc.sendCookie('Iltizam')">Iltizam</button>
            </div>
        </div>
        <hr>
        <div class="seekAttendance">
            <h1>Pilihan Lain</h1>
            <button onclick="window.location='attendance.php'">Lihat Kehadiran Murid</button>
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
</html>