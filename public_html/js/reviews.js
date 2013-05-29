/*
*   Get Reviews
*/

$(window).on('load', function () {
    
    if($('body').find('.reviews')){

        window.Reviews = {};
        Reviews.$reviews = $('.reviews');
        Reviews.$reviewsLayout = Reviews.$reviews.find('.reviews__layout');
        Reviews.pid = Reviews.$reviews.data('product-id');
        Reviews.url = '?' + $.param({ page: 'review', pid: Reviews.pid, json: 1 });
        Reviews.content = '<ul>';

        Reviews.jqxhr = $.ajax({
            url: Reviews.url,
            type: 'GET'
        });

        Reviews.jqxhr.done(function (content) {
            
            $.each(content, function (index, obj) {
                Reviews.content += '<li>';
                Reviews.content += '<strong>' + obj.title + '</strong><br/>';
                Reviews.content += obj.body;
            });

            Reviews.content += '</ul>';
            $(Reviews.content).appendTo(Reviews.$reviewsLayout);

        });        

    }

});