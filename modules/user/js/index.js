$('#bar').click(function () {
    $(this).toggleClass('open');
    $('#page-content-wrapper ,#sidebar-wrapper').toggleClass('toggled');

});


$(".nav li").on("click", function () {
    $(".nav").find(".activa").removeClass("activa");
    $(this).addClass("activa");
});