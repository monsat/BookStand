<div id="bookStandArticlesIndex">
<?php
	if (!empty($this->data))
		foreach ($this->data as $article):
?>

	<h2><?php echo $bs->link($article['BookStandArticle']['title'] ,$tool->articleUrl('dynamic' ,$article)); ?></h2>
	<div class="bookStandPosted">
<?php
		echo ife($article['BookStandArticle']['posted'] ,$bs->tab(2 ,h('posted ' . date('Y-m-d' ,strtotime($article['BookStandArticle']['posted'])) . ' | ')));
		echo ife( $article['BookStandAuthor']['name'] ,$bs->tab(2 ,h('written by ' . $article['BookStandAuthor']['name'])));
?>

	</div>
	<div class="bookStandArticleMain">
		<?php echo $bs->tab(2 ,$bs->bsTags( $bs->readMore($article['BookStandRevision']['body'] ,$tool->articleUrl('dynamic' ,$article)) )); ?>

	</div>
<?php endforeach; ?>
	<div class="paging">
		<?php echo $paginator->prev('<< '.__('previous', true), aa('url',$bs->url()), null, array('class'=>'disabled'));?>
	 | 	<?php echo $paginator->numbers(aa('url',$bs->url()));?>
		<?php echo $paginator->next(__('next', true).' >>', aa('url',$bs->url()), null, array('class'=>'disabled'));?>
	</div>
	<div>
<?php
		echo $paginator->counter(array(
			'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
		));
?>

	</div>
</div>
