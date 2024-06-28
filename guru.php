<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
 <!DOCTYPE html>
 <html lang="en">
    <?php echo $headAdmin; ?>
    <body>
        <?php include_once "navigation_admin.php"; ?>
        <div class="guru">
            <h3 id="greeting">Senarai Murid Yang Mengikuti</h3>
            <form action="" method="post">
                <label for="search">Carian Nama</label>
                <input type="text" id="search" name="search" placeholder="Nama Murid" maxlength="20">
                <button type="submit" name="submit">
                    <img src="style/image/search.png" alt="Cari Nama Murid">
                    <p>Cari</p>
                </button>
            </form>
            <table>
                <?php
                    $func = new globalFunc;
                    $search = (isset($_POST['submit']))?$_POST['search']:NULL;
                    $func -> guru($cDB, $search);
                ?>
            </table>
        </div>
    </body>
 </html>