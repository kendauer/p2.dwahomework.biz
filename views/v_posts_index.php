<div class="outerBox">

<div class="innerBox"
<?php foreach($posts as $post): ?>

<article>

    <h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1>

    <p><?=$post['content']?></p>

    <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
        <?=Time::display($post['created'])?>
    </time>

	<?php if(isset($like[$post['post_id']])): ?>
		<a href="/posts/unlike/<?=$post['post_id']?>">Unlike</a>
		
    <?php else: ?>
		<a href="/posts/like/<?=$post['post_id']?>">Like</a>
    <?php endif; ?>


</article>

<?php endforeach; ?>
</div>
</div>