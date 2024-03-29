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

<?php if(!is_array($user)): ?>
<div style="background:#eee; padding:10px;">
	<!-- START login -->
	<div class="login">
		<form action="/" method="post" >
			<h2>Guest</h2>
			<input type="text"  placeholder="Email address" name="username" value="davand">
			<input type="password" placeholder="Password" name="password" value="0000">
            <input type="hidden" name="login_form" value="1"/>
			<input type="submit" name="login" value="Login" />
		</form>
	</div>
	<!-- END login -->
</div>
<?php else: ?>
<div style="background:#eee; padding:10px;">
    <p>Hey, <?php echo $user['name'] . ' ' . $user['lastname'] ?>!</p>
    <a href="/?logout=true">Logout</a>
</div>
<?php endif; ?>