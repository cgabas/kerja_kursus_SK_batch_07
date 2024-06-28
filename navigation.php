<nav>
    <button onclick="window.location='select_murid.php'">Senarai Murid</button>
    <button onclick="window.location='select_record.php'">Rekod Kehadiran</button>
    <div id="logoHTMLcontainer">
        <a href="main_page.php" style="text-decoration: none;margin: none;padding: none;">
            <?php
                // require_once "config/config.php";
                session_start();
                echo $logoInHTML;
            ?>
        </a>
        <small id="smallText">Menu Utama</small>
    </div>
    <button onclick="window.location='program.php'">Senarai Program</button>
    <button onclick="window.location='logout.php'">Log Keluar</button>
</nav>