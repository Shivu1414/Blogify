$(document).ready(function () {

    window.startLoader = function () {
        $("#topLoader").css({ width: "30%" });

        setTimeout(() => {
            $("#topLoader").css({ width: "70%" });
        }, 300);
    };

    window.stopLoader = function () {
        $("#topLoader").css({ width: "100%" });

        setTimeout(() => {
            $("#topLoader").css({ width: "0%" });
        }, 300);
    };

});