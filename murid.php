<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient;?>
    <body>
        <?php include_once "navigation.php";?>
        <div class="murid">
            <h3 id="greeting">Senarai Murid Yang Mengikuti</h3>
            <form action="" method="post">
                <label for="search">Carian Nama</label>
                <input type="text" id="search" name="search" placeholder="Nama Murid" maxlength="20">
                <button type="submit" name="submit">
                    <img src="style/image/search.png" alt="Cari Nama Murid">
                    <p>Cari</p>
                </button>
            </form>
            <div style="width: 100px; margin: 10px 0 0 0;">
                <p id="smallText" style=" color: black;"><?php echo $_COOKIE['kelas']; ?></p>
            </div>
            <table>
                <?php
                    $func = new globalFunc;
                    $search = (isset($_POST['submit']))?$_POST['search']:NULL;
                    $func -> murid($cDB, $search, $_COOKIE['kelas'], false);
                ?>
            </table>
        </div>
    </body>
</html>