/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function () {
    $('select').material_select();
    var errorDiv = $(".row").filter(".failed").text();
    errorDiv = $.trim(errorDiv);
    if (errorDiv == "You can't go here if you're connected !!") {
        setTimeout(function () {
            $(".row").filter(".failed").text("");
        }, 2000);
    }
});