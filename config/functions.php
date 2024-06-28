<?php
    class globalFunc {
        
        // generate random 7 letters code with some prefix you can add
        function randCode($pf) { // return function
            $randBytes = random_bytes(3); // generate 3 bytes of random code
            $convert2Hex = bin2hex($randBytes); // convert it to hexadecimal which becomes 6 character
            return $pf . $convert2Hex; // combine it with the given prefix from given argument when returning values
        }

        // find guru's name by their nokp
        function nokp2guru($DB, $v) { // return function
            $result = mysqli_query($DB, "SELECT nama_guru FROM guru WHERE nokp='$v'");
            if(mysqli_num_rows($result) > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    return $data['nama_guru'];
                }
            }
            else {
                return false;
            }
        }

        // change time format from 12Hour system to 24Hour system and vice versa
        function timeFormatChange($t, $s) { // return function
            switch($s) {
                case 'REVERSE':
                    $datetime = DateTime::createFromFormat('g:i A', $t);
                    $format12 = $datetime -> format('H:i:s');
                    return $format12;        
                case 'NORMAL':
                    $datetime = DateTime::createFromFormat('H:i:s', $t);
                    $format12 = $datetime -> format('g:i A');
                    return $format12;
            }
            $datetime = DateTime::createFromFormat('H:i:s', $t);
            $format12 = $datetime -> format('g:i A');
            return $format12;
        }

        /*
        change date format from DD-MM-YYYY which is mysql preferred format
        to YYYY-MM-DD date format that we commonly use
        */
        function dateFormatChange($t, $s) { // return function
            switch($s) {
                case 'REVERSE':
                    $datetime = DateTime::createFromFormat('d-m-Y', $t);
                    $formatDMY = $datetime -> format('Y-m-d');
                    return $formatDMY;
                case 'NORMAL':
                    $datetime = DateTime::createFromFormat('Y-m-d', $t);
                    $formatDMY = $datetime -> format("d-m-Y");
                    return $formatDMY;
            }
        }

        /*
        to check if the login details is correct and to allow
        admin and user to access different web page based on
        their level(aras)
        */
        function loginProcess($DB, $a) { //procedure function
            $stmt = mysqli_prepare($DB, "SELECT * FROM guru WHERE nokp=? AND katalaluan=?");
            mysqli_stmt_bind_param($stmt, "ss", $a['nokp'], $a['pass']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                session_start();
                $_SESSION['username'] = $data['nama_guru'];
                $_SESSION['gender'] = $data['jantina'];
                $_SESSION['mp'] = $data['guru_matapelajaran'];
                $_SESSION['nokp'] = $data['nokp'];
                $_SESSION['aras'] = $data['aras'];
                session_write_close();
                if($data['aras'] === 'ADMIN') {
                    header("Location: main_page_admin.php");
                }
                else {
                    header("Location: main_page.php");
                }
            }
            else {
                echo "<script>alert('Maklumat Salah, Sila Cuba Lagi.');window.location='index.php';</script>";
            }
        }

        /*
        to check and display today's avaliable program that is
        matching the current date and will be display at the
        main page(both user and admin)
        */
        function todaysProgram($DB) { // procedure function
            $curDate = date("Y-m-d");
            $result = mysqli_query($DB, "SELECT * FROM program WHERE tarikh='$curDate'");

            if(mysqli_num_rows($result) > 0) {
                echo "<h2>Program Hari Ini</h2>";
                echo "<tr><th>Kod Rujukan</th>";
                echo "<th>Nama Program</th>";
                echo "<th>Tempat</th>";
                echo "<th>Jam Bermula</th>";
                echo "<th>Jam Tamat</th>";
                echo "<th>Maklumat</th></tr>";
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>".$data['kodProgram']."</td>";
                    echo "<td>".$data['nama_program']."</td>";
                    echo "<td>".$data['tempat']."</td>";
                    echo "<td>".$this -> timeFormatChange($data['masa_mula'], 'NORMAL')."</td>";
                    echo "<td>".$this -> timeFormatChange($data['masa_tamat'], 'NORMAL')."</td>";
                    echo "<td>".$data['maklumat']."</td></tr>";
                }
            }
            else {
                echo "<h2>Tiada Program Hari Ini</h2>";
            }
        }

        // to list avaliable row in 'murid' table based on what class
        function murid($DB, $v, $vv) { // procedure function
            if(empty($v)) {
                $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv'");
                if(mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor IC</th>";
                    echo "<th>Nama Murid</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Kelas</th></tr>";
                    while($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$data['noic']."</td>";
                        echo "<td>".$data['nama']."</td>";
                        echo "<td>".$data['jantina']."</td>";
                        echo "<td>".$data['kelas']."</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Murid Yang Menyertai</h1></div>";
                }
            }
            else {
                $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv' AND nama LIKE '$v%'");
                if(mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor IC</th>";
                    echo "<th>Nama Murid</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Kelas</th></tr>";
                    while($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$data['noic']."</td>";
                        echo "<td>".$data['nama']."</td>";
                        echo "<td>".$data['jantina']."</td>";
                        echo "<td>".$data['kelas']."</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Nama Tidak Dijumpai</h1></div>";
                }
            }
        }

        /* 
        same as the previous function 'function murid()' but for guru
        but will list both admin and user(guru)
        */
        function guru($DB, $v) { // procedure function
            if(empty($v)) {
                $result = mysqli_query($DB, "SELECT * FROM guru");
                if(mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor KP</th>";
                    echo "<th>Nama Guru</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Guru Matapelajaran</th></tr>";
                    while($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$data['nokp']."</td>";
                        echo "<td>".$data['nama_guru']."</td>";
                        echo "<td>".$data['jantina']."</td>";
                        echo "<td>".$data['guru_matapelajaran']."</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Guru Yang Terlibat</h1></div>";
                }
            }
            else {
                $result = mysqli_query($DB, "SELECT * FROM guru WHERE nama_guru LIKE '$v%'");
                if(mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor KP</th>";
                    echo "<th>Nama Guru</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Guru Matapelajaran</th></tr>";
                    while($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$data['nokp']."</td>";
                        echo "<td>".$data['nama_guru']."</td>";
                        echo "<td>".$data['jantina']."</td>";
                        echo "<td>".$data['guru_matapelajaran']."</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Nama Tidak Dijumpai</h1></div>";
                }
            }
        }

        // listing every program that ever anounced by admin
        function program($DB, $a, $s) { // procedure function
            if($s) {
                if(!empty($a['searchNama']) || !empty($a['date'])) {
                    $namaProg = $a['searchNama'];
                    $date = $a['date'];
                    $result = mysqli_query($DB, "SELECT * FROM program WHERE nama_program LIKE '$namaProg%' AND tarikh LIKE '$date%'");
    
                    if(mysqli_num_rows($result) > 0) {
                        echo "<tr><th>Kod Program</th>";
                        echo "<th>Nama Program</th>";
                        echo "<th>Tempat</th>";
                        echo "<th>Tarikh</th>";
                        echo "<th>Jam Bermula</th>";
                        echo "<th>Jam Tamat</th>";
                        echo "<th>Cikgu Yang Mengajar</th>";
                        echo "<th>Maklumat</th>";
                        echo "<th>Pilih</th></tr>";
                        while($data = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$data['kodProgram']."</td>";
                            echo "<td>".$data['nama_program']."</td>";
                            echo "<td>".$data['tempat']."</td>";
                            echo "<td>".$data['tarikh']."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_mula'], 'NORMAL')."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_tamat'], 'NORMAL')."</td>";
                            echo "<td>".$this -> nokp2guru($DB, $data['nokp'])."</td>";
                            echo "<td>".$data['maklumat']."</td>";
                            echo "<td><input type=\"checkbox\" value=\"".$data['kodProgram']."\"></td></tr>";
                        }
                    }
                    else {
                        echo "<div><img alt=\"Tidak Sepadan\" src=\"style/image/not-found-students.png\">";
                        echo "<h1>Tiada Program Yang Sepadan Dengan Carian</h1></div>";
                    }
                }
                else {
                    $result = mysqli_query($DB, "SELECT * FROM program");
                    if(mysqli_num_rows($result) > 0) {
                        echo "<tr><th>Kod Program</th>";
                        echo "<th>Nama Program</th>";
                        echo "<th>Tempat</th>";
                        echo "<th>Tarikh</th>";
                        echo "<th>Jam Bermula</th>";
                        echo "<th>Jam Tamat</th>";
                        echo "<th>Cikgu Yang Mengajar</th>";
                        echo "<th>Maklumat</th>";
                        echo "<th>Pilih</th></tr>";
                        while($data = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$data['kodProgram']."</td>";
                            echo "<td>".$data['nama_program']."</td>";
                            echo "<td>".$data['tempat']."</td>";
                            echo "<td>".$data['tarikh']."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_mula'], 'NORMAL')."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_tamat'], 'NORMAL')."</td>";
                            echo "<td>".$this -> nokp2guru($DB, $data['nokp'])."</td>";
                            echo "<td>".$data['maklumat']."</td>";
                            echo "<td><input type=\"checkbox\" value=\"".$data['kodProgram']."\"></td></tr>";
                        }
                    }
                    else {
                        echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                        echo "<h1>Tiada Program Dalam Rekod Pangkalan Data</h1></div>";
                    }
                }
            }
            else {
                if(!empty($a['searchNama']) || !empty($a['date'])) {
                    $namaProg = $a['searchNama'];
                    $date = $a['date'];
                    $result = mysqli_query($DB, "SELECT * FROM program WHERE nama_program LIKE '$namaProg%' AND tarikh LIKE '$date%'");
    
                    if(mysqli_num_rows($result) > 0) {
                        echo "<tr><th>Kod Program</th>";
                        echo "<th>Nama Program</th>";
                        echo "<th>Tempat</th>";
                        echo "<th>Tarikh</th>";
                        echo "<th>Jam Bermula</th>";
                        echo "<th>Jam Tamat</th>";
                        echo "<th>Cikgu Yang Mengajar</th>";
                        echo "<th>Maklumat</th></tr>";
                        while($data = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$data['kodProgram']."</td>";
                            echo "<td>".$data['nama_program']."</td>";
                            echo "<td>".$data['tempat']."</td>";
                            echo "<td>".$data['tarikh']."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_mula'], 'NORMAL')."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_tamat'], 'NORMAL')."</td>";
                            echo "<td>".$this -> nokp2guru($DB, $data['nokp'])."</td>";
                            echo "<td>".$data['maklumat']."</td></tr>";
                        }
                    }
                    else {
                        echo "<div><img alt=\"Tidak Sepadan\" src=\"style/image/not-found-students.png\">";
                        echo "<h1>Tiada Program Yang Sepadan Dengan Carian</h1></div>";
                    }
                }
                else {
                    $result = mysqli_query($DB, "SELECT * FROM program");
                    if(mysqli_num_rows($result) > 0) {
                        echo "<tr><th>Kod Program</th>";
                        echo "<th>Nama Program</th>";
                        echo "<th>Tempat</th>";
                        echo "<th>Tarikh</th>";
                        echo "<th>Jam Bermula</th>";
                        echo "<th>Jam Tamat</th>";
                        echo "<th>Cikgu Yang Mengajar</th>";
                        echo "<th>Maklumat</th></tr>";
                        while($data = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$data['kodProgram']."</td>";
                            echo "<td>".$data['nama_program']."</td>";
                            echo "<td>".$data['tempat']."</td>";
                            echo "<td>".$data['tarikh']."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_mula'], 'NORMAL')."</td>";
                            echo "<td>".$this -> timeFormatChange($data['masa_tamat'], 'NORMAL')."</td>";
                            echo "<td>".$this -> nokp2guru($DB, $data['nokp'])."</td>";
                            echo "<td>".$data['maklumat']."</td></tr>";
                        }
                    }
                    else {
                        echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                        echo "<h1>Tiada Program Dalam Rekod Pangkalan Data</h1></div>";
                    }
                }
            }
        }

        /*
        for record.php,
        very complex yet difficult to get an idea to get this query
        to work greatly
        works by comparing current time with start_time and
        end_time attributes with logic like this:
        currentTime is greater than or equal to start_time 
        and currentTime is less than end_time
        */
        function checkProgram($DB, $v) { // procedure function
            $query = "SELECT * 
            FROM program 
            WHERE tarikh = CURDATE() 
            AND (
            (TIME_FORMAT(CURTIME(), '%H:%i') >= TIME_FORMAT(masa_mula, '%H:%i') AND TIME_FORMAT(CURTIME(), '%H') < TIME_FORMAT(masa_tamat, '%H')) OR 
            (TIME_FORMAT(masa_mula, '%H:%i') > TIME_FORMAT(masa_tamat, '%H:%i') AND (TIME_FORMAT(CURTIME(), '%H') >= TIME_FORMAT(masa_mula, '%H') OR 
            TIME_FORMAT(CURTIME(), '%H:%i') < TIME_FORMAT(masa_tamat, '%H:%m')))
            ) ORDER BY masa_mula DESC";

            $result = mysqli_query($DB, $query); // fix this 🙏🙏
            if(mysqli_num_rows($result) > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    return [
                        'nama_program'=>$data['nama_program'],
                        'kodProgram'=>$data['kodProgram']
                    ];
                }
            }
            return false;
        }

        /*
        displays a form with a list of students that can be
        checked by the teacher by using a checkbox
        */
        function recordForm($DB, $v, $vv) { // procedure function
            $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv'");

            if(mysqli_num_rows($result) > 0) {
                echo "<table><tr><th>Nama Murid</th>";
                echo "<th>Nombor IC</th>";
                echo "<th>Jantina</th>";
                echo "<th>Kelas</th>";
                echo "<th>Pilih</th></tr>";
                $kodProgram = $this -> checkProgram($DB, $v);
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>".$data['nama']."</td>";
                    echo "<td>".$data['noic']."</td>";
                    echo "<td>".$data['jantina']."</td>";
                    echo "<td>".$data['kelas']."</td>";
                    echo "<td><input type=\"checkbox\" name=\"noic[]\" value=\"".$data['noic']."\"></td></tr>";
                }
                echo "</table><button type=\"submit\" name=\"submit\">Rekod</button>";
            }
            else {
                echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                echo "<h1>Perekodan Tidak Boleh Dilakukan, Tiada Murid Yang Menyertai</h1></div>";
            }
        }
    }