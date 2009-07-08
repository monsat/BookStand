<div class="comment">
	<h3><span class="author"><?php echo $comment['author'] ?></span><span class="posted"><?php echo $bs->niceShort($comment['posted']) ?></span></h3>

	<p>
		<?php echo $bs->tab(2, $comment['body'] ); ?>

	</p>
</div>
