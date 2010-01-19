<div id="bookStandArticlesView">
	<h1><?php echo $bs->link($this->data['BookStandArticle']['title'] ,$tool->articleUrl()); ?></h1>
	<div class="bookStandArticleMain">
<?php echo $bs->includeArticle($this->data['BookStandArticle']['id']); ?>

	</div>

</div>
