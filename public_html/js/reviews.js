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

        Reviews.getReviews = function () {
            var _xhr = $.ajax({
                url: Reviews.url,
                type: 'GET'
            });
            _xhr.done(function (content) {

                Reviews.content = '<ul>';

                $.each(content, function (index, obj) {
                    Reviews.content += '<li>';
                    Reviews.content += '<strong>' + obj.title + '</strong> ';
                    Reviews.content += '(Author: <a href="mailto:' + obj.author_email + '">' + obj.author_name + ' ' + obj.author_lastname + '</a>)<br/>';
                    Reviews.content += obj.body;
                    //console.log(obj);
                });

                Reviews.content += '</ul>';
                Reviews.$reviewsLayout.html(Reviews.content);

            });
        };

        Reviews.getReviews();

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
                if(content.product_id == Reviews.pid && content.title == title && content.body == body){
                    Reviews.getReviews();
                    Reviews.$reviewForm[0].reset();
                }
            });
            _xhr.fail(function (request) {
                if (request.status == 400) {
                    alert('Review must have a title and a body');
                }
                if (request.status == 401) {
                    alert('Guest users are not allowed to post reviews. Please login');
                }
            });
        };

        Reviews.$reviewForm.on('submit', function (e) {
            e.preventDefault();
            var _title = Reviews.$reviewForm.find('#review_title').val();
            var _body = Reviews.$reviewForm.find('#review_body').val();
            Reviews.postReview(_title, _body);
        });

    }

});