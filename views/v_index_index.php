<div class="outerBox">

   <div class="innerBox">
   
       <!-- pulls the APP_NAME from the config.php file -->
      <h1>Welcome to <?=APP_NAME?>!</h1>
      
      <!-- tests if user is logged in and if so, shows all the posts from the people user is following -->
      <?php if($user): ?>
      	Hello <?=$user->first_name;?>
      	<h2>The Latest Posts:</h2>
      	
      	<?php foreach($posts as $post): ?>
      
      		<div id="post"><?=$post['content']?></div>
      		<div id="time"><?=Time::display($post['created'])?></div>
      		<br>
      
     	 	<?php if(isset($like[$post['post_id']])): ?>
      			<a href="/posts/unlike/<?=$post['post_id']?>">Unlike</a>
      
     	 	<?php else: ?>
      			<a href="/posts/like/<?=$post['post_id']?>">Like</a>
      
     	 	<?php endif; ?>
      
      	<?php endforeach;?>  
      
      <!-- otherwise, shows the user a log in screen and a link to the sign up page -->
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