<h3>タグ別エントリ一覧</h3>
<ul>
<?php
	$tags = $this->requestAction(Router::url($tool->url(array('controller'=>"book_stand_tags",'action'=>"index" ,'request' => true ,'admin' => false))));
	foreach ($tags as $tag) :
		$out = '';
		$out .= $bs->link(
			h($tag['BookStandTag']['name']) . "<span class=\"colorLight\">({$tag['BookStandTag']['book_stand_article_count']})</span>",
			$bs->url(array('controller'=>"book_stand_articles",'action'=>"index",'type'=>"tags",rawurlencode($tag['BookStandTag']['name']) ,'admin' => false)),
			array() ,false ,false
		);
?>
	<li><?php echo $out; ?></li>
<?php endforeach; ?>
</ul>
