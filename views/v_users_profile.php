<div class="outerBox">
	
	<!-- very basic profile page showing some basic user info and a listing of their posts -->
	<h2><?=$user->first_name?><?=$user->last_name?></h2>
	
	<h2>My Posts</h2>
	<?php foreach($posts as $post): ?>
	
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br>
	
	<?php endforeach;?>  
	
</div>