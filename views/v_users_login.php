<div class="outerBox">

	<h2>Log in</h2>

	<!-- basic form to collect email address and password -->
	<form method='POST' action='/users/p_login'>

		Email: <input type='text' name='email'><br>
		Password: <input type='password' name='password'><br><br>
	
	<!-- if the view receives an error from the controller, let the user know -->
	 <?php if(isset($error)): ?>
        <div class='error'>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>

		<input type='Submit' value='Log in'>
		
	</form>
</div>