<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
    
    session_start();
    $program = $func -> checkProgram($cDB, $_SESSION['nokp']);

    if($program !== false) {
        // reminder: this function 'setcookie(...)' must be appear before the <html> tag
        setcookie("program", $program['nama_program']);
    }

    // closing session to give navigation.php some functionality
    session_write_close();
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
                    
                    // Depending on which teacher is using this system, the program will be displayed if:
                    // 1. The program was assigned to the teacher who is currently logged into this system.
                    // 2. The current time is between the program's start and end times.
                    // 3. The teacher has not recorded attendance for this class before, as checked by the checkExistKehadiran function.
                    if(!$isExist) {
                        echo "<div><img alt=\"Tiada Urusan Program\" src=\"style/image/not-involved.png\">";
                        echo "<h1>Tiada Urusan Program Hari Ini!</h1></div>";
                        echo "<div class=\"seekAttendance\"><a href=\"main_page.php\">Menu Utama</a></div>";
                        session_write_close();
                    }
                    else {
                        if(!$func->checkExistKehadiran($cDB, $isExist['kodProgram'], $_COOKIE['kelas'])) {
                            echo "<h3 id=\"greeting\">".$isExist['nama_program']."</h3>";
                            $func -> recordForm($cDB, $_SESSION['nokp'], $_COOKIE['kelas']);
                            session_write_close();
                        }
                        else {
                            echo "<div><img alt=\"Tiada Urusan Program Bagi Kelas ".$_COOKIE['kelas']."\" src=\"style/image/not-involved.png\">";
                            echo "<h1>Kehadiran Kelas Ini Sudah Direkod!</h1></div>";
                            echo "<div class=\"seekAttendance\"><a href=\"main_page.php\">Menu Utama</a></div>";
                            session_write_close();
                        }
                    }
                ?>
            </div>
        </form>
    </body>
</html>
