<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;

    if(isset($_POST['submit'])) {

        // getting form data
        $nokp = $_POST['nokp'];
        $tempat = $_POST['location'];
        $maklumat = $_POST['desc'];
        $tarikh = $_POST['date'];
        $nama_program = $_POST['namaProg'];
        $masa_mula = $_POST['start-time'];
        $masa_tamat = $_POST['end-time'];

        if($func->fromDB($cDB, [
            'nama_program' => $nama_program,
            'maklumat' => $maklumat,
            'tempat' => $tempat,
            'tarikh' => $tarikh,
            'masa_mula' => $masa_mula,
            'masa_tamat' => $masa_tamat,
            'nokp' => $nokp], 'PROGRAM')) {
            echo "<script>alert('Program Yang Dinamakan `".$nama_program."` Telah Diwujudkan!'); window.location = 'main_page_admin.php';</script>";
        }
        else {
            echo "<script>alert('Program Tidak Dapat Diwujudkan, Sila Cuba Lagi.');</script>";
        }
    }
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headAdmin; ?>
    <body>
        <?php include_once "navigation_admin.php";?>
        <div class="addProgram">
            <h1 id="programName">Nama Program</h1>
            <hr>
            <form action="" method="post">
                <input name="namaProg" onkeyup="callFunc.inputToTitleSync()" type="text" id="syncTextToTitle" placeholder="Nama Program" required autofocus>
                <div>
                    <div>
                        <label for="date">Tarikh</label>
                        <input type="date" name="date" id="date" required>
                    </div>
                    <div>
                        <label for="start-time">Masa Mula</label>
                        <input type="time" name="start-time" id="time" required>
                    </div>
                    <div>
                        <label for="end-time">Masa Tamat</label>
                        <input type="time" name="end-time" id="time" required>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="location">Tempat</label>
                        <input type="text" name="location" id="location" placeholder="Tempat" required>
                    </div>
                    <div>
                        <label for="nokp">Pengurus Program</label>
                        <select name="nokp" id="nokp">
                            <?php
                                $guru = $func->guru($cDB, NULL, 'LIST');
                                foreach($guru['nokp'] as $x) {
                                    foreach($guru['nama_guru'] as $y) {
                                        echo "<option value=\"$x\">$y</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="desc">Maklumat Program</label>
                    <textarea name="desc" id="desc" cols="50" rows="5" placeholder="Masukkan Maklumat Program..."></textarea>
                </div>
                <div>
                    <button type="submit" name="submit">Wujudkan</button>
                    <button type="reset"><i>Kosongkan</i></button>
                </div>
            </form>
        </div>
        <script type="module" src="library/progIntervensi-lib.js">
            import { callFunc } from "./library/progIntervensi-lib.js";
        </script>
    </body>
</html>