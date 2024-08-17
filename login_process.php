<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;

    if(isset($_POST['submit'])) {
        $nokp = $_POST['nokp'];
        $pass = $_POST['pass'];

        $func->loginProcess($cDB, ['nokp'=>$nokp, 'pass'=>$pass]);
    }
?>

<!-- form -->
<form class="form" action="" method="post">
    <h2>Log Masuk</h2>
    <input name="nokp" type="text" placeholder="NoKP Anda" minlength="12" maxlength="12" autofocus required>
    <input name="pass" type="password" placeholder="Katalaluan Anda" maxlength="7" required>
    <button type="submit" name="submit">Log Masuk</button>
    <button type="button" onclick="window.location = 'add_guru.php'">Daftar</button>
</form>