<!DOCTYPE html>
<html>
<head>
	<title>Squeak!</title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	 <link rel="stylesheet" type="text/css" href="/css/main.css" />
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

	<div id="title">
		<h2>Squeak</h2>
	</div>

    <div id='menu'>

        <a href='/'>Home</a>

        <!-- Menu for users who are logged in -->
        <?php if($user): ?>

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

    <br>

    <?php if(isset($content)) echo $content; ?>


</body>
</html>