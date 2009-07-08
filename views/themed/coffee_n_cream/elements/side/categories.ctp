<h3>カテゴリ別エントリ一覧</h3>
<ul>
<?php
	$categories = $this->requestAction(Router::url($bs->url(array('controller'=>"book_stand_categories",'action'=>"index"))));
	foreach ($categories as $category) :
		$out = '';
		$out .= $bs->link(
			h($category['BookStandCategory']['name']) . "<span class=\"colorLight\">({$category['BookStandCategory']['book_stand_article_count']})</span>",
			$bs->url(array('controller'=>"book_stand_articles",'action'=>"index",'type'=>"categories",rawurldecode($category['BookStandCategory']['name']))),
			array() ,false ,false
		);
?>
	<li><?php echo $out; ?></li>
<?php endforeach; ?>
</ul>
