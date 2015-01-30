    var menu = {
        isOpen: false,
        responsiveBreak: 768,
        buttons: {
            grey: window.location + '/wp-content/themes/gazeti/images/menu_button_grey.svg',
            white: window.location + '/wp-content/themes/gazeti/images/menu_button_white.svg'
        },
        elements: {
            container: '#menu',
            toggle: '.menu-toggle',
            wrap: '.menu-wrap',
            mobile: '.mobile-menu',
            dropdown: '.dropdown'
        },
        open: function() {
            if ($(window).width() <= this.responsiveBreak) {
                $(this.elements.wrap).show();
                $(this.elements.mobile).addClass('active');

                $(menu.toggle).css({
                    'background-color' : '#fff',
                    'background-image' : 'url("' + this.buttons.grey + '")',
                });

                this.isOpen = true;
            }
        },
        close: function() {
            if ($(window).width() <= this.responsiveBreak) {
                $(this.elements.wrap).hide();
                $(this.elements.mobile).removeClass('active'); 

                $(this.elements.toggle).css({
                    'background-color' : '#555',
                    'background-image' : 'url("' + this.buttons.white + '")',
                });

                this.isOpen = false;
            }
        },
        toggleStyle: function() {
            /* Toggle the main navigation menu bewenen the mobile and desktop 
             * states. */

            if (typeof window.orientation === 'undefined') {
                $(this.elements.wrap).removeAttr('style');
            }

            if ($(window).width() <= this.responsiveBreak) {
                $(this.elements.wrap).addClass(this.elements.mobile.substr(1));
            }
        },
    };

    menu.toggleStyle();

    $(window).click(function() {
        menu.close();
    });

    $(menu.elements.container).click(function(e) {
        e.stopPropagation();
    });

    /* Toggle the appearance of the menu at mobile sizes. */

    $(menu.elements.toggle).click(function() {
        $(menu.elements.dropdown).show();
        (menu.isOpen) ? menu.close() : menu.open();
    });

    /* Close the menu on window scroll or resize. */

    $(window).scroll(function() {
        menu.close();
    });

    $(window).resize(function() {
        menu.close();
        menu.toggleStyle();
    });