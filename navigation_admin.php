<nav>
    <button onclick="window.location='select_guru.php'">Guru</button>
    <button onclick="window.location='add_program.php'">Wujudkan Program</button>
    <div id="logoHTMLcontainer">
        <a href="main_page_admin.php" style="text-decoration: none;margin: none;padding: none;">
            <?php
                // require_once "config/config.php";
                session_start();
                echo $logoInHTML;
            ?>
        </a>
        <small id="smallText">Mod Admin</small>
    </div>
    <button onclick="window.location='program.php'">Senarai Program</button>
    <button onclick="callFunc.logoutPrompt()">Log Keluar</button>
</nav>
<script type="module" src="library/progIntervensi-lib.js">
    import { callFunc } from "./library/progIntervensi.js";
</script>