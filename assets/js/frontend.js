jQuery(document).ready(function($) {
    const $scrollToTopButton = $('<div>', {
        id: 'sk-scroll-to-top',
        html: '<span>&uarr;</span>',
    }).appendTo('body');
    const $button = $('#sk-scroll-to-top');
    const iconSize = skstSettings.iconSize || 30;
    $button.css({
        backgroundColor: skstSettings.backgroundColor,
        color: skstSettings.iconColor,
        width: `${skstSettings.buttonWidth}px`,
        height: `${skstSettings.buttonHeight}px`,
        borderRadius: `${skstSettings.buttonBorderRadius}px`,
        position: 'fixed',
        [skstSettings.buttonPosition.includes('left') ? 'left' : 'right']: `${skstSettings.buttonPositionX}px`,
        bottom: `${skstSettings.buttonPositionY}px`,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        cursor: 'pointer'
    });
    $button.find('span').css({
        fontSize: `${iconSize}px`,
        fontWeight: 'bold'
    });
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 200) {
            $button.fadeIn();
        } else {
            $button.fadeOut();
        }
    });
    $button.on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
    });
});
