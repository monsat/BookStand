<div id="bookStandArticlesIndex">
<?php
	if (!empty($this->data))
		foreach ($this->data as $article):
			$Article = $article['BookStandArticle'];
?>

	<h2><?php echo $bs->link($Article['title'] ,$tool->articleUrl($article)); ?></h2>
	<div class="bookStandPosted">
<?php
		echo ife($Article['posted'] ,$bs->tab(2 ,h('posted ' . date('Y-m-d' ,strtotime($Article['posted'])) . ' | ')));
		echo ife( $article['BookStandAuthor']['name'] ,$bs->tab(2 ,h('written by ' . $article['BookStandAuthor']['name'])));
?>

	</div>
	<div class="bookStandArticleMain">
		<?php echo $bs->tab(2 ,$bs->bsTags( $bs->readMore($article['BookStandRevision']['body'] ,$tool->articleUrl($article)) )); ?>

	</div>
<?php endforeach; ?>
	<div class="paging">
		<?php echo $paginator->prev('<< '.__('previous', true), aa('url',$bs->url()), null, array('class'=>'disabled'));?>
	 | 	<?php echo $paginator->numbers(aa('url',$bs->url()));?>
		<?php echo $paginator->next(__('next', true).' >>', aa('url',$bs->url()), null, array('class'=>'disabled'));?>
	</div>
</div>
