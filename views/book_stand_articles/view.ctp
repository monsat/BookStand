<div id="bookStandArticlesView">
	<h1><?php echo $bs->link($this->data['BookStandArticle']['title'] ,$tool->articleUrl()); ?></h1>
	<div class="bookStandPosted">
<?php
		echo ife($this->data['BookStandArticle']['posted'] ,$bs->tab(2 ,h('posted ' . date('Y-m-d' ,strtotime($this->data['BookStandArticle']['posted'])))));
		echo ife($this->data['BookStandAuthor']['name'] ,$bs->tab(2 ,h(' | written by ' . $this->data['BookStandAuthor']['name'])));
?>

	</div>
	<div class="bookStandArticleMain">
<?php echo $bs->includeArticle($this->data['BookStandArticle']['id']); ?>

	</div>
	<?php echo $bs->tab(1 ,$this->element('comment_box')) ?>

</div>
