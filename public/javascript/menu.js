const menu = (function() {

    function animatePoints(polyline, setting) {

        let start_time;
        let range = setting.to - setting.from;
    
        function animate() {
            
            let elapsed = Date.now() - start_time;
    
            if(elapsed < setting.duration) {
                polyline.attr('points', "15,50 50,"+ parseInt(setting.from + range*(elapsed/setting.duration)) +" 85,50");
    
                return window.requestAnimationFrame(animate);
            }
            polyline.attr('points', "15,50 50,"+ setting.to +" 85,50");
        }
    
        setTimeout(function() {
            start_time = Date.now();
            window.requestAnimationFrame(animate);
        }, setting.delay);
    }

    return function () {
        $('#aside_menu_toggler svg').on('click', function () {

            let aside = $('#aside_menu_list');
            let polyline = $('#aside_menu_toggler svg polyline').first();

            if (aside.parent().hasClass('active')) {
                aside.parent().removeClass('active');
                animatePoints(polyline, { delay: 250, duration: 250, from: 15, to: 85 });
            }
            else {
                aside.parent().addClass('active');
                animatePoints(polyline, { delay: 0, duration: 250, from: 85, to: 15 });
            }
        });
    };
})();