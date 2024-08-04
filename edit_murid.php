<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">
    <?php echo $headClient; ?>
    <body> 
    <?php include_once "navigation.php";?>
        <div class="murid" style="margin-top: 10px;">
        <form action="" method="post" id="printForm">
            <label for="search">Carian Nama</label>
            <input type="text" id="search" name="search" placeholder="Nama Murid" maxlength="20">
            <button type="submit" name="submit">
                <img src="style/image/search.png" alt="Cari Nama Murid">
                <p>Cari</p>
            </button>
        </form>
        <table>
            <?php
                $search = (isset($_POST['submit'])) ? $_POST['search'] : NULL;
                $func->murid($cDB, $search, NULL, 'MURID');
            ?>
        </table>
        </div>
        <div class="seekAttendance">
            <a href="main_page.php">Menu Utama</a>
        </div>
    </body>
    <script type="module" src="./library/progIntervensi-lib.js">
        import { callFunc } from './library/progIntervensi-lib.js';
    </script>
</html>
