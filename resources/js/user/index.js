$(function(){
    $('#search_keyword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            window.location.href = $('#url_search').val() + '/' + $(this).val();
        }
        event.stopPropagation();
    });
    $('.check').on('click', function(){
        var search = $('#search_keyword').val();
        if (typeof search !== 'undefined' && search.length > 0) {
            window.location.href = $('#url_search').val() + '/' + search;
        } else {
            alert('Vui lòng nhập mã vận đơn');
        }
    });
    $('.header .logo').on('click', function(){
        window.location.href = $(this).data('url');
    });
});