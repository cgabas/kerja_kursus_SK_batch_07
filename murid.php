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
            <form action="" method="post" id="printForm">
                <label for="search">Carian Nama</label>
                <input type="text" id="search" name="search" placeholder="Nama Murid" maxlength="20">
                <button type="submit" name="submit">
                    <img src="style/image/search.png" alt="Cari Nama Murid">
                    <p>Cari</p>
                </button>
            </form>
            <div id="smallBoxKelas" style="width: 100px; margin: 10px 0 0 0;">
                <p id="smallText" style=" color: black;"><?php echo $_COOKIE['kelas']; ?></p>
            </div>
            <table>
                <?php
                    $func = new globalFunc;
                    $search = (isset($_POST['submit']))?$_POST['search']:NULL;
                    $func -> murid($cDB, $search, $_COOKIE['kelas'], NULL);
                ?>
            </table>
        </div>
        <div class="seekAttendance" style="display: block; margin-top: 5px;">
            <a href="main_page.php">Menu Utama</a>
            <a href="#" onclick="window.print();">Cetak</a>
        </div>
    </body>

    <!-- for media printing -->
    <style>
        @media print {
            html {
                scale: 100%;
            }
            nav {
                display: none;
            }
            .murid h3 {
                color: black;
            }
            #printForm {
                display: none;
            }
            #smallBoxKelas p {
                font-size: larger;
            }
            .murid table {
                border-collapse: collapse;
            }
            .murid table tr th {
                border: 1px solid black;
            }
            .murid table tr td {
                border: 1px solid black;
                color: black;
            }
        }
    </style>
</html>