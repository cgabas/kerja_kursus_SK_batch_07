const callFunc = {
    // to set cookie
    sendCookie: function(cookieName, value, redirect = null) {
        document.cookie = `${cookieName}=${value}`;
        if (redirect === 'r') {
            window.location = "record.php";
        } else if (redirect === 'm') {
            window.location = "";
        } else if (redirect === 'a') {
            window.location = "attendance.php";
        }
    },

    seekAttendance: function(code) {
        this.sendCookie('kod', code, null);
        window.location = "see_attendance.php";
    },

    switchTable: function(kelas) {
        this.sendCookie('kelas', kelas, null);
        document.getElementById("table").outerHTML = "<iframe id=\"table\" src=\"table.php\" frameborder=\"0\"></iframe>";
    }
};

// set this object globally so that it can be accessed outside the script
window.callFunc = callFunc;

export { callFunc };
