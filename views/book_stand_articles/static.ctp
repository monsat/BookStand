<div id="bookStandArticlesView">
	<h1><?php echo $bs->link($this->data['BookStandArticle']['title'] ,$tool->articleUrl()); ?></h1>
	<div class="bookStandArticleMain">
		<?php echo $bs->tab(2 ,$bs->bsTags( $this->data['BookStandRevision']['body']) ); ?>

	</div>

</div>
