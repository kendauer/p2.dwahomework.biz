<div class="outerBox">
	<div class="innerBox">
	
	<h2>Sign Up</h2>
	
		<!-- Displays a simple form for gathering the user's sign up data -->
		<form method="POST" action='/users/p_signup'>

			First name <input type='text' name='first_name'><br>
			Last name <input type='text' name='last_name'><br>
			Email <input type='text' name='email'><br>
 
 			<!-- if the page receives an error from the controller, tell the user the email address has already been used -->
 			<?php if(isset($error)): ?>
        		<div class='error'>
            	This email address has already been used!
        		</div>
        		<br>
        	<?php endif; ?>

			Password <input type='password' name='password'><br>
 
 			<!-- Currently not being used, when working, will show an error message saying all fields must be filled out
 			<?php if(isset($error2)): ?>
        		<div class='error'>
            		All fields must be filled out!
        		</div>
        		<br>
    		<?php endif; ?>
			--> 
			
			<input type='submit' value='Sign Up'>
			
		</form>
	</div>
</div>