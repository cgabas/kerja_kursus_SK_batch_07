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
            <h1>Senarai Murid</h1>
            <hr>
            <div>
                <?php
                    foreach(globalFunc::kelas as $x) {
                        echo "<button onclick=\"callFunc.sendCookie('kelas', '$x', 'm')\">$x</button>";        
                    }
                ?>
            </div>
        </div>
        <hr>
        <div class="seekAttendance">
            <h1>Pilihan Lain</h1>
            <button onclick="window.location='select_kelas_attendance.php'">Lihat Kehadiran Murid</button>
            <button onclick="window.location='add_murid.php'">Daftar Murid Baharu</button>
            <button onclick="window.location='edit_murid.php'">Sunting Maklumat Murid</button>
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
</html>