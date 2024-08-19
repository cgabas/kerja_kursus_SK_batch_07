<?php
    require_once "config/config.php";
    require_once "config/functions.php";
    $func = new globalFunc;
?>
<!DOCTYPE html>
<html lang="en">
    <?php echo $headClient; ?>
    <script type="module">
        import { callFunc } from './library/progIntervensi-lib.js';
    </script>
    <body>
        <?php include_once "navigation.php"; ?>
        <div class="selectClass">
            <h1>Rekod Kehadiran</h1>
            <hr>
            <div>
                <button onclick="callFunc.sendCookie('kelas', 'Arif', 'r')">Arif</button>
                <button onclick="callFunc.sendCookie('kelas', 'Bestari', 'r')">Bestari</button>
                <button onclick="callFunc.sendCookie('kelas', 'Cermelang', 'r')">Cermelang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Dedikasi', 'r')">Dedikasi</button>
                <button onclick="callFunc.sendCookie('kelas', 'Efisien', 'r')">Efisien</button>
                <button onclick="callFunc.sendCookie('kelas', 'Fikrah', 'r')">Fikrah</button>
                <button onclick="callFunc.sendCookie('kelas', 'Gemilang', 'r')">Gemilang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Harmoni', 'r')">Harmoni</button>
                <button onclick="callFunc.sendCookie('kelas', 'Iltizam', 'r')">Iltizam</button>
            </div>
        </div>
        <div class="seekAttendance">
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
</html>