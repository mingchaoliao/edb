$(document).ready(function() {
    $('.navbar-toggler').click(function() {
        if(!$(".navbar-collapse.justify-content-right.collapse").hasClass("show")) {
            $('#headerSepBar').hide();
        } else {
            setTimeout(function() {
                $('#headerSepBar').show();
            }, 400);
        }
    });
});