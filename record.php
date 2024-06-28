<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
        <?php include_once "navigation.php"; ?>
        <form action="save_record.php" method="post">
            <div class="record">
                <?php
                    // reminder: session_start() was removed because of navigation.php
                    $isExist = $func -> checkProgram($cDB, $_SESSION['nokp']);
                    if(!$isExist) {
                        echo "<div><img alt=\"Tiada Urusan Program\" src=\"style/image/not-involved.png\">";
                        echo "<h1>Tiada Urusan Program Hari Ini!</h1></div>";
                        session_write_close();
                    }
                    else {
                        echo "<h3 id=\"greeting\">".$isExist['nama_program']."</h3>";
                        $func -> recordForm($cDB, $_SESSION['nokp'], $_COOKIE['kelas']);
                        session_write_close();
                    }
                ?>
            </div>
        </form>
    </body>
</html>
