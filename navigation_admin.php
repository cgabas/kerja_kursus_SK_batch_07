<nav>
    <button onclick="window.location='guru.php'">Senarai Guru</button>
    <button onclick="window.location='add_program.php'">Wujudkan Program</button>
    <div id="logoHTMLcontainer">
        <a href="main_page_admin.php" style="text-decoration: none;margin: none;padding: none;">
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