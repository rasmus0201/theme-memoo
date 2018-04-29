(function($){
    $(document).ready(function(){
        $('#burger-menu').on('click', function(){
            $('#menu-2 #navigation-wrapper').slideToggle('1000');
            $('#burger-menu .navigation-icon').toggleClass('active');

            if ($('#navigation-wrapper').height() > 0) {
                $('#menu-2 ul li.dropdown ul.menu-depth-1').slideUp('1000');
                $('#menu-2 ul li.dropdown ul li ul.menu-depth-2').slideUp('1000');
            }
        });

        $(document).click(function() {
            if ($(window).width() < 1025) {
                $('#menu-2 .active-submenu').removeClass('active-submenu');
                $('#menu-2 .show-submenu').removeClass('show-submenu');
            }
        });

        $('#menu-2 ul li.dropdown span.caret-wrapper').on('click', function(event){
            $(this).find('far').toggleClass('fa-chevron-down');

            var caret = $(this).find('.far');

            if ($(window).width() < 768) {
                $(this).parent().toggleClass('active-submenu');
                $(this).parent().find('ul.menu-depth-1').slideToggle('1000');
            } else if ($(window).width() < 1025) {
                $(this).parent().toggleClass('active-submenu');
                $(this).parent().find('ul.menu-depth-1').toggleClass('show-submenu');
            }

            event.stopPropagation();
        });

        $('#menu-2 ul li.dropdown ul li span.caret-wrapper').on('click', function(event){
            if ($(window).width() < 768) {
                $(this).parent().find('ul.menu-depth-2').slideToggle('1000');
            } else if ($(window).width() < 1025) {
                $(this).parent().find('ul.menu-depth-2').toggleClass('show-submenu');
            }
            event.stopPropagation();
        });

        $('#navigation-wrapper').on('click', function(event){
            event.stopPropagation();
        });

        $(window).on('resize', function(){
            if ($(window).width() > 767) {
                $('#navigation-wrapper').css('display', 'flex');
            } else {
                $('#burger-menu .navigation-icon').removeClass('active');
                $('#navigation-wrapper').css('display', 'none');
            }
        });

        if ($(window).scrollTop() >= 100) {
            $('#main-header.fixed').addClass('scrolled');
        }

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 100) {
                $('#main-header.fixed').addClass('scrolled');
            } else {
                $('#main-header.fixed').removeClass('scrolled');
            }
        });
    });
})(jQuery);
