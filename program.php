<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    // access variable from session 
    session_start();
    $aras = $_SESSION['aras'];
    session_write_close();
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php
        // style change based on user's rank
        if($aras === 'ADMIN') {
            echo $headAdmin;
        }
        else {
            echo $headClient;
        }
    ?>
    <body>
        <div class="program">
            <?php
                // navigation style change depend on user's rank
                if($aras === 'ADMIN') {
                    include_once "navigation_admin.php";
                }
                else {
                    include_once "navigation.php";
                }
            ?>
            <h3 id="greeting">Senarai Program Yang Pernah Diadakan Sebelum Ini</h3>
            <form action="" method="post">
                <label for="searchNama">Carian Program</label>
                <div>
                    <input type="text" id="searchNama" name="searchNama" placeholder="Nama Program" maxlength="20">
                    <input type="date" id="searchDate" name="searchDate" placeholder="DD-MM-YYYY">
                    <button type="submit" name="submit">
                        <img src="style/image/search.png" alt="Cari Nama Murid">
                        <p>Cari</p>
                    </button>
                </div>
            </form>
            <form action="program_delete.php" method="post">
                <table>
                    <?php
                        $func = new globalFunc;
                        $date = isset($_POST['searchDate'])?$_POST['searchDate']:NULL;
                        $program = isset($_POST['searchNama'])?$_POST['searchNama']:NULL;

                        if($aras === 'ADMIN') {
                            session_write_close();
                            $func -> program($cDB, ['searchNama'=>$program, 'date'=>$date], true);
                        }
                        else {
                            $func -> program($cDB, ['searchNama'=>$program, 'date'=>$date], false);
                        }
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>