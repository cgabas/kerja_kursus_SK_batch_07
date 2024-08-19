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
        <?php include_once "navigation.php"; ?>
        <div class="selectClass">
            <h1>Lihat Kehadiran Murid</h1>
            <hr>
            <div>
                <button onclick="callFunc.sendCookie('kelas', 'Arif', 'a')">Arif</button>
                <button onclick="callFunc.sendCookie('kelas', 'Bestari', 'a')">Bestari</button>
                <button onclick="callFunc.sendCookie('kelas', 'Cermelang', 'a')">Cermelang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Dedikasi', 'a')">Dedikasi</button>
                <button onclick="callFunc.sendCookie('kelas', 'Efisien', 'a')">Efisien</button>
                <button onclick="callFunc.sendCookie('kelas', 'Fikrah', 'a')">Fikrah</button>
                <button onclick="callFunc.sendCookie('kelas', 'Gemilang', 'a')">Gemilang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Harmoni', 'a')">Harmoni</button>
                <button onclick="callFunc.sendCookie('kelas', 'Iltizam', 'a')">Iltizam</button>
            </div>
        </div>
        <div class="seekAttendance">
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
</html>