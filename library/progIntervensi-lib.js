const callFunc = {
    sendCookie: function(name) {
        document.cookie = `kelas=${name}`;
        window.location = "record.php";
    }
};

// set this object globally
window.callFunc = callFunc;

export { callFunc };