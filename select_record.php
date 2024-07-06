<?php
    require_once "config/config.php";
    require_once "config/functions.php";
    $func = new globalFunc;
?>
<!DOCTYPE html>
<html lang="en">
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
        <script type="module" src="/library/progIntervensi-lib.js"></script>
    </body>
</html>