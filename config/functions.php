<?php
/*
    PLEASE DO NOT RELOCATE THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING.
    THIS FILE IS THE HEART OF ALL FUNCTIONS USED BY EVERY PHP CODE INSIDE THIS SYSTEM.

    LOCATE ALL USABLE FUNCTIONS HERE FOR FUNCTION SCALABILITY.

    Using Object-Oriented Programming to save time on coding(BEFORE SPM!!!).

    RULE OF THUMB: always encapsulate variables with quotes `'` when writing a query to prevent errors.
*/

// import PHP files here, just make sure to label the use of each file

//  PhpSpreadSheet library, downloaded using Composer PHP library installer
// NOTE: import path will be affected by the file(who currently using functions.php) location
require "library/php_library/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;

// single class here, widely used on every PHP file inside this directory
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
    const matapelajaran = [
        // core subject
        "Inggeris",
        "Melayu",
        "Matematik",
        "Sains",
        "Sejarah",

        // elective subject
        "Pendidikan Moral",
        "Pendidikan Islam",
        "Cina",
        "Iban",
        "Ekonomi",
        "Perniagaan",
        "Reka Cipta",
        "PSV",
        "Sains Komputer",
        "Sastera",
        "Biologi",
        "Kimia",
        "Fizik",
        "Matematik Tambahan"
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
                echo "<script>alert('Selamat Datang Admin'); window.location = 'main_page_admin.php';</script>";
            }
            else {
                echo "<script>alert('Selamat Datang ".$data['nama_guru']."'); window.location = 'main_page.php';</script>";
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
        
        if(mysqli_num_rows($result) > 0) {
            echo "<h2>Program Hari Ini</h2>";
            echo "<tr><th>Kod Rujukan</th>";
            echo "<th>Nama Program</th>";
            echo "<th>Tempat</th>";
            echo "<th>Tarikh</th>";
            echo "<th>Jam Bermula</th>";
            echo "<th>Jam Tamat</th>";
            echo "<th>Maklumat</th></tr>";
            while($data = mysqli_fetch_assoc($result)) {
                // if true, then the 'kodProgram' will be avaliable to be click
                if($s) {
                    echo "<tr><td><a href=\"#\" onclick=\"callFunc.seekAttendance('".$data['kodProgram']."', '".$data['tarikh']."')\">" . $data['kodProgram'] . "</a></td>";
                }
                else {
                    echo "<tr><td>" . $data['kodProgram'] . "</td>";
                }
                echo "<td>" . $data['nama_program'] . "</td>";
                echo "<td>" . $data['tempat'] . "</td>";
                echo "<td>" . $this->dateFormatChange($data['tarikh'], 'NORMAL') . "</td>";
                echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                echo "<td>" . $data['maklumat'] . "</td></tr>";
            }
        }
        // if on attendance.php, display a different word, same to main_page.php
        else {
            if($s) {
                echo "<h2>Tiada Program Yang Diwujudkan</h2>";
            }
            else {
                echo "<h2>Tiada Program Hari Ini</h2>";
            }
        }
    }

    // to list avaliable row in 'murid' table based on what class
    function murid($DB, $v, $vv, $s) {
        // using if-elseif statement cause some bugs, the safe approach is by using if statement only

        // to find student's noic by searching their name
        if($s === 'NOIC') {
            $result = mysqli_query($DB, "SELECT noic FROM murid WHERE kelas = '$vv'");
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    $array[] = $data['noic'];
                }
            }
            else {
                return false;
            }
            return !empty($array) ? $array : false;
        }

        // to delete Murid from kehadiran's row
        elseif($s === 'DELETE_KEHADIRAN'){
            // delete row base on selected noic and kodProgram
            $deleteRow = $DB -> prepare("DELETE FROM kehadiran WHERE noic = ? AND kodProgram = ?");
            $deleteRow -> bind_param("ss", $v, $vv);

            if($deleteRow -> execute()) {
                return true;
            }
            else {
                return false;
            }
        }

        // to display Murid's table
        elseif($s === 'MURID') {
            $query = !empty($v) ? 
            "SELECT * FROM murid WHERE nama LIKE '$v%' ORDER BY kelas ASC" : // select this if search query is not empty
            "SELECT * FROM murid  ORDER BY kelas ASC"; // select this if search query is empty
    
            $result = mysqli_query($DB, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<tr><th>Nombor IC</th>";
                echo "<th>Nama Murid</th>";
                echo "<th>Jantina</th>";
                echo "<th>Kelas</th></tr>";
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td><a href=\"edit_murid_process.php\" onclick=\"callFunc.sendCookie('nama', '".$data['nama']."'); callFunc.sendCookie('noic', '".$data['noic']."', 'em');\">" . $data['noic'] . "</td>";
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
            $query = empty($v) ? "SELECT * FROM murid WHERE kelas='$vv'" : "SELECT * FROM murid WHERE kelas='$vv' AND nama LIKE '$v%'";
            $result = mysqli_query($DB, $query);
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
                echo "<h1>" . (empty($v) ? "Tiada Murid Yang Menyertai" : "Nama Tidak Dijumpai") . "</h1></div>";
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
                    $matapelajaran[] = $data['guru_matapelajaran'];
                }

                return [
                    'nokp' => $nokp,
                    'nama_guru' => $nama,
                    'guru_matapelajaran' => $matapelajaran
                ];
            }
        }
        elseif($s === 'GURU') {
            if(!empty($v) || isset($v)) {
                $result = mysqli_query($DB, "SELECT * FROM guru WHERE nama_guru LIKE '$v%' ORDER BY nama_guru ASC");
            }
            else {
                $result = mysqli_query($DB, "SELECT * FROM guru ORDER BY nama_guru ASC");
            }
            
            if(mysqli_num_rows($result) > 0) {
                echo "<tr><th>Nombor KP</th>";
                echo "<th>Nama Guru</th>";
                echo "<th>Jantina</th>";
                echo "<th>Guru Matapelajaran</th></tr>";
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td><a href=\"edit_guru_process.php\" onclick=\"callFunc.sendCookie('nama_guru', '".$data['nama_guru']."'); callFunc.sendCookie('nokp', '".$data['nokp']."', 'eg');\">" . $data['nokp'] . "</td>";
                    echo "<td>" . $data['nama_guru'] . "</td>";
                    echo "<td>" . $data['jantina'] . "</td>";
                    echo "<td>" . $data['guru_matapelajaran'] . "</td></tr>";
                }
            } else {
                echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                echo "<h1>Tiada Guru Yang Terlibat</h1></div>";
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
        // check if the search option are empty
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
                // displays `Pilih` column header if current user is admin
                if($s) {
                    echo "<th>Pilih</th></tr>";    
                }
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $data['kodProgram'] . "</td>";
                    echo "<td>" . $data['nama_program'] . "</td>";
                    echo "<td>" . $data['tempat'] . "</td>";
                    echo "<td>" . $this->dateFormatChange($data['tarikh'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                    echo "<td>" . $data['maklumat'] . "</td>";
                    // set input element with it's own value related to it's row
                    if($s) {
                        echo "<td><input name=\"kodProgram[]\" type=\"checkbox\" value=\"" . $data['kodProgram'] . "\"></td></tr>";
                    }
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
                if($s) {
                    echo "<th>Pilih</th></tr>";
                }
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $data['kodProgram'] . "</td>";
                    echo "<td>" . $data['nama_program'] . "</td>";
                    echo "<td>" . $data['tempat'] . "</td>";
                    echo "<td>" . $this->dateFormatChange($data['tarikh'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->timeFormatChange($data['masa_mula'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->timeFormatChange($data['masa_tamat'], 'NORMAL') . "</td>";
                    echo "<td>" . $this->nokp2guru($DB, $data['nokp']) . "</td>";
                    echo "<td>" . $data['maklumat'] . "</td>";
                    if($s) {
                        echo "<td><input name=\"kodProgram[]\" type=\"checkbox\" value=\"" . $data['kodProgram'] . "\"></td></tr>";
                    }
                }
            }
            else {
                echo "<div id=\"text-styling\"><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                echo "<h1>Tiada Program Dalam Rekod Pangkalan Data</h1></div>";
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
        // only select program that avaliable on current time and date by checking if masa_mula and masa_tamat is in range of current time
        $query = "SELECT * 
            FROM program 
            WHERE tarikh = CURDATE() 
            AND (
            (TIME_FORMAT(CURTIME(), '%H:%i') >= TIME_FORMAT(masa_mula, '%H:%i') AND TIME_FORMAT(CURTIME(), '%H') < TIME_FORMAT(masa_tamat, '%H')) OR 
            (TIME_FORMAT(masa_mula, '%H:%i') > TIME_FORMAT(masa_tamat, '%H:%i') AND (TIME_FORMAT(CURTIME(), '%H') >= TIME_FORMAT(masa_mula, '%H') OR 
            TIME_FORMAT(CURTIME(), '%H:%i') < TIME_FORMAT(masa_tamat, '%H:%m')))
            ) ORDER BY masa_mula DESC";

        // execute query
        $result = mysqli_query($DB, $query);
        if(mysqli_num_rows($result) > 0) {
            // if avaliable...
            while($data = mysqli_fetch_assoc($result)) {
                // look for a program that is match the nokp for the login user
                if($data['nokp'] === $v) {
                    // return array
                    return [
                        // return nokp, nama_program and kodProgram that has user's nokp on it's row
                        'nama_program' => $data['nama_program'],
                        'kodProgram' => $data['kodProgram'],
                        'nokp' => $data['nokp']
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
        // nokp data or array passed through the second argument, $v
        // kelas data passed through the third argument, $vv. Give NULL if not require
        $result = mysqli_query($DB, "SELECT * FROM murid WHERE kelas='$vv'");

        if($this->checkProgram($DB, $v)['nokp'] === $v) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table><tr><th>Nama Murid</th>";
                echo "<th>Nombor IC</th>";
                echo "<th>Jantina</th>";
                echo "<th>Kelas</th>";
                echo "<th>Pilih</th></tr>";
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $data['nama'] . "</td>";
                    echo "<td>" . $data['noic'] . "</td>";
                    echo "<td>" . $data['jantina'] . "</td>";
                    echo "<td>" . $data['kelas'] . "</td>";
                    echo "<td><input type=\"checkbox\" name=\"noic[]\" value=\"" . $data['noic'] . "\"></td></tr>";
                }
                echo "</table><button type=\"submit\" name=\"submit\">Rekod</button>";
                echo "<p id=\"notice\"><b>PERHATIAN</b>: Selepas merekod kehadiran, rekod yang telah dilakukan tidak boleh diubah
                <br>tetapi boleh dilakukan semula jika rekod yang dilakukan telah <strong><u>DIKOSONGKAN</u></strong> tanpa
                <br>meninggalkan sekurang-kurangnya satu baris rekod.</p>";
                echo "<div class=\"seekAttendance\"><a href=\"main_page.php\">Menu Utama</a></div>";
            }
            else {
                echo "<div><img alt=\"Data Tidak Wujud\" src=\"style/image/not-found-students.png\">";
                echo "<h1>Perekodan Tidak Boleh Dilakukan, Tiada Murid Yang Menyertai</h1></div>";
            }
        }
        else {
            echo "<div><img alt=\"Bukan Guru Pengurus\" src=\"style/image/not-involved.png\">";
            echo "<h1>Anda tidak terlibat dengan pengurusan program ini</h1></div>";
        }
    }

    // to save record, use once only for each program
    function saverecord($DB, $nokp, $noic) { // return function
        // Generate 7 letter code with 'p' as a prefix at front
        $randC = "";
        // to check if this code is avaliable to use
        $checkRandC = true;
        // this code was added to add safety while inserting data to avoid violating data integrity
        while($checkRandC) {
            $randC = $this -> randCode("k");
            $MYSQL_checkRandC = mysqli_query($DB, "SELECT kodKehadiran FROM kehadiran WHERE kodKehadiran = '$randC'");

            // check if the query return a result of row
            if(mysqli_fetch_row($MYSQL_checkRandC)) {
                $randC = $this -> randCode("k");
            }
            else {
                // quit from checking
                $checkRandC = false;
            }
        }

        // Get program code from checkProgram function
        $program = $this -> checkProgram($DB, $nokp)['kodProgram'];

        // Check if program is valid
        if($program === false) {
            return false;
        }

        // Prepare the SQL statement
        $stmt = $DB -> prepare("INSERT INTO kehadiran (kodKehadiran, kodProgram, noic, masa_direkod) VALUES (?, ?, ?, CURTIME())");
        $stmt -> bind_param("sss", $randC, $program, $noic);

        // Execute the statement and check if successful
        if ($stmt -> execute()) {
            $stmt -> close();
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

    // check if user is eligible to edit Kehadiran record
    function checkDeletionEligibility($DB, $v, $vv) {
        // nokp is pass on the second argument, $v
        // kodProgram is pass on the second argument, $vv
        // check user egibility to delete record
        $checkRowDeletionEgibility = mysqli_query($DB, "SELECT * FROM program WHERE nokp = '$v' AND kodProgram = '$vv'");

        // check if user has any relation with selected program
        if($checkRowDeletionEgibility -> num_rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    // only gives you a list of student's data that has attend on this(refer to given kodKehadiran) program
    // student(s) who not attend will not included inside the array
    function findStudent($DB, $v, $vv) { // return function
        // kodKehadiran is pass on the second argument, $v
        // kelas is pass on the second argument, $vv

        // prepare the kehadiran query
        $stmtKehadiran = $DB -> prepare("SELECT noic, masa_direkod FROM kehadiran WHERE kodProgram = ?");
        $stmtKehadiran -> bind_param("s", $v);
        $stmtKehadiran -> execute();
        $kehadiranResult = $stmtKehadiran -> get_result();
    
        $students = [];
    
        if($kehadiranResult -> num_rows > 0) {
            // For each attendance record, get the student details
            while($valKehadiran = $kehadiranResult -> fetch_assoc()) {
                $noic = $valKehadiran['noic'];
    
                $stmtMurid = $DB -> prepare("SELECT * FROM murid WHERE kelas = ? AND noic = ?");
                $stmtMurid -> bind_param("ss", $vv, $noic);
                $stmtMurid -> execute();
                $muridResult = $stmtMurid -> get_result();
    
                if($muridResult -> num_rows > 0) {
                    while($valMurid = $muridResult -> fetch_assoc()) {
                        // return true on match_user_nokp if nokp given is match with the program's nokp column and vice versa
                        $students[] = [
                            'noic' => $valMurid['noic'],
                            'nama' => $valMurid['nama'],
                            'jantina' => $valMurid['jantina'],
                            'masa_rekod' => $valKehadiran['masa_direkod']
                        ];
                    }
                }
            }
        }
        else {
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

        // obtain the list of murid's noic by finding kelas name
        $array[] = $this->murid($DB, NULL, $vv, 'NOIC');
        foreach($array as $x) {
            $result = mysqli_query($DB, "SELECT kodProgram FROM kehadiran WHERE kodProgram = '$v' AND noic = '".$x[0]."'");

            if(mysqli_num_rows($result) === 0) {
                // false return will allow record.php to display form
                return false;
            }
        }
        // true return will tell the user that record has been done
        return true;
    }

    // to add or delete murid, program or guru into database
    function fromDB($DB, $a, $s) { // return function
        if ($s === 'PROGRAM') {
            $randCode = $this->randCode('p');
            $stmt = $DB->prepare("INSERT INTO program (kodProgram, nama_program, maklumat, tempat, tarikh, masa_mula, masa_tamat, nokp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
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
                $stmt->close(); // Fixed method call
                return true;
            }
            else {
                return false;
            }
        } 
        elseif($s === 'MURID') {
            $stmt = $DB->prepare("INSERT INTO murid (noic, nama, jantina, kelas) VALUES (?, ?, ?, ?)");
            $stmt->bind_param(
                "ssss",
                $a['noic'],
                $a['nama'],
                $a['jantina'],
                $a['kelas']
            );

            // Execute the statement
            if($stmt->execute()) {
                $stmt->close(); // Fixed method call
                return true;
            }
            else {
                return false;
            }
        }
        elseif($s === 'GURU') {
            $stmt = $DB->prepare("INSERT INTO guru (nokp, katalaluan, nama_guru, jantina, guru_matapelajaran, aras)
             VALUES (?, ?, ?, ?, ?, 'PENGGUNA')"); // set aras as PENGGUNA by default
            $stmt->bind_param(
                "sssss",
                $a['nokp'],
                $a['katalaluan'],
                $a['nama_guru'],
                $a['jantina'],
                $a['matapelajaran']
            );

            // Execute the statement
            if($stmt->execute()) {
                $stmt->close(); // Fixed method call
                return true;
            }
            else {
                return false;
            }
        }
        elseif($s === 'DELETE_PROGRAM') {
            // rows from kehadiran must be deleted first before deleting program inside program table
            // delete every related rows on kehadiran table, then delete program
            $deleteRows = mysqli_prepare($DB, "DELETE FROM `kehadiran` WHERE kodProgram = ?");
            mysqli_stmt_bind_param($deleteRows, "s", $a);

            // then delete row on program
            if(mysqli_stmt_execute($deleteRows)) {
                $stmt = mysqli_prepare($DB, "DELETE FROM `program` WHERE `program`.`kodProgram` = ?");
                mysqli_stmt_bind_param($stmt, "s", $a);
                if($stmt->execute()) {
                    $stmt->close(); // Fixed method call
                    $deleteRows->close();
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        elseif($s === 'DELETE_ROW') {
            if ($a['switch'] === 'GURU') {
                // get kodProgram to delete kehadiran's row
                $kodProgram_MYSQL = mysqli_query($DB, "SELECT kodProgram FROM program WHERE nokp = '" . $a['nokp'] . "'");
                $kodProgram = mysqli_fetch_assoc($kodProgram_MYSQL);

                // delete kehadiran rows using nokp attribute
                $stmt = $DB -> prepare("DELETE FROM guru WHERE nokp = ?");
                mysqli_stmt_bind_param($stmt, "s", $a['nokp']);
                $deleteRows = $DB -> prepare("DELETE FROM kehadiran WHERE kodProgram = ?");
                mysqli_stmt_bind_param($deleteRows, "s", $kodProgram);
            }
            else {
                // delete kehadiran rows using noic attribute
                $stmt = $DB -> prepare("DELETE FROM murid WHERE noic = ?");
                mysqli_stmt_bind_param($stmt, "s", $a['noic']);
                $deleteRows = $DB -> prepare("DELETE FROM kehadiran WHERE noic = ?");
                mysqli_stmt_bind_param($deleteRows, "s", $a['noic']);
            }
            
            // FOR $deleteRows
            // this one is important to maintain data integrity
            // row that are related to selected noic will be deleted.
            // then selected murid will be deleted

            // delete program rows
            if($deleteRows -> execute()) {
                $deleteRows -> close();
            }
            else {
                return false;
            }

            // execute row deletion
            if($stmt->execute()) {
                $stmt->close(); // Fixed method call
                return true;
            }
            else {
                return false;
            }
        }        
        elseif($s === 'LIST_PROGRAM') {
            $return = mysqli_query($DB, "SELECT * FROM program WHERE kodProgram = '$a'");
            if($return -> num_rows > 0) {
                while($data = mysqli_fetch_assoc($return)) {
                    return [
                        'nama_program' => $data['nama_program'],
                        'tarikh' => $data['tarikh'],
                    ];
                }
            }
            else {
                return false;
            }
        }
        elseif ($s === 'EDIT_MURID') {
            // switch case is just impossible to use for this specific condition
            $update_query_clause = [];
            $params = [];
            $types = '';
        
            // Collect update fields
            if (isset($a['nama']) && !empty($a['nama'])) {
                $update_query_clause[] = 'nama = ?';
                $types .= 's';
                $params[] = $a['nama'];
            }
        
            if (isset($a['kelas']) && !empty($a['kelas']) && $a['kelas'] !== 'NULL') {
                $update_query_clause[] = 'kelas = ?';
                $types .= 's';
                $params[] = $a['kelas'];
            }
        
            if (isset($a['jantina']) && !empty($a['jantina'])) {
                $update_query_clause[] = 'jantina = ?';
                $types .= 's';
                $params[] = $a['jantina'];
            }
        
            if (isset($a['noic']) && !empty($a['noic'])) {
                $update_query_clause[] = 'noic = ?';
                $params[] = $a['noic'];
                $types .= 's'; // For 'noic'
            }
        
            if (!empty($update_query_clause)) {
                $old_noic = $a['noic_for_refe'];
                if ($old_noic === NULL) {
                    echo "<script>alert('No reference noic provided.');</script>";
                    return false;
                }
                $params[] = $old_noic;
                $types .= 's';
        
                $set_update_clause = implode(', ', $update_query_clause);
                $query = "UPDATE murid SET $set_update_clause WHERE noic = ?";
        
                $stmt = $DB->prepare($query);
        
                if (!$stmt) {
                    echo "<script>alert('Prepare failed: " . $DB->error . "'); </script>";
                    return false;
                }
        
                // Bind parameters
                $stmt->bind_param($types, ...$params);
        
                if ($stmt->errno) {
                    echo "<script>alert('Bind failed: " . $stmt->error . "'); </script>";
                    return false;
                }
        
                // Execute the statement
                if($stmt->execute()) {
                    $stmt->close(); // Fixed method call
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        elseif ($s === 'EDIT_GURU') {
            // switch case is just impossible to use for this specific condition
            $update_query_clause = [];
            $params = [];
            $types = '';
        
            // Collect update fields
            if (!empty($a['nama_guru'])) {
                $update_query_clause[] = 'nama_guru = ?';
                $types .= 's';
                $params[] = $a['nama_guru'];
            }
        
            if (!empty($a['matapelajaran']) && $a['matapelajaran'] !== 'NULL') {
                $update_query_clause[] = 'guru_matapelajaran = ?';
                $types .= 's';
                $params[] = $a['matapelajaran'];
            }
        
            if (!empty($a['jantina'])) {
                $update_query_clause[] = 'jantina = ?';
                $types .= 's';
                $params[] = $a['jantina'];
            }
        
            if (!empty($a['katalaluan'])) {
                $update_query_clause[] = 'katalaluan = ?';
                $types .= 's';
                $params[] = $a['katalaluan'];
            }
        
            if (!empty($a['nokp'])) {
                $update_query_clause[] = 'nokp = ?';
                $types .= 's';
                $params[] = $a['nokp'];
            }
        
            if (!empty($update_query_clause)) {
                $old_noic = $a['nokp_for_refe'];
                $params[] = $old_noic;
                $types .= 's';
        
                $set_update_clause = implode(', ', $update_query_clause);
                $query = "UPDATE guru SET $set_update_clause WHERE nokp = ?";
        
                $stmt = $DB->prepare($query);
        
                if (!$stmt) {
                    echo "<script>alert('Prepare failed: " . $DB->error . "');</script>";
                    return false;
                }
        
                $stmt->bind_param($types, ...$params);
        
                if ($stmt->errno) {
                    echo "<script>alert('Bind failed: " . $stmt->error . "');</script>";
                    return false;
                }
        
                if ($stmt -> execute()) {
                    return true;
                }
                else {
                    echo "<script>alert('Execute failed: " . $stmt->error . "');</script>";
                    return false;
                }
            }
            else {
                return false;
            }
        }        
    }

    // to import murid's data
    function importFile($DB, $a, $s) {
        if($s === "EXCEL") {
            try {
                // load up given spreadsheet using PHPSpreadSheet library
                $spreadSheet = IOFactory::load($a['tmp_name']);
                $getSheet = $spreadSheet -> getActiveSheet();
                $fileData = $getSheet -> toArray();
                $uploadStmt = true; // Track overall success
                
                // check if spreadsheet given have more or less column than suggested
                /* 
                    NOTE: the statement `count($fileData)>5` exist because when converting spreadsheet
                    into array, there is an extra index added to the array and this cannot be avoided
                    nor fixed
                */
                if(count($fileData) < 4 || count($fileData) > 5) {
                    foreach($fileData as $y) {
                        // Ensure correct column indices
                        $noic = $y[0] ?? '';
                        $nama = $y[1] ?? '';
                        $jantina = $y[2] ?? '';
                        $kelas = $y[3] ?? '';
                        
                        // do mysql data insertion
                        $stmt = $DB -> prepare("INSERT INTO murid (noic, nama, jantina, kelas) VALUES (?, ?, ?, ?)");
                        if($stmt === false) {
                            throw new Exception("Gagal menjalankan query [RALAT]: " . $DB -> error);
                        }
            
                        $stmt -> bind_param("ssss", $noic, $nama, $jantina, $kelas);
            
                        if(!$stmt -> execute()) {
                            $uploadStmt = false;
                            break; // Stop processing on error
                        }

                        $stmt -> close(); // ensure statement is closed each loop
                    }
                }
                else {
                    // throw an error upon given spreadsheet
                    throw new Exception("Lajur jadual tidak boleh melebihi atau kurang daripada 4!");
                }
        
                if(!$uploadStmt) {
                    throw new Exception("Gagal memasukkan query");
                }
        
                return true; // Return success if all rows are processed
        
            }
            catch (Exception $error) {
                // Handle the exception and redirect the user
                echo "<script>alert('Berlaku ralat semasa memuatkan file: " . $error -> getMessage() . "'); window.location = 'import_murid.php';</script>";
                return false;
            }
        }        
        elseif($s === "TXT") { //*
            $uploadDir = "uploads/";
        
            // check directory exsistance
            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $uploadFile = $uploadDir . basename($a['name']);
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            
            if($fileType != "txt" && $fileType != "csv") { // Corrected file type check
                return false;
            }
        
            if(move_uploaded_file($a['tmp_name'], $uploadFile)) {
                $file = fopen($uploadFile, "r");
        
                if($file) {
                    $success = true; // Track the overall success
        
                    while(($y = fgets($file)) !== false) {
                        $rows = explode(",", trim($y));
        
                        if(count($rows) === 4) { // Corrected the count check
                            $noic = trim($rows[0]);
                            $nama = trim($rows[1]);
                            $jantina = trim($rows[2]);
                            $kelas = trim($rows[3]);
        
                            $stmt = $DB -> prepare("INSERT INTO murid (noic, nama, jantina, kelas) VALUES (?, ?, ?, ?)");
                            $stmt -> bind_param("ssss", $noic, $nama, $jantina, $kelas);
        
                            if(!$stmt->execute()) {
                                $success = false;
                                break; // Stop processing on error //
                            }
        
                            $stmt->close(); // Close the statement after each execution
                        }
                    }
        
                    fclose($file); // Close the file after processing all rows
                    unlink($uploadFile); // Delete the uploaded file
        
                    return $success; // Return the result of the process
                }
            }
            return false; // Return false if file could not be moved or opened
        }        //
        else {
            // Handle other file types or conditions here
            return false;
        } 
    }    
}
