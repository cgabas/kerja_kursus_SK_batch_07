<?php
    require_once "config/config.php";
    require_once "config/functions.php";
?>
<!-- frontend -->
 <!DOCTYPE html>
 <html lang="ms-MY">
    <?php echo $headClient; ?>
    <script type="module">
      import { callFunc } from "./library/progIntervensi-lib.js";
    </script>
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
       <div class="seekAttendance">
          <a href="main_page.php">Menu Utama</a>
       </div>
    </body>
 </html>