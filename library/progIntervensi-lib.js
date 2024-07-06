const callFunc = {
    sendCookie: function(name) {
        document.cookie = "kelas=${name}; path=/";
        location.replace("record.php");
    },
};

export { callFunc };