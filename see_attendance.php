<?php
require_once "config/config.php";
require_once "config/functions.php";

$func = new globalFunc;
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
        <div class="murid">  
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Jantina</th>
                    <th>Nom IC</th>
                    <th>Masa Direkod</th>
                </tr>
                <?php
                    $students = $func->findStudent($cDB, $_COOKIE['kod'], $_COOKIE['kelas']);
                    if ($students) {
                        foreach ($students as $data) {
                            echo "<tr><td>".$data['nama']."</td>";
                            echo "<td>".$data['jantina']."</td>";
                            echo "<td>".$data['noic']."</td>";
                            echo "<td>".$func -> timeFormatChange($data['masa_rekod'], 'NORMAL')."</td></tr>"; // must me 12 hour system
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found.</td></tr>";
                    }
                ?>
            </table>
        </div>
        <div class="seekAttendance">
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
        }
    </style>
</html>
