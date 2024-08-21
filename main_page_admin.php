<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headAdmin; ?>
    <body>
        <?php include_once "navigation_admin.php"; ?>
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
                    $func -> todaysProgram($cDB, false);
                ?>
            </table>
        </div>
        <center id="miniclock">
            <p><u>Tarikh & Masa</u></p>
            <h4 id="date"></h4>
            <h4 id="time"></h4>
        </center>
    </body>
    <script type="module">
        import { callFunc } from './library/progIntervensi-lib.js';

        // animation
        const emoji = ["🕐","🕑","🕒","🕓","🕔","🕕","🕖","🕗","🕘","🕙","🕚","🕛"];
        let count = 0;

        // synchronous datetime update
        callFunc.datetimeTeller(document.getElementById('time'), document.getElementById('date'));
        // count on time
        setInterval(() => {
            callFunc.datetimeTeller(document.getElementById('time'), document.getElementById('date'), emoji[count]);
            // if count have reach 11, set count back to 0
            count = (count === (emoji.length - 1)) ? 0 : count + 1;
        }, 1000);
    </script>
</html>