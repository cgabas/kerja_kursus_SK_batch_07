<?php
    require_once "config/config.php";
    require_once "config/functions.php";

    $func = new globalFunc;

    if(isset($_POST['import'])) {
        // to store function return data
        $importSuccess = [];

        // Handle Excel file import
        if(isset($_FILES['excel']) && $_FILES['excel']['size'] > 0) {
            $fileAttributes = [
                'tmp_name' => $_FILES['excel']['tmp_name'],
                'name' => $_FILES['excel']['name'],
                'size' => $_FILES['excel']['size'],
                'type' => $_FILES['excel']['type']
            ];

            $importSuccess = [
                'return' => $func -> importFile($cDB, $fileAttributes, "EXCEL"),
                'type' => "HAMPARAN"
            ];
        }

        // Handle TXT file import
        if(isset($_FILES['txt']) && $_FILES['txt']['size'] > 0) {
            $fileTxt = [
                'allowed' => ["text/plain", "text/csv"],
                'tmp_name' => $_FILES['txt']['tmp_name'],
                'name' => $_FILES['txt']['name'],
                'type' => $_FILES['txt']['type'],
                'size' => $_FILES['txt']['size']
            ];

            // Check if file type is allowed
            if(!in_array($fileTxt['type'], $fileTxt['allowed'])) {
                echo "<script>alert('Jenis file tidak dibenarkan.'); window.location = 'import_murid.php';</script>";
                exit;
            }

            $importSuccess = [
                'return' => $func -> importFile($cDB, $fileTxt, "TXT"),
                'type' => "TXT"
            ];
        }

        // Handle success or failure
        if(!empty($importSuccess)) {
            // if return were success/return true
            if($importSuccess['return']) {
                echo "<script>alert('Import berjaya! Sila semak semula senarai nama murid yang didaftarkan selepas ini.'); window.location = 'select_murid.php';</script>";
            }
            // if failed/return false
            else {
                echo "<script>alert('Import ".$importSuccess['type']." gagal, sila cuba lagi.'); //window.location = '';</script>";
            }
        }
        // if there is no changes have been made to $importSuccess
        else {
            echo "<script>alert('Tiada file yang dipilih.'); window.location = 'import_murid.php';</script>";
        }
    }
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="ms-MY"> 
    <?php echo $headClient; ?>
    <!-- calling custom created module -->
    <script type="module" src="library/progIntervensi-lib.js">
        import { callFunc } from "./library/progIntervensi-lib.js";
    </script>
    <body>
        <?php include_once "navigation.php"; ?>
        <div class="import">
            <h1>Mengimport Maklumat Murid</h1>
            <div>
                <p>Dua jenis file yang boleh diimport</p>
                <small>Pilih salah satu</small>
                <div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- to import txt/csv file -->
                        <input type="file" name="txt" id="txt" accept=".txt, .csv" onclick="callFunc.checkFile(
                        document.getElementById('txt'),
                        document.getElementById('file-name'),
                        document.getElementById('msg')
                        );">
                        <label for="txt">.txt / .csv</label>

                        <!-- to import spreadsheet file (.xml/ .xmlx / .ods only supported) -->
                        <!-- to obtain this spreadsheet importing feature, a licensed PHP library called PHPSpreadSheets was used -->
                        <input type="file" name="excel" id="excel" accept=".xls, .xlsx, .ods" onclick="callFunc.checkFile(
                        document.getElementById('excel'),
                        document.getElementById('file-name'),
                        document.getElementById('msg')
                        );">
                        <label for="excel">Excel / Hamparan</label>
                        
                        <hr>
                        <small id="msg"></small>
                        <p id="file-name"></p>
                        <button type="submit" name="import" id="import">Import</button>
                    </form>        
                </div>
            </div>
            <div class="seekAttendance">
                <a href="main_page.php">Menu Utama</a>
            </div>
            <!-- file importing guide -->
            <center>
                <p>Contoh kandungan file Excel / Hamparan:</p>
                <table>
                    <tr>
                        <td>050505050505</td>
                        <td>Abu</td>
                        <td>L</td>
                        <td>Bestari</td>
                    </tr>
                    <tr>
                        <td>070707070707</td>
                        <td>Amanda</td>
                        <td>P</td>
                        <td>Dedikasi</td>
                    </tr>
                </table>
                <p>*Peringatan: Header tidak diperlukan</p>
                <p>Contoh kandungan file TXT/CSV:</p>
                <h3>070707070707,Amanda,P,Dedikasi</h3>
            </center>
        </div>
    </body>
</html>