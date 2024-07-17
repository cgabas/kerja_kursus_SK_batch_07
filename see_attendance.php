<?php
require_once "config/config.php";
require_once "config/functions.php";

$func = new globalFunc;
?>
<!DOCTYPE html>
<html lang="ms-MY">
    <?php echo $headClient; ?>
    <script type="module">
        import { callFunc } from "./library/progIntervensi-lib.js";

        document.addEventListener('DOMContentLoaded', function() {
            var kelas = document.getElementById('kelas').value;
            var button = document.getElementById('papar');

            button.addEventListener('click', function() {
                callFunc.switchTable(kelas);
            });
        });
    </script>
    <body>
        <?php include_once "navigation.php"; ?>
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
                            echo "<td>".$data['masa_rekod']."</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No records found.</td></tr>";
                    }
                ?>
            </table>
        </div>
        <button id="print">Cetak</button> <small style="color: red;">*(belum ada)</small>
    </body>
</html>
