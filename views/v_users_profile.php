<div class="outerBox">
	
	<h2><?=$user->first_name?></h2>
	
	<h2>My Posts</h2>
	<?php foreach($posts as $post): ?>
	
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br>
	
	<?php endforeach;?>  
	
	<?php if(isset($error)): ?>
        <div class='error'>
            Image upload failed, please try again.
        </div>
        <br>
    <?php endif; ?>

</div>