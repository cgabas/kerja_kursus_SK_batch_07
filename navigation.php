<nav>
    <button onclick="window.location='select_murid.php'">Murid</button>
    <button onclick="window.location='select_record.php'">Rekod Kehadiran</button>
    <div id="logoHTMLcontainer">
        <a href="main_page.php" style="text-decoration: none;margin: none;padding: none;">
            <?php
                // require_once "config/config.php";
                session_start();
                echo $logoInHTML;
            ?>
        </a>
    </div>
    <button onclick="window.location='program.php'">Senarai Program</button>
    <button onclick="callFunc.logoutPrompt()">Log Keluar</button>
</nav>
<script type="module" src="library/progIntervensi-lib.js">
    import { callFunc } from "./library/progIntervensi.js";
</script>