<?php
require_once "config/config.php";
require_once "config/functions.php";

$func = new globalFunc;

// Collect input data
$array = [
    'noic' => $_POST['noic'] ?? NULL,
    'nama' => $_POST['nama'] ?? NULL,
    'kelas' => $_POST['kelas'] ?? 'NULL',
    'jantina' => $_POST['jantina'] ?? NULL,
    'noic_for_refe' => $_COOKIE['noic'] ?? NULL
];

if (isset($_POST['edit'])) {
    // Check if at least one field is filled
    $missingFields = true;

    if (
        !empty($_POST['noic']) ||
        !empty($_POST['nama']) ||
        !empty($_POST['kelas']) ||
        !empty($_POST['jantina'])
    ) {
        $missingFields = false;
    }

    if ($missingFields) {
        echo "<script>
            alert('Sila Masukkan Sekurang-kurangnya Satu Maklumat!');
            history.pushState(null, '', 'edit_murid_process.php');
        </script>";
    } else {
        if ($func->fromDB($cDB, $array, 'EDIT_MURID')) {
            echo "<script>
                alert('Maklumat Murid Berjaya Diubah!');
                window.location = 'main_page.php';
            </script>";
        } else {
            echo "<script>
                alert('Maklumat Murid Tidak Dapat Diubah, Sila Cuba Sebentar Nanti.');
                window.location = 'main_page.php';
            </script>";
        }
    }
}
elseif (isset($_POST['delete']) && isset($_COOKIE['confirm']) && $_COOKIE['confirm'] === 'true') {
    if ($func->fromDB($cDB, ['switch' => 'MURID', 'noic' => $_COOKIE['noic']], 'DELETE_ROW')) {
        echo "<script>
            alert('Murid Ini Berjaya Disingkirkan Dari Pangkalan Data.');
            window.location = 'main_page.php';
        </script>";
    } else {
        echo "<script>alert('Tidak Dapat Disingkirkan, Sila Cuba Lagi...');</script>";
    }
    // Clear the confirm cookie after the operation
    setcookie('confirm', '', time() - 3600, '/');
}
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">
<?php echo $headClient; ?>
<body>
    <?php include_once "navigation.php"; ?>
    <div class="edit">
        <h3 id="greeting">Sunting Maklumat Untuk <u><?php echo htmlspecialchars($_COOKIE['nama']); ?></u></h3>
        <form action="" method="post">
            <label for="nama">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama Baharu" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>">
            <label for="noic">Nombor IC</label>
            <input type="text" name="noic" maxlength="12" placeholder="Masukkan NOIC Baharu" value="<?php echo htmlspecialchars($_POST['noic'] ?? ''); ?>">
            <label for="kelas">Kelas</label>
            <select name="kelas" id="kelas">
                <option value="NULL">-PILIH-</option>
                <?php
                    foreach (globalFunc::kelas as $x) {
                        $selected = ($_POST['kelas'] ?? '') == $x ? 'selected' : '';
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
            <button type="submit" name="delete" onclick="return callFunc.userConfirm(event, 'MURID');">Singkirkan</button>
            <button type="submit" name="edit">Sunting</button>
            <small>*PERINGATAN: TINGGALKAN KOTAK INPUT KOSONG PADA<br> BAHAGIAN YANG TIDAK MAHU DIUBAH</small>
            <small id="important_msg">*AMARAN: MENYINGKIRKAN MURID INI AKAN MENYINGKIRKAN<br> MURID DARIPADA PANGKALAN DATA!</small>
        </form>
        <div class="seekAttendance">
            <a href="main_page.php">Menu Utama</a>
        </div>
    </div>
    <script type="module">
        import { callFunc } from './library/progIntervensi-lib.js';
        window.callFunc = callFunc;
    </script>
</body>
</html>
