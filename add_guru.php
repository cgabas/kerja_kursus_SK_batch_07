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
            echo "<script>alert('Pendaftaran Guru Berjaya Dilakukan!'); window.location = 'main_page_admin.php';</script>";
        }
        else {  
            echo "<script>alert('Pendaftaran Guru Tidak Dapat Dilakukan. Sila Semak Semula Nombor KP.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php echo $headAdmin; ?>
    <body>
        <?php include_once "navigation_admin.php"; ?>
        <div class="addGuru">
            <h1>Borang Pendaftaran Guru</h1>
            <hr>
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
        </div>
    </body>
</html>