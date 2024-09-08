<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;

    // Collect input data
    $array = [
        'nokp' => $_POST['nokp'] ?? NULL,
        'nama_guru' => $_POST['nama'] ?? NULL,
        'katalaluan' => $_POST['katalaluan'] ?? NULL,
        'matapelajaran' => $_POST['matapelajaran'] ?? 'NULL',
        'jantina' => $_POST['jantina'] ?? NULL,
        'nokp_for_refe' => $_COOKIE['nokp'] ?? NULL
    ];

    if(isset($_POST['edit'])) {
        // Check if at least one field is filled
        $missingFields = true;

        if(
            !empty($_POST['nokp']) ||
            !empty($_POST['nama']) ||
            !empty($_POST['katalaluan']) ||
            !empty($_POST['jantina']) ||
            ($_POST['matapelajaran'] ?? 'NULL') !== 'NULL'
        ) {
            $missingFields = false;
        }

        if($missingFields) {
            echo "<script>
                alert('Sila Masukkan Sekurang-kurangnya Satu Maklumat!');
                history.pushState(null, '', 'edit_guru_process.php');
            </script>";
        }
        else {
            $result = $func->fromDB($cDB, $array, 'EDIT_GURU');
            if($result) {
                echo "<script>
                    alert('Maklumat Guru Berjaya Diubah!');
                    window.location = 'main_page_admin.php';
                </script>";
            }
            else {
                echo "<script>
                    alert('Maklumat Guru Tidak Dapat Diubah, Sila Cuba Sebentar Nanti.');
                    window.location = 'main_page_admin.php';
                </script>";
            }
        }
    }
    elseif(isset($_POST['delete']) && isset($_COOKIE['confirm']) && $_COOKIE['confirm'] === 'true') {
        if($func -> fromDB($cDB, ['switch' => 'GURU', 'nokp' => $_COOKIE['nokp']], 'DELETE_ROW')) {
            echo "<script>
                alert('Guru Ini Berjaya Disingkirkan Dari Pangkalan Data.');
                window.location = 'main_page_admin.php';
            </script>";
        }
        else {
            echo "<script>alert('Tidak Dapat Disingkirkan, Sila Cuba Lagi...');</script>";
        }
        // Clear the confirm cookie after the operation
        setcookie('confirm', '', time() - 3600, '/');
    }
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">
<?php echo $headAdmin; ?>
<body>
    <?php include_once "navigation_admin.php"; ?>
    <div class="edit">
        <h3 id="greeting">Sunting Maklumat Untuk <u><?php echo htmlspecialchars($_COOKIE['nama_guru']); ?></u></h3>
        <form action="" method="post">
            <label for="nama">Nama Guru</label>
            <input type="text" name="nama" placeholder="Masukkan Nama Baharu" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>">
            <label for="nokp">Nombor KP</label>
            <input type="text" name="nokp" placeholder="Masukkan NOIC Baharu" maxlength="12" value="<?php echo htmlspecialchars($_POST['nokp'] ?? ''); ?>">
            <label for="katalaluan">Katalaluan</label>
            <input type="text" name="katalaluan" placeholder="Katalaluan Baharu" maxlength="7" value="<?php echo htmlspecialchars($_POST['katalaluan'] ?? ''); ?>">
            <label for="matapelajaran">Matapelajaran</label>
            <select name="matapelajaran" id="matapelajaran">
                <option value="NULL">-PILIH-</option>
                <?php
                    foreach (globalFunc::matapelajaran as $x) {
                        $selected = ($_POST['matapelajaran'] ?? '') == $x ? 'selected' : '';
                        echo "<option value=\"$x\" $selected>$x</option>";
                    }
                ?>
            </select>
            <label for="jantina">Jantina</label>
            <div>
                <input type="radio" name="jantina" value="L" <?php echo ($_POST['jantina'] ?? '') == 'L' ? 'checked' : ''; ?>>Lelaki
                <input type="radio" name="jantina" value="P" <?php echo ($_POST['jantina'] ?? '') == 'P' ? 'checked' : ''; ?>>Perempuan
            </div>
            <hr>
            <button type="reset">Kosongkan</button>
            <button type="submit" name="delete" onclick="return callFunc.userConfirm(event, 'GURU');">Singkirkan</button>
            <button type="submit" name="edit">Sunting</button>
            <small>*PERINGATAN: TINGGALKAN KOTAK INPUT KOSONG PADA<br> BAHAGIAN YANG TIDAK MAHU DIUBAH</small>
            <small id="important_msg">*AMARAN: MENYINGKIRKAN GURU INI AKAN MENYINGKIRKAN<br> GURU DARIPADA PANGKALAN DATA!</small>
        </form>
        <div class="seekAttendance">
            <a href="main_page_admin.php">Menu Utama</a>
        </div>
    </div>
    <script type="module">
        import { callFunc } from './library/progIntervensi-lib.js';
        window.callFunc = callFunc;
    </script>
</body>
</html>
