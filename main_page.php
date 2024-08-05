<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
        <?php include_once "navigation.php"; ?>
        <h1 id="greeting"><?php
            $func = new globalFunc;
            if($_SESSION['gender'] === 'L') {
                // switch case was not used because of some conflict between cases
                if($_SESSION['mp'] === 'Inggeris') {
                    echo "Welcome, Sir ";
                }
                else if($_SESSION['mp'] === 'Melayu') {
                    echo "Selamat Datang, Encik ";
                }
                else if($_SESSION['mp'] === 'Iban') {
                    echo "Selamat Datai, Pengajar ";
                }
                else {
                    echo "Selamat Datang, Encik ";
                }

                // for chinese language
                if($_SESSION['mp'] === 'Cina') {
                    echo "欢迎, ".$_SESSION['username']."斯先生";
                }
                else {
                    echo $_SESSION['username'];
                }
            }
            else {
                if($_SESSION['mp'] === 'Inggeris') {
                    echo "Welcome, Madam/Miss ";
                }
                else if($_SESSION['mp'] === 'Melayu') {
                    echo "Selamat Datang, Puan ";
                }
                else if($_SESSION['mp'] === 'Iban') {
                    echo "Selamat Datai, Pengajar ";
                }
                else {
                    echo "Selamat Datang, Puan ";
                }

                // for chinese language
                if($_SESSION['mp'] === 'Cina') {
                    echo "欢迎， ".$_SESSION['username']."斯女士";
                }
                else {
                    echo $_SESSION['username'];
                }
            }
            
        ?></h1>
        <div class="displayProgram">
            <table>
                <?php
                    $func -> todaysProgram($cDB, false);
                ?>
            </table>
        </div>
    </body>
</html>