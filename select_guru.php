<?php
    require_once "config/config.php";
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <script type="module">
        import { callFunc } from "./library/progIntervensi-lib.js";
    </script>
    <body>
        <div class="seekAttendance">
            <h1>Sila Pilih</h1>
            <button onclick="window.location='guru.php'">Lihat Senarai Guru</button>
            <button onclick="window.location='edit_guru.php'">Sunting Maklumat Guru</button>
            <a href="main_page_admin.php">Menu Utama</a>
        </div>
    </body>
</html>