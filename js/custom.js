
 /* jQuery Pre loader
  -----------------------------------------------*/
  $(window).on("load", function (e) {
    $('.preloader').fadeOut(1000); // set duration in brackets    
});


 /* Navigation Bar
  -----------------------------------------------*/
$(document).ready(function() { 
    "use strict";

    // Navbar Sticky

    (function() {
        var docElem = document.documentElement,
            didScroll = false,
            stickynav = 50;
            document.querySelector( '.nav-container' );
        function init() {
            window.addEventListener( 'scroll', function() {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 50 );
                }
            }, false );
        }
        
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= stickynav ) {
                $( '.nav-container' ).addClass('sticky');
            }
            else {
                $( '.nav-container' ).removeClass('sticky');
            }
            didScroll = false;
        }
        
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }        
        init();        
    })();

});


$(document).ready(function(){
            
    "use strict";

    $('.menu-container').each(function(index) {
        $(this).find('.circle').attr('menu-link', index);
        $(this).find('.list-menu').clone().appendTo('body').attr('menu-link', index);
    });

    $('.menu-container .circle').click(function() {
        var linkedVideo = $('section').closest('body').find('.list-menu[menu-link="' + $(this).attr('menu-link') + '"]');
        linkedVideo.toggleClass('reveal-modal');
       
    });

    $('section').closest('body').find('.close-iframe').click(function() {
        $(this).closest('.list-menu').toggleClass('reveal-modal');
    });
    

  /* wow
  -------------------------------*/
  new WOW({ mobile: false }).init();

  });

