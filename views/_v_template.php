<!DOCTYPE html>
<html>
   <head>
      <title>Squeak!</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      
      <!-- link to main stylehsheet -->
      <link rel="stylesheet" type="text/css" href="/css/main.css" />
      
      <!-- Controller Specific JS/CSS -->
      <?php
         if (isset($client_files_head))
             echo $client_files_head;
         ?>
   </head>
   
   <body>
   
      <div id="title">
         <h2>
            <a href="/">Squeak</a>
         </h2>
      </div>
      
      <hr class = "blue">
      
      <!-- menu used for all pages, options for logged in and not logged in users --> 
      
      <div id='menu'>
      
      	<a href='/'>Home</a>
      
	  	<!-- Menu for users who are logged in -->
	  	<?php if ($user): ?>
	  	<a href='/users/logout'>Logout</a>
	  	<a href='/users/profile'>Profile</a>
	  	<a href='/posts/add'>Add Posts</a>
	  	<a href='/posts/'>View Posts</a>
	  	<a href='/posts/users'>View Users</a>
      
	  	<!-- Menu options for users who are not logged in -->
	  	<?php else: ?>
	  	<a href='/users/signup'>Sign up</a>
	  	<a href='/users/login'>Log in</a>
      
	  	<?php endif; ?>
      
      </div>
      
      <hr class = "blue">
      
      <br>
      
      <?php if (isset($content)) echo $content; ?>
       
      <!-- Footer with required rubric information and easy validation links -->   
      <footer>
         <p>+1 features: email confirmation and "like" feature.
         <p>Page authored by Ken Dauer using Coda 2 for editing and git for version control.</p>
         <p><a href="http://validator.w3.org/check/referer">Validate Markup</a>
            &nbsp;|&nbsp;
            <a href="http://jigsaw.w3.org/css-validator/check/referer">Validate CSS</a>
         </p>
      </footer>
      
   </body>
</html>