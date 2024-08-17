<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
    if(isset($_POST['submit'])) {
        if($func -> fromDB($cDB, [
            'nokp' => $_POST['KP'],
            'nama_guru' => $_POST['nama_guru'],
            'jantina' => $_POST['gender'],
            'matapelajaran' => $_POST['matapelajaran'],
            'katalaluan' => $_POST['katalaluan']
        ], 'GURU') === true) {
            echo "<script>alert('Pendaftaran Guru Berjaya Dilakukan!\\nMAKLUMAT(SILA INGAT):\\nKATALALUAN: " . htmlspecialchars($_POST['katalaluan'], ENT_QUOTES, 'UTF-8') . "'); window.location = 'index.php';</script>";
        }
        else {  
            echo "<script>alert('Pendaftaran Guru Tidak Dapat Dilakukan. Sila Semak Semula Nombor KP.');</script>";
        }
    }
?>
<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY">
    <!-- before it was became a signup page, this page was build for admin system intended to -->
    <!-- create a new user, but has changed it's purpose for user signup -->
    <!-- that's why it use $headAdmin instead of $headClient from config.php -->
    <?php echo $headAdmin; ?>
    <body>
        <div class="addGuru">
            <h1>Borang Pendaftaran Guru</h1>
            <hr>
            <!-- form -->
            <!-- insert Guru name, noic, pass, gender and subject -->
            <form action="" method="post">
                <table>
                    <tr>
                        <td><label for="name">Nama Guru: </label></td>
                        <td><input type="text" name="nama_guru" id="nama_guru" placeholder="Cth: `Ali`, `Abu`"></td>
                    </tr>
                    <tr>
                        <td><label for="KP">Nombor Kad Pengenalan: </label></td>
                        <td><input type="text" name="KP" id="KP" placeholder="Cth: `060604010001`" maxlength="12"></td>
                    </tr>
                    <tr>
                        <td><label for="KP">Katalaluan: </label></td>
                        <td><input type="text" name="katalaluan" id="katalaluan" placeholder="Had adalah `7`" maxlength="7"></td>
                    </tr>
                    <tr>
                        <td><label for="gender">Jantina: </label></td>
                        <td>
                            <input type="radio" name="gender" id="gender" value="L">Lelaki
                            <input type="radio" name="gender" id="gender" value="P">Perempuan
                        </td>
                    </tr>
                    <tr>
                        <td><label for="matapelajaran">Matapelajaran: </label></td>
                        <td>
                            <select name="matapelajaran" id="matapelajaran">
                                <?php
                                    /* 
                                        geting an array of subject that contains every subject
                                        possibly avaliable in every Malaysia high school
                                    */
                                    foreach(globalFunc::matapelajaran as $x) {
                                        echo "<option value=\"$x\">$x</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <button type="submit" name="submit">Daftar</button>
            </form>
            <a href="index.php">Log Masuk</a>
        </div>
    </body>
</html>