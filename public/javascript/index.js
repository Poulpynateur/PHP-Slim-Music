window.addEventListener("load", function () {
    //Menu animation (menu.js)
    menu();
    // Smooth page scroll
    $('.nav-link').on('click', function (event) {
        event.preventDefault();
        let page = $(this).attr('href');
        let speed = 500;
        $('html, body').animate({ scrollTop: $(page).offset().top }, speed);
        return false;
    });
});