<?php
/*
    PLEASE DO NOT RELOCATE THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING.
    THIS FILE IS THE HEART OF ALL FUNCTIONS USED BY EVERY PHP CODE INSIDE THIS SYSTEM.

    LOCATE ALL USABLE FUNCTIONS HERE FOR FUNCTION SCALABILITY.

    Using Object-Oriented Programming to save time on coding(BEFORE SPM!!!).

    RULE OF THUMB: always encapsulate variables with quotes `'` when writing a query to prevent errors.
*/
class globalFunc {
    const kelas = [
        "Arif",
        "Bestari",
        "Cermelang",
        "Dedikasi",
        "Efisien",
        "Fikrah",
        "Gemilang",
        "Harmoni",
        "Iltizam"
    ];
    // generate random 7 letters code with some prefix you can add
    function randCode($pf) { // return function
        $randBytes = random_bytes(3); // generate 3 bytes of random code
        $convert2Hex = bin2hex($randBytes); // convert it to hexadecimal which becomes 6 character
        return $pf . $convert2Hex; // combine it with the given prefix from given argument when returning values
    }

    // find guru's name by their nokp
    function nokp2guru($DB, $v) { // return function
        $result = mysqli_query($DB, "SELECT nama_guru FROM guru WHERE nokp='$v'");
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
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
                $format12 = $datetime->format('H:i:s');
                return $format12;
            case 'NORMAL':
                $datetime = DateTime::createFromFormat('H:i:s', $t);
                $format12 = $datetime->format('g:i A');
                return $format12;
        }
        $datetime = DateTime::createFromFormat('H:i:s', $t);
        $format12 = $datetime->format('g:i A');
        return $format12;
    }

    /*
        change date format from DD-MM-YYYY which is mysql preferred format
        to YYYY-MM-DD date format that we commonly use
        */
    function dateFormatChange($t, $s) { // return function
        switch ($s) {
            case 'REVERSE':
                $datetime = DateTime::createFromFormat('d-m-Y', $t);
                $formatDMY = $datetime->format('Y-m-d');
                return $formatDMY;
            case 'NORMAL':
                $datetime = DateTime::createFromFormat('Y-m-d', $t);
                $formatDMY = $datetime->format("d-m-Y");
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

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['username'] = $data['nama_guru'];
            $_SESSION['gender'] = $data['jantina'];
            $_SESSION['mp'] = $data['guru_matapelajaran'];
            $_SESSION['nokp'] = $data['nokp'];
            $_SESSION['aras'] = $data['aras'];
            session_write_close();
            mysqli_stmt_close($stmt);
            if ($data['aras'] === 'ADMIN') {
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
    function todaysProgram($DB, $s) { // procedure function
        // $s argument is for switch
        $curDate = date("Y-m-d");
        if($s) {
            $result = mysqli_query($DB, "SELECT * FROM program");
        }
        else {
            $result = mysqli_query($DB, "SELECT * FROM program WHERE tarikh='$curDate'");
        }
        

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Program Hari Ini</h2>";
            echo "<tr><th>Kod Rujukan</th>";
            echo "<th>Nama Program</th>";
            echo "<th>Tempat</th>";
            echo "<th>Jam Bermula</th>";
            echo "<th>Jam Tamat</th>";
            echo "<th>Maklumat</th></tr>";
            while ($data = mysqli_fetch_assoc($result)) {
                // if true, then the 'kodProgram' will be avaliable to be click
                if ($s) {
                    echo "<tr><td><a href=\"#\" onclick=\"callFunc.seekAttendance('".$data['kodProgram']."')\">" . $data['kodProgram'] . "</a></td>";
                }
                else {
                    echo "<tr><td>" . $data['kodProgram'] . "</td>";
                }
                echo "<td>" . $data['nama_program'] . "</td>";
                echo "<td>" . $data['tempat'] . "</td>";
                echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                echo "<td>" . $data['maklumat'] . "</td></tr>";
            }
        }
        else {
            echo "<h2>Tiada Program Hari Ini</h2>";
        }
    }

    // to list avaliable row in 'murid' table based on what class
    function murid($DB, $v, $vv, $s) { // procedure function
        // search query passed through the second argument, $v
        // kelas data passed through the third argument, $vv
        // $s is for function switch
        if($s === 'NOIC') {
            $result = mysqli_query($DB, "SELECT noic FROM murid WHERE kelas = '$vv'");
            if(mysqli_num_rows($result) > 0) {
                while($data=mysqli_fetch_assoc($result)) {
                    $array[] = $data['noic'];
                }
            }
            else {
                return false;
            }
            // shorthand if else, return false if array is empty
            return !empty($array) ? $array:false;
        }
        else {
            if (empty($v)) { // if searchbox is empty
                $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv'");

                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor IC</th>";
                    echo "<th>Nama Murid</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Kelas</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['noic'] . "</td>";
                        echo "<td>" . $data['nama'] . "</td>";
                        echo "<td>" . $data['jantina'] . "</td>";
                        echo "<td>" . $data['kelas'] . "</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Murid Yang Menyertai</h1></div>";
                }
            }
            else {
                $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv' AND nama LIKE '$v%'");
                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor IC</th>";
                    echo "<th>Nama Murid</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Kelas</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['noic'] . "</td>";
                        echo "<td>" . $data['nama'] . "</td>";
                        echo "<td>" . $data['jantina'] . "</td>";
                        echo "<td>" . $data['kelas'] . "</td></tr>";
                    }
                }
                else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Nama Tidak Dijumpai</h1></div>";
                }
            }
        }
    }

    /* 
        same as the previous function 'function murid()' but for guru, 
        will list both admin and user(guru)
        */
    function guru($DB, $v, $s) { // procedure/return function

        // to return an array 
        if($s === 'LIST') {
            $result = mysqli_query($DB, "SELECT * FROM GURU");

            if(mysqli_num_rows($result) > 0) {
                while($data=mysqli_fetch_assoc($result)) {
                    if($data['aras'] === 'ADMIN') {
                        continue;
                    }
                    $nokp[] = $data['nokp'];
                    $nama[] = $data['nama_guru'];
                }

                return [
                    'nokp' => $nokp,
                    'nama_guru' => $nama
                ];
            }
        }
        else {
            if (empty($v)) {
                $result = mysqli_query($DB, "SELECT * FROM guru");
                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor KP</th>";
                    echo "<th>Nama Guru</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Guru Matapelajaran</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['nokp'] . "</td>";
                        echo "<td>" . $data['nama_guru'] . "</td>";
                        echo "<td>" . $data['jantina'] . "</td>";
                        echo "<td>" . $data['guru_matapelajaran'] . "</td></tr>";
                    }
                } else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Guru Yang Terlibat</h1></div>";
                }
            } else {
                $result = mysqli_query($DB, "SELECT * FROM guru WHERE nama_guru LIKE '$v%'");
                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Nombor KP</th>";
                    echo "<th>Nama Guru</th>";
                    echo "<th>Jantina</th>";
                    echo "<th>Guru Matapelajaran</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['nokp'] . "</td>";
                        echo "<td>" . $data['nama_guru'] . "</td>";
                        echo "<td>" . $data['jantina'] . "</td>";
                        echo "<td>" . $data['guru_matapelajaran'] . "</td></tr>";
                    }
                } else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Nama Tidak Dijumpai</h1></div>";
                }
            }
        }
    }

    // listing every program that ever anounced by admin
    function program($DB, $a, $s) { // procedure function
        // $s(the third argument) will act like a switch
        // if $s true, a checkbox option will be include when displaying form(for admin)
        if ($s) {
            // check if the search option are empty
            if (!empty($a['searchNama']) || !empty($a['date'])) {
                $namaProg = $a['searchNama'];
                $date = $a['date'];
                $result = mysqli_query($DB, "SELECT * FROM program WHERE nama_program LIKE '$namaProg%' AND tarikh LIKE '$date%'");

                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Kod Program</th>";
                    echo "<th>Nama Program</th>";
                    echo "<th>Tempat</th>";
                    echo "<th>Tarikh</th>";
                    echo "<th>Jam Bermula</th>";
                    echo "<th>Jam Tamat</th>";
                    echo "<th>Cikgu Yang Mengajar</th>";
                    echo "<th>Maklumat</th>";
                    echo "<th>Pilih</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['kodProgram'] . "</td>";
                        echo "<td>" . $data['nama_program'] . "</td>";
                        echo "<td>" . $data['tempat'] . "</td>";
                        echo "<td>" . $data['tarikh'] . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                        echo "<td>" . $data['maklumat'] . "</td>";
                        echo "<td><input type=\"checkbox\" value=\"" . $data['kodProgram'] . "\"></td></tr>";
                    }
                } else {
                    echo "<div><img alt=\"Tidak Sepadan\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Program Yang Sepadan Dengan Carian</h1></div>";
                }
            } else {
                $result = mysqli_query($DB, "SELECT * FROM program");
                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Kod Program</th>";
                    echo "<th>Nama Program</th>";
                    echo "<th>Tempat</th>";
                    echo "<th>Tarikh</th>";
                    echo "<th>Jam Bermula</th>";
                    echo "<th>Jam Tamat</th>";
                    echo "<th>Cikgu Yang Mengajar</th>";
                    echo "<th>Maklumat</th>";
                    echo "<th>Pilih</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['kodProgram'] . "</td>";
                        echo "<td>" . $data['nama_program'] . "</td>";
                        echo "<td>" . $data['tempat'] . "</td>";
                        echo "<td>" . $data['tarikh'] . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                        echo "<td>" . $data['maklumat'] . "</td>";
                        echo "<td><input type=\"checkbox\" value=\"" . $data['kodProgram'] . "\"></td></tr>";
                    }
                } else {
                    echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Program Dalam Rekod Pangkalan Data</h1></div>";
                }
            }
        } else {
            if (!empty($a['searchNama']) || !empty($a['date'])) {
                $namaProg = $a['searchNama'];
                $date = $a['date'];
                $result = mysqli_query($DB, "SELECT * FROM program WHERE nama_program LIKE '$namaProg%' AND tarikh LIKE '$date%'");

                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Kod Program</th>";
                    echo "<th>Nama Program</th>";
                    echo "<th>Tempat</th>";
                    echo "<th>Tarikh</th>";
                    echo "<th>Jam Bermula</th>";
                    echo "<th>Jam Tamat</th>";
                    echo "<th>Cikgu Yang Mengajar</th>";
                    echo "<th>Maklumat</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['kodProgram'] . "</td>";
                        echo "<td>" . $data['nama_program'] . "</td>";
                        echo "<td>" . $data['tempat'] . "</td>";
                        echo "<td>" . $data['tarikh'] . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                        echo "<td>" . $data['maklumat'] . "</td></tr>";
                    }
                } else {
                    echo "<div><img alt=\"Tidak Sepadan\" src=\"style/image/not-found-students.png\">";
                    echo "<h1>Tiada Program Yang Sepadan Dengan Carian</h1></div>";
                }
            } else {
                $result = mysqli_query($DB, "SELECT * FROM program");
                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Kod Program</th>";
                    echo "<th>Nama Program</th>";
                    echo "<th>Tempat</th>";
                    echo "<th>Tarikh</th>";
                    echo "<th>Jam Bermula</th>";
                    echo "<th>Jam Tamat</th>";
                    echo "<th>Cikgu Yang Mengajar</th>";
                    echo "<th>Maklumat</th></tr>";
                    while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $data['kodProgram'] . "</td>";
                        echo "<td>" . $data['nama_program'] . "</td>";
                        echo "<td>" . $data['tempat'] . "</td>";
                        echo "<td>" . $data['tarikh'] . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                        echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                        echo "<td>" . $data['maklumat'] . "</td></tr>";
                    }
                } else {
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

        $result = mysqli_query($DB, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                if ($data['nokp'] === $v) {
                    // return array
                    return [
                        'nama_program' => $data['nama_program'],
                        'kodProgram' => $data['kodProgram']
                    ];
                }
            }
        }
        return false;
    }

    /*
        displays a form with a list of students that can be
        checked by the teacher by using a checkbox
        */
    function recordForm($DB, $v, $vv) { // return/procedure function
        // nokp data or array passed through the second argument, $va
        // kelas data passed through the third argument, $vv. Give NULL if not required
        // $s is for function switch
        $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv'");

        if (mysqli_num_rows($result) > 0) {
            echo "<table><tr><th>Nama Murid</th>";
            echo "<th>Nombor IC</th>";
            echo "<th>Jantina</th>";
            echo "<th>Kelas</th>";
            echo "<th>Pilih</th></tr>";
            $kodProgram = $this->checkProgram($DB, $v);
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $data['nama'] . "</td>";
                echo "<td>" . $data['noic'] . "</td>";
                echo "<td>" . $data['jantina'] . "</td>";
                echo "<td>" . $data['kelas'] . "</td>";
                echo "<td><input type=\"checkbox\" name=\"noic[]\" value=\"" . $data['noic'] . "\"></td></tr>";
            }
            echo "</table><button type=\"submit\" name=\"submit\">Rekod</button>";
            echo "<p id=\"important_msg\"><b>NOTE</b>: Perekodan kehadiran hanya boleh dilakukan <b>SEKALI</b> sahaja untuk setiap program. Sila semak semula sebelum merekod.</p>";
        }
        else {
            echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
            echo "<h1>Perekodan Tidak Boleh Dilakukan, Tiada Murid Yang Menyertai</h1></div>";
        }
    }

    // to save record, use once only for each program
    function saverecord($DB, $nokp, $noic) { // return function
        // Generate 7 letter code with 'p' as a prefix at front
        $randC = $this->randCode("k");

        // Get program code from checkProgram function
        $program = $this->checkProgram($DB, $nokp)['kodProgram'];

        // Check if program is valid
        if ($program === false) {
            return false;
        }

        // Prepare the SQL statement
        $stmt = $DB->prepare("INSERT INTO kehadiran(kodKehadiran, kodProgram, noic, masa_direkod) VALUES (?, ?, ?, CURTIME())");
        $stmt->bind_param("sss", $randC, $program, $noic);

        // Execute the statement and check if successful
        if ($stmt->execute()) {
            $stmt -> close;
            return [
                'noic' => $noic,
                'kodKehadiran' => $randC,
                'masa_direkod' => date("H:i:s")
            ];
        }
        else {
            return false;
        }
    }

    // only gives you a list of student's data that has attend on this(refer to given kodKehadiran) program
    // student(s) who not attend will not included inside the array
    function findStudent($DB, $v, $vv) { // return function
        // Prepare the kehadiran query
        $stmtKehadiran = $DB->prepare("SELECT noic, masa_direkod FROM kehadiran WHERE kodProgram = ?");
        $stmtKehadiran->bind_param("s", $v);
        $stmtKehadiran->execute();
        $kehadiranResult = $stmtKehadiran->get_result();
    
        $students = [];
    
        if ($kehadiranResult->num_rows > 0) {
            // For each attendance record, get the student details
            while ($valKehadiran = $kehadiranResult->fetch_assoc()) {
                $noic = $valKehadiran['noic'];
    
                $stmtMurid = $DB->prepare("SELECT * FROM murid WHERE kelas = ? AND noic = ?");
                $stmtMurid->bind_param("ss", $vv, $noic);
                $stmtMurid->execute();
                $muridResult = $stmtMurid->get_result();
    
                if ($muridResult->num_rows > 0) {
                    while ($valMurid = $muridResult->fetch_assoc()) {
                        $students[] = [
                            'noic' => $valMurid['noic'],
                            'nama' => $valMurid['nama'],
                            'jantina' => $valMurid['jantina'],
                            'masa_rekod' => $valKehadiran['masa_direkod']
                        ];
                    }
                }
            }
        } else {
            return false;
        }
        mysqli_stmt_close($stmtMurid);
        mysqli_stmt_close($stmtKehadiran);
        return $students;
    }    

    // used to check if the selected program is already recorded on the 'kehadiran' table(must view kelas also)
    function checkExistKehadiran($DB, $v, $vv) { // return function
        // kodKehadiran value is passed through the second argument, $v
        // kelas value is passed through the third argument, $vv
        $array[] = $this->murid($DB, NULL, $vv, 'NOIC');
        foreach($array as $x) {
            $result = mysqli_query($DB, "SELECT kodProgram FROM kehadiran WHERE kodProgram = '$v' AND noic = '".$x[0]."'");

            if(mysqli_num_rows($result) === 0) {
                return false;
            }
        }
        return true;
    }

    // to add new murid, program or guru into database
    function addToDB($DB, $a, $s) {
        if($s === 'PROGRAM') {
            $randCode = $this -> randCode('p');
            $stmt = $DB -> prepare("INSERT INTO program (kodProgram, nama_program, maklumat, tempat, tarikh, masa_mula, masa_tamat, nokp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt -> bind_param(
                "ssssssss",
                $randCode,
                $a['nama_program'],
                $a['maklumat'],
                $a['tempat'],
                $a['tarikh'],
                $a['masa_mula'],
                $a['masa_tamat'],
                $a['nokp']
            );
            if($stmt->execute()) {
                $stmt -> close;
                return true;
            }
            else {
                return false;
            }
        }
        elseif($s === 'MURID') {
            $stmt = $DB -> prepare("INSERT INTO murid (noic, nama, jantina, kelas) VALUES (?, ?, ?, ?)");
            $stmt -> bind_param(
                "ssss", 
                $a['noic'], 
                $a['nama'], 
                $a['jantina'], 
                $a['kelas']
            );
            if($stmt->execute()) {
                $stmt -> close;
                return true;
            }
            else {
                return false;
            }
        }
        elseif($s === 'GURU') {
            $stmt = $DB -> prepare("INSERT INTO guru (nokp, katalaluan, nama_guru, jantina, guru_matapelajaran, aras) VALUES (?, ?, ?, ?, ?, 'PENGGUNA')");
            $stmt -> bind_param(
                "sssss", 
                $a['nokp'], 
                $a['katalaluan'], 
                $a['nama_guru'], 
                $a['jantina'],
                $a['guru_matapelajaran']
            );
            if($stmt->execute()) {
                $stmt -> close;
                return true;
            }
            else {
                return false;
            }
        }
    }
}
