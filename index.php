<?php include_once "config/config.php" ?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
        <div class="divForm">
            <div id="logoHTMLcontainer">
                <?php echo $logoInHTML; ?>
            </div>
            <?php
                include_once "login_process.php";
            ?>
        </div>
    </body>
</html>