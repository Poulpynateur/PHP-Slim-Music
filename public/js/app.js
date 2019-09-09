$( document ).ready(function() {

    $(window).on('activate.bs.scrollspy', function () {
        $('#page_position_category').text(
            $('.side-bar-link.active').first().data('cat')
        );
        $('#page_position_tag').text(
            $('.sub-side-bar-link.active').first().data('tag')
        );
        $('#page_position_mark').text('#');
    });

    $(document).click(function(event) { 
        $target = $(event.target);
        if(!$target.closest('.nav-collapsable .collapse').length && $('.nav-collapsable .collapse').hasClass('show')) {
            $('.nav-collapsable .collapse').removeClass('show');
        }
    });

    $("a[href^='#']").on('click', function (event) {
        event.preventDefault();
        let page = $(this).attr('href');
        let speed = 500;
        $('html, body').animate({ scrollTop: $(page).offset().top }, speed);
        return false;
    });

    $('.delete-music').on('click', function() {
        $.ajax({
            url: '/musics/'+$(this).val(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE'
        });
    });
});