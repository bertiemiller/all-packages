
$(function() {
    var http = "http://"+window.location.hostname;
    var https = "http://"+window.location.hostname;
    $('a[href="/' + location.pathname.split("/")[1] + '"]').addClass('active');
    $('a[href="'+http+'/' + location.pathname.split("/")[1] + '"]').addClass('active');
    $('a[href="'+https+'/' + location.pathname.split("/")[1] + '"]').addClass('active');
});
