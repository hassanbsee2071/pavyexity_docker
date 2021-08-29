$(document).ready(function () {
    $("form[name='smtpform']").validate({
        rules: {
            host: "required",
            user_name: "required",
            password: "required",
            port: "required"

        },
        messages: {
            host: "host is required.",
            user_name: "username is required.",
            password: "password is required.",
            port: "Port is required."
        }
    });
});