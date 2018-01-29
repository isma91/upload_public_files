/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function () {

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