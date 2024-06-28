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
        <h1 id="greeting">Selamat Datang, <?php
            $func = new globalFunc;
            if($_SESSION['gender'] === 'L') {
                // switch case was not used because of some conflict between cases
                if($_SESSION['mp'] === 'Inggeris') {
                    echo "Sir ";
                }
                else if($_SESSION['mp'] === 'Melayu') {
                    echo "Encik ";
                }
                else {
                    echo "Encik ";
                }
            }
            else {
                if($_SESSION['mp'] === 'Inggeris') {
                    echo "Madam/Miss ";
                }
                else if($_SESSION['mp'] === 'Melayu') {
                    echo "Puan ";
                }
                else {
                    echo "Puan ";
                }
            }
            echo $_SESSION['username']; 
        ?></h1>
        <div class="displayProgram">
            <table>
                <?php
                    $func -> todaysProgram($cDB);
                ?>
            </table>
        </div>
    </body>
</html>