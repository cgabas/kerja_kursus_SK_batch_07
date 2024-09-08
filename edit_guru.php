<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
    
    $search = isset($_POST['submit']) ? $_POST['search'] : NULL;
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">
    <?php echo $headAdmin; ?>
    <body> 
    <?php include_once "navigation_admin.php";?>
        <div class="guru" style="margin-top: 10px;">
            <form action="" method="post" id="printForm">
                <label for="search">Carian Nama</label>
                <input type="text" id="search" name="search" placeholder="Nama Guru" maxlength="20">
                <button type="submit" name="submit">
                    <img src="style/image/search.png" alt="Cari Nama Guru">
                    <p>Cari</p>
                </button>
            </form>
            <table>
                <?php
                    $func->guru($cDB, $search, 'GURU');
                ?>
            </table>
        </div>
        <div class="seekAttendance">
            <a href="main_page_admin.php">Menu Utama</a>
        </div>
    </body>
    <script type="module" src="./library/progIntervensi-lib.js">
        import { callFunc } from './library/progIntervensi-lib.js';
    </script>
</html>
