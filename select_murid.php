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
                <button onclick="callFunc.sendCookie('kelas', 'Arif', 'm')">Arif</button>
                <button onclick="callFunc.sendCookie('kelas', 'Bestari', 'm')">Bestari</button>
                <button onclick="callFunc.sendCookie('kelas', 'Cermelang', 'm')">Cermelang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Dedikasi', 'm')">Dedikasi</button>
                <button onclick="callFunc.sendCookie('kelas', 'Efisien', 'm')">Efisien</button>
                <button onclick="callFunc.sendCookie('kelas', 'Fikrah', 'm')">Fikrah</button>
                <button onclick="callFunc.sendCookie('kelas', 'Gemilang', 'm')">Gemilang</button>
                <button onclick="callFunc.sendCookie('kelas', 'Harmoni', 'm')">Harmoni</button>
                <button onclick="callFunc.sendCookie('kelas', 'Iltizam', 'm')">Iltizam</button>
            </div>
        </div>
        <hr>
        <div class="seekAttendance">
            <h1>Pilihan Lain</h1>
            <button onclick="window.location='select_kelas_attendance.php'">Lihat Kehadiran Murid</button>
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
</html>