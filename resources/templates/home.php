<!-- Homepage content -->
<?php if(!is_array($user)): ?>
<div>
	<!-- START login -->
	<div class="login">
		<form action="index.php" method="post" >
			<h2>sign in</h2>
			<input type="text"  placeholder="Email address" name="username" value="davand">
			<input type="password" placeholder="Password" name="password" value="0000">
            <input type="hidden" name="login_form" value="1"/>
			<input type="submit" name="login" value="Login" />
		</form>
	</div>
	<!-- END login -->
</div>
<?php else: ?>
<div>
    <p>Hey, <?php echo $user['name'] . ' ' . $user['lastname'] ?>!</p>
    <a href="/?logout=true">Logout</a>
</div>
<?php endif; ?>