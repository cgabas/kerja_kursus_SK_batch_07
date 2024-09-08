<?php
require_once "config/config.php";
require_once "config/functions.php";

$func = new globalFunc;

// getting column tarikh and nama_program from table program
$data = $func -> fromDB($cDB, $_COOKIE['kod'], 'LIST_PROGRAM');
// for table data
$students = $func -> findStudent($cDB, $_COOKIE['kod'], $_COOKIE['kelas']);
// check user egibility to delete row
session_start();
$owner = $func -> checkDeletionEligibility($cDB, $_SESSION['nokp'], $_COOKIE['kod']);
session_write_close();

// if user cliked on `Hapus Baris`
if(isset($_POST['deleteButton'])) {
    $array = $_POST['deleteRow'] ?? [];
    $isSuccess = true;

    if(!empty($array)) {
        foreach($array as $delete) {
            // if deletion fail
            if(!$func -> murid($cDB, $delete, $_COOKIE['kod'], 'DELETE_KEHADIRAN')) {
                echo "<script>alert('Baris tidak dapat dihapuskan, sila cuba lagi');</script>";
                $isSuccess = false;
                break;
            }
        }

        if($isSuccess) {
            echo "<script>alert('" . count($array) . " baris telah berjaya dihapuskan!'); window.location = 'see_attendance.php';</script>";   
        }
    }
    else {
        echo "<script>alert('Sila pilih sekurang-kurangnya SATU baris untuk dihapuskan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient;?>
    <body>
        <?php include_once "navigation.php"; ?>
        <h3 id="greeting">
            <!-- access the 'kelas' name using $_COOKIE[] function  -->
            Kehadiran Murid Untuk Kelas <?php echo $_COOKIE['kelas'];?>
        </h3>
        <h4 id="subtitle">Program: <u><?php echo $data['nama_program'];?></u></h4>
        <h4 id="subtitle">Pada Tarikh: <i style="color: yellow;">
            <u><?php echo $func->dateFormatChange($data['tarikh'], 'NORMAL');?></u>
        </i></h4>
        <!-- adding row deletion function on ver 1.4.0(refer to system commit msg on github) : 7/9/2024 -->
        <form action="#" method="post">
            <div class="murid">
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>Jantina</th>
                        <th>Nom IC</th>
                        <th>Masa Direkod</th>
                        <?php
                            if($owner) {
                                echo "<th>Pilih</th>";
                            }
                        ?>
                    </tr>
                    <?php
                        if($students) {
                            foreach ($students as $data) {
                                echo "<tr><td>".$data['nama']."</td>";
                                echo "<td>".$data['jantina']."</td>";
                                echo "<td>".$data['noic']."</td>";
                                echo "<td>".$func -> timeFormatChange($data['masa_rekod'], 'NORMAL')."</td>"; // turn the default MySQL 24h system to 12h system
                                if($owner) {
                                    echo "<td><input type=\"checkbox\" name=\"deleteRow[]\" value=\"" . $data['noic'] . "\"></td></tr>"; // set Murid's noic for row deletion
                                }
                            }
                        }
                        else {
                            if($owner) {
                                echo "<tr><td colspan='5'>Tiada Rekod Murid Disini.</td></tr>";
                            }
                            else {
                                echo "<tr><td colspan='4'>Tiada Rekod Murid Disini.</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
            <!-- button only can be access via JavaScript -->
            <button style="display: none;" type="submit" id="deleteButton" name="deleteButton"></button>
        </form>
        <div class="seekAttendance" style="flex-direction: row;">
            <a href="main_page.php">Menu Utama</a>
            <?php
                if($owner) {
                    echo "<a style=\"color: red; cursor: pointer;\" href=\"#\" onclick=\"clickHiddenSubmit();\">Hapus Baris</a>";
                }
            ?>
            <a href="#" onclick="window.print();">Cetak</a>
        </div>
    </body>
    <style>
        @media print {
            html {
                scale: 100%;
            }
            nav {
                display: none;
            }
            h4, i {
                color: black;
            }
            .murid table {
                border-collapse: collapse;
            }
            .murid table tr th {
                border: 1px solid black;
                color: black;
            }
            .murid table tr td {
                border: 1px solid black;
                color: black;
            }
            .murid table tr td:nth-last-child(1),
            .murid table tr th:nth-last-child(1) {
                display: none;
            }
        }
    </style>
    <!-- load script after style to avoid flashing/late rendering -->
    <script>
        function clickHiddenSubmit() {
            // click hidden submit button inside form
            userConfirm = confirm('Adakah anda ingin menghapuskan baris rekod yang dipilih?');
            if(userConfirm) {
                $('#deleteButton').trigger('click');
            }
            else {
                window.location = 'see_attendance.php';
            }
        }
    </script>
    <script type="module" src="library/progIntervensi-lib.js">
        import { callFunc } from "./library/progIntervensi.js";
    </script>
    <script src="library/js_library/jquery_slim.js"></script>
</html>
