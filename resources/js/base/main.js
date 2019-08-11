(function ($) {
    'use strict';

    // loader
    var loader = function() {
        setTimeout(function() {
            if($('#loader').length > 0) {
                $('#loader').removeClass('show');
            }
        }, 1);
    };
    loader();

    // Stellar
    $(window).stellar();

    $('#search_keyword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            window.location.href = $('#url_search').val() + '/' + $(this).val();
        }
        event.stopPropagation();
    });

    // bootstrap dropdown hover
    $('nav .dropdown').hover(function() {
        var $this = $(this);
        $this.addClass('show');
        $this.find('> a').attr('aria-expanded', true);
        $this.find('.dropdown-menu').addClass('show');
    }, function() {
        var $this = $(this);
        $this.removeClass('show');
        $this.find('> a').attr('aria-expanded', false);
        $this.find('.dropdown-menu').removeClass('show');
    });

    // home slider
    $('.home-slider').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 10,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        autoplayHoverPause: true,
        items: 1,
        navText: [
            "<span class='ion-chevron-left'></span>",
            "<span class='ion-chevron-right'></span>"
        ],
        responsive: {
            0: {
                items:1,
                nav:false
            },
            600: {
                items:1,
                nav:false
            },
            1000: {
                items:1,
                nav:true
            }
        }
    });

    var contentWayPoint = function() {
        var i = 0;
        $('.element-animate').waypoint( function( direction ) {
            if( direction === 'down' && !$(this.element).hasClass('element-animated') ) {
                i++;
                $(this.element).addClass('item-animate');
                setTimeout(function(){
                    $('body .element-animate.item-animate').each(function(k){
                        var el = $(this);
                        setTimeout( function () {
                            var effect = el.data('animate-effect');
                            if ( effect === 'fadeIn') {
                                el.addClass('fadeIn element-animated');
                            } else if ( effect === 'fadeInLeft') {
                                el.addClass('fadeInLeft element-animated');
                            } else if ( effect === 'fadeInRight') {
                                el.addClass('fadeInRight element-animated');
                            } else {
                                el.addClass('fadeInUp element-animated');
                            }
                            el.removeClass('item-animate');
                        },  k * 100);
                    });
                }, 100);
            }
        }, {offset: '95%'});
    };
    contentWayPoint();
}(jQuery));
