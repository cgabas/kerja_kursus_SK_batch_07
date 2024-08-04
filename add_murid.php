<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;
    if(isset($_POST['submit'])) {
        if($func -> fromDB($cDB, [
            'noic' => $_POST['KP'],
            'nama' => $_POST['name'],
            'jantina' => $_POST['gender'],
            'kelas' => $_POST['kelas']
        ], 'MURID')) {
            echo "<script>alert('Pendaftaran Murid Berjaya Dilakukan!'); window.location = 'main_page.php';</script>";
        }
        else {  
            echo "<script>alert('Pendaftaran Murid Tidak Dapat Dilakukan. Sila Semak Semula Nombor KP.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php echo $headClient; ?>
    <body>
        <?php include_once "navigation.php"; ?>
        <div class="addMurid">
            <h1>Borang Pendaftaran Murid</h1>
            <hr>
            <form action="" method="post">
                <table>
                    <tr>
                        <td><label for="name">Nama Murid: </label></td>
                        <td><input type="text" name="name" id="name" placeholder="Cth: `Ali`, `Abu`"></td>
                    </tr>
                    <tr>
                        <td><label for="KP">Nombor Kad Pengenalan: </label></td>
                        <td><input type="text" name="KP" id="KP" placeholder="Cth: `060604010001`" maxlength="12"></td>
                    </tr>
                    <tr>
                        <td><label for="gender">Jantina: </label></td>
                        <td>
                            <input type="radio" name="gender" id="gender" value="L">Lelaki
                            <input type="radio" name="gender" id="gender" value="P">Perempuan
                        </td>
                    </tr>
                    <tr>
                        <td><label for="kelas">Kelas: </label></td>
                        <td>
                            <select name="kelas" id="kelas">
                                <?php
                                    foreach(globalFunc::kelas as $x) {
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