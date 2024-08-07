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

    seekAttendance: function(code) {
        this.sendCookie('kod', code);
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
        if (switchType === 'MURID') {
            userConfirmed = confirm('Adakah Anda Pasti Untuk Menyingkirkan Murid Ini? Murid Ini Tidak Akan Wujud Lagi Dalam Pangkalan Data Selepas Ini.');
        }
        else if (switchType === 'GURU') {
            userConfirmed = confirm('Adakah Anda Pasti Untuk Menyingkirkan Guru Ini? Guru Ini Tidak Akan Wujud Lagi Dalam Pangkalan Data Selepas Ini.');
        }

        // Check the user's response
        if (!userConfirmed) {
            // Prevent the default action if the user clicks "Cancel"
            event.preventDefault();
            return false;
        }
        else {
            // Send a cookie if the user clicks "OK"
            document.cookie = "confirm=true";
        }
    
        return true;
    }    
};

// set this object globally so that it can be accessed outside the script
window.callFunc = callFunc;

export { callFunc };
