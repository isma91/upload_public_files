/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function () {

    var user = {};
    var firstname, lastname, username, email, pass, pass2 = "";
    var errField = [];

    function validateEmail($email) {
        var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regex.test(email);
    }

    $('#register').on('click', function (event) {
        event.preventDefault();
        firstname = $.trim($("#firstname").val());
        lastname = $.trim($("#lastname").val());
        username = $.trim($("#username").val());
        email = $.trim($("#email").val());
        pass = $("#pass").val();
        pass2 = $("#pass2").val();
        user = { firstname: firstname, lastname: lastname, username: username, email: email, password: pass, rewrite_password: pass2 };
        errField = [];
        $.each(user, function (key, value) {
            if (value == "") {
                errField.push(key);
            }
        });
        if (errField.length > 0) {
            var field = "";
            $.each(errField, function (key, value) {
                field = field + ", " + value;
            });
            field = field.substr(2);
            Materialize.toast('<p class="alert-failed">The following field are empty: ' + field + ' !!<p>', 5000, 'rounded alert-failed');
        } else if (!validateEmail(user.email)) {
            Materialize.toast('<p class="alert-failed">Your email is not valid !!<p>', 5000, 'rounded alert-failed');
        } else if (user.password.length <= 3 || user.rewrite_password.length <= 3) {
            Materialize.toast('<p class="alert-failed">The two password fields must be at least 4 characters long !!<p>', 5000, 'rounded alert-failed');
        } else if (user.username.length <= 3) {
            Materialize.toast('<p class="alert-failed">The username must be at least 4 characters long !!<p>', 5000, 'rounded alert-failed');
        } else if (user.password !== user.rewrite_password) {
            Materialize.toast('<p class="alert-failed">The two password field must be the same !!<p>', 5000, 'rounded alert-failed');
        } else {
            $("#registerForm").submit();
        }
    })

    $(document).on('mousedown', "#displayUserPass", function () {
        $("#pass").prop("type", "text");
    });
    $(document).on('mouseup', "#displayUserPass", function () {
        $("#pass").prop("type", "password");
    });

    $(document).on('mousedown', "#displayUserPass2", function () {
        $("#pass2").prop("type", "text");
    });
    $(document).on('mouseup', "#displayUserPass2", function () {
        $("#pass2").prop("type", "password");
    });
});