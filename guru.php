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
            <h3 id="greeting">Senarai Guru Yang Didaftarkan</h3>
            <form action="" method="post" id="printForm">
                <label for="search">Carian Nama</label>
                <input type="text" id="search" name="search" placeholder="Nama Guru" maxlength="20">
                <button type="submit" name="submit">
                    <img src="style/image/search.png" alt="Cari Nama Murid">
                    <p>Cari</p>
                </button>
            </form>
            <table>
                <?php
                    $func = new globalFunc;
                    $search = (isset($_POST['submit']))?$_POST['search']:NULL;
                    $func -> guru($cDB, $search, NULL);
                ?>
            </table>
        </div>
        <div class="seekAttendance" style="display: block; margin-top: 10px;">
            <a href="main_page_admin.php">Laman Utama</a>
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
            .guru h3 {
                color: black;
            }
            #printForm {
                display: none;
            }
            #smallBoxKelas p {
                font-size: larger;
            }
            .guru table {
                border-collapse: collapse;
            }
            .guru table tr th {
                border: 1px solid black;
            }
            .guru table tr td {
                border: 1px solid black;
                color: black;
            }
            .seekAttendance a {
                display: none;
            }
        }
    </style>
 </html>