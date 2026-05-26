$(document).ready(function () {

    $("#forgotPasswordBtn").click(function (e) {

        e.preventDefault();

        $("#forgotModal")
            .removeClass("hidden")
            .addClass("flex");
    });

    $("#closeModal").click(function () {

        $("#forgotModal")
            .removeClass("flex")
            .addClass("hidden");
    });

    $(document).on("click", "#sendOtp", function () {
    
        let email = $("#forgetEmail").val();
    
        startLoader();
    
        $.ajax({
            url: "/forget-password",
            type: "POST",
            data: JSON.stringify({
                email: email
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (res) {

                stopLoader();

                if (res.status) {

                    Swal.fire({
                        icon: "success",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $("#hidden_email").val(email);
                    $("#emailSection").addClass("hidden");
                    $("#passwordSection").removeClass("hidden");
                    $("#otpSection").removeClass("hidden");
                    $("#sendOtp").text("Reset Password").attr("id", "resetPassword");

                    startOtpTimer(300);

                } else {

                    Swal.fire({
                        icon: "error",
                        text: res.message
                    });

                }
            },
            error: function (xhr, status, error) {
    
                stopLoader();
    
                console.log(xhr.responseText);
    
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong. Please try again."
                });
            }
        });
    });
    
    function startOtpTimer(duration) {

        let timer = duration;

        let interval = setInterval(function () {
    
            let minutes = Math.floor(timer / 60);
            let seconds = timer % 60;
    
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
    
            $("#otpTimer").text(minutes + ":" + seconds);
    
            timer--;
    
            if (timer < 0) {
    
                clearInterval(interval);
    
                $("#otpTimer").text("Expired");
    
                Swal.fire({
                    icon: "warning",
                    text: "OTP has expired. Please request a new OTP."
                }).then(() => {
    
                    $("#otpSection").addClass("hidden");
                    $("#passwordSection").addClass("hidden");
                    $("#emailSection").removeClass("hidden");
                    $("#otp").val("");
                    $("#newPassword").val("");
                    $("#hidden_email").val("");
                    $("#otpTimer").text("05:00");
                    $("#resetPassword").text("Send OTP").attr("id", "sendOtp");
                });
    
            }
    
        }, 1000);
    }

    $(document).on("click", "#resetPassword", function () {

        let email = $("#hidden_email").val();
        let otp = $("#otp").val();
        let password = $("#newPassword").val();

        if (!otp) {
            Swal.fire({
                icon: "warning",
                text: "Please enter OTP"
            });
            return;
        }

        if (!password) {
            Swal.fire({
                icon: "warning",
                text: "Please enter new password"
            });
            return;
        }
    
        startLoader();
    
        $.ajax({
            url: "/verify-otp",
            type: "POST",
            data: JSON.stringify({
                email: email,
                otp: otp,
                password: password
            }),
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Accept": "application/json"
            },
            success: function (res) {
    
                stopLoader();
    
                if (res.status) {
    
                    Swal.fire({
                        icon: "success",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
    
                } else {
    
                    Swal.fire({
                        icon: "error",
                        text: res.message
                    });
    
                }
            },
            error: function () {
    
                stopLoader();
    
                Swal.fire({
                    icon: "error",
                    text: "Something went wrong."
                });
            }
        });
    });

});