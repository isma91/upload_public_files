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
});