/*
*   Get Reviews
*/

$(window).on('load', function () {
    
    if($('body').find('.reviews')){

        window.Reviews = {};
        Reviews.$reviews = $('.reviews');
        Reviews.$reviewsLayout = Reviews.$reviews.find('.reviews__layout');
        Reviews.$reviewForm = $('.review__post');
        Reviews.pid = Reviews.$reviews.data('product-id');
        Reviews.url = '?' + $.param({ page: 'review', pid: Reviews.pid, json: 1 });
        Reviews.content = '<ul>';

        Reviews.getReviews = function () {
            var _xhr = $.ajax({
                url: Reviews.url,
                type: 'GET'
            });
            _xhr.done(function (content) {

                $.each(content, function (index, obj) {
                    Reviews.content += '<li>';
                    Reviews.content += '<strong>' + obj.title + '</strong> ';
                    Reviews.content += '(Author: <a href="mailto:' + obj.author_email + '">' + obj.author_name + ' ' + obj.author_lastname + '</a>)<br/>';
                    Reviews.content += obj.body;
                    console.log(obj);
                });

                Reviews.content += '</ul>';
                Reviews.$reviewsLayout.html(Reviews.content);

            });
        }();

        Reviews.postReview = function (title, body) {
            var _xhr = $.ajax({
                url: Reviews.url,
                type: 'POST',
                data: {
                    title: title,
                    body: body
                }
            });
            _xhr.done(function (content) {
                console.log(content);
            });
        };

        Reviews.$reviewForm.on('submit', function (e) {
            e.preventDefault();
        });

    }

});