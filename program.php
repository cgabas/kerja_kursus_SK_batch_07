<?php
require_once "config/config.php";
require_once "config/functions.php";

// Start session and access variable
session_start();
if (isset($_SESSION['aras'])) {
    $aras = $_SESSION['aras'];
}
else {
    // Handle the case where 'aras' is not set in session
    $aras = 'GUEST'; // Default value or redirect to login
}
session_write_close();

$func = new globalFunc;

// Handle form submissions
$date = isset($_POST['searchDate']) ? $_POST['searchDate'] : NULL;
$program = isset($_POST['searchNama']) ? $_POST['searchNama'] : NULL;

?>
<!DOCTYPE html>
<html lang="ms-MY">
<head>
    <?php
    // Include appropriate head based on user rank
    if ($aras === 'ADMIN') {
        echo $headAdmin;
    }
    else {
        echo $headClient;
    }
    ?>
</head>
<body>
    <div class="program">
        <?php
        // Include appropriate navigation based on user rank
        if ($aras === 'ADMIN') {
            include_once "navigation_admin.php";
        } else {
            include_once "navigation.php";
        }
        ?>
        <h3 id="greeting">Senarai Program Yang Pernah Diadakan Sebelum Ini</h3>
        <form action="" method="post" id="search">
            <label for="searchNama">Carian Program</label>
            <div>
                <input type="text" id="searchNama" name="searchNama" placeholder="Nama Program" maxlength="20">
                <input type="date" id="searchDate" name="searchDate">
                <button type="submit" name="submit_search">
                    <img style="background-image: none;" src="style/image/search.png" alt="Cari Nama Murid">
                    <p>Cari</p>
                </button>
            </div>
        </form>
        <div class="seekAttendance" style="display: block; padding-top: 10px;">
            <?php
                if($aras === 'ADMIN') {
                    echo "<a href=\"main_page_admin.php\">Menu Utama</a>";
                }
                else {
                    echo "<a href=\"main_page.php\">Menu Utama</a>";
                }
            ?>
            <a onclick="window.print();" href="#">Cetak</a>
        </div>
        <form id="printForm" action="program_delete.php" method="post">
            <div style="margin-top: 5px; display: flex; align-items: center; flex-direction: column;">
                <?php
                    if ($aras === 'ADMIN') {
                        echo '<button style="background-color: rgba(1.0,1.0,1.0,0.0); border: 1px solid white; color: red; text-decoration: underline; padding: 5px;" type="submit" name="delete">Hapus</button>';
                    }
                ?>
            </div>
            <table>
            <?php
            // Fetch and display programs base on user rank
            if($aras === 'ADMIN') {
                $func -> program($cDB, ['searchNama' => $program, 'date' => $date], true);
            }
            else {
                $func -> program($cDB, ['searchNama' => $program, 'date' => $date], false);
            }
            ?>
            </table>
        </form>
    </div>
    <style>
        #printForm div:nth-child(2) {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }
        #printForm div:nth-child(1) button {
            cursor: pointer;
        }
    </style>
</body>
</html>
