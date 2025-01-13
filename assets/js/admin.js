$(function () {
    $(".icefox-global").show();
    
    $(".icefox-nav-ul li").click(function () {
        $(".icefox-content").hide();

        $(".icefox-nav-ul li").removeClass('active');
        $(this).addClass('active');

        var type = $(this).data('type');

        $(".icefox-" + type).show();
    })
})