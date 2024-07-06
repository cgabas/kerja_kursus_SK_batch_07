<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
 <!DOCTYPE html>
 <html lang="ms-MY">
    <?php echo $headClient; ?>
    <body>
       <?php 
         $func = new globalFunc;
         include_once "navigation.php";
       ?>
       <div class="displayProgram">
         <table>
            <?php $func -> todaysProgram($cDB, true); ?>
         </table>
       </div>
    </body>
 </html>