<h2>Product Page</h2>
<?php
echo 'Product Name: ' . $product['name'];
?>

<div class="reviews" data-product-id="<?php echo $product['id']; ?>">
    <div class="reviews__header">
        <h3>Reviews</h3>
    </div>
    <div class="reviews__layout">
        
    </div>
</div>

<form class="review__post" action="/" method="post">
    <div>
        <label for="review_title">
            Review Title<br/>
            <input type="text" id="review_title"/>
        </label>
    </div>
    <div>
        <label for="review_body">
            Review Text<br/>
            <textarea id="review_body" rows="8" cols="50"></textarea>
        </label>
    </div>
    <div>
        <input type="submit" value="Submit Review"/>
    </div>
</form>