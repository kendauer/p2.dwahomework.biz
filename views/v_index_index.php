<div class="outerBox">

<div class="innerBox">
<h1>Welcome to <?=APP_NAME?>

<?php if($user) echo ', '.$user->first_name; ?></h1>


<?php if($user): ?>
	Hello <?=$user->first_name;?>
	
<?php else: ?>
	Welcome! Squeak is an easy-to-use micro-blog designed for speed and simplicity. Please
	<a href="/users/signup">Sign up</a> or: 
	
	<h2>Log in</h2>

<form method='POST' action='/users/p_login'>

Email: <input type='text' name='email'><br>
Password: <input type='password' name='password'><br>

<input type='Submit' value='Log in'>

</form>
<?php endif; ?>








</div>
</div>