const callFunc = {
    sendCookie: function(cookieName, value, redirect = null) {
        document.cookie = `${cookieName}=${value}`;
        switch (redirect) {
            case 'r':
                window.location = "record.php";
                break;
            case 'm':
                window.location = "murid.php";
                break;
            case 'a':
                window.location = "attendance.php";
                break;
            case 'em':
                window.location = "edit_murid_process.php";
                break;
            case 'eg':
                window.location = "edit_guru_process.php";
                break;
        }
    },

    seekAttendance: function(code, date) {
        this.sendCookie('kod', code);
        this.sendCookie('tarikh', code);
        window.location = "see_attendance.php";
    },

    switchTable: function(kelas) {
        this.sendCookie('kelas', kelas);
        document.getElementById("table").outerHTML = `<iframe id="table" src="table.php" frameborder="0"></iframe>`;
    },

    inputToTitleSync: function() {
        const input = document.getElementById("syncTextToTitle");
        const title = document.getElementById("programName");

        title.textContent = input.value.length === 0 ? "Nama Program" : input.value;
    },

    userConfirm: function(event, switchType = null) {
        let userConfirmed = false;
        
        // Display the confirmation dialog based on the switchType
        if(switchType === 'MURID') {
            userConfirmed = confirm('Adakah Anda Pasti Untuk Menyingkirkan Murid Ini? Murid Ini Tidak Akan Wujud Lagi Dalam Pangkalan Data Selepas Ini.');
        }
        else if(switchType === 'GURU') {
            userConfirmed = confirm('Adakah Anda Pasti Untuk Menyingkirkan Guru Ini? Guru Ini Tidak Akan Wujud Lagi Dalam Pangkalan Data Selepas Ini.');
        }

        // Check the user's response
        if(!userConfirmed) {
            // Prevent the default action if the user clicks "Cancel"
            event.preventDefault();
            return false;
        }
        else {
            // Send a cookie if the user clicks "OK"
            document.cookie = "confirm=true";
        }
    
        return true;
    },

    // send 2 elements into parameter
    checkFile: function(idFile, idFileName, msg) {
        // detect file selection
        idFile.addEventListener('change', function(){
            if(this.files.length > 0) {
                idFileName.textContent = this.files[0].name;
                msg.textContent = "File Yang Dipilih";
            }
            else {
                idFileName.textContent = "Tiada File Yang Dipilih";
                msg.textContent = "";
            }
        });
    },

    // to make the cute clock at the main menu functioning
    // use setInterveal() to make it always updating date and time every second
    datetimeTeller: function(time, date, clockAnima) {
        const now = new Date();
        
        // format the date as dd/mm/yyyy
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
        const year = now.getFullYear();
        const dateString = `${day}-${month}-${year}`;
        
        // format the time as HH:MM:SS AM/PM
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // The hour '0' should be '12'
        const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;

        // display datetime
        date.textContent = "Tarikh: " + dateString + " 📆";
        time.textContent = "Masa: " + timeString + " " +clockAnima;
    },

    logoutPrompt: function() {
        // ask user before logout
        var isLogoutTrue = confirm('Adakah anda ingin log keluar daripada system?');

        if(isLogoutTrue) {
            window.location='logout.php';
        }
    }
};

// set this object globally so that it can be accessed outside the script
window.callFunc = callFunc;

export { callFunc };
