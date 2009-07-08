<h3>アーカイブ</h3>
<ul>
<?php
	$months = $this->requestAction(Router::url($bs->url(array('controller'=>"book_stand_articles" ,'action'=>"monthly_list"))));
	foreach ($months as $month => $count) :
		$ym = $bs->yearMonth($month);
		$out = '';
		$out .= $bs->link(
			h($ym['text']) . "<span class=\"colorLight\">({$count})</span>",
			$bs->url(array('controller'=>"book_stand_articles",'action'=>"index",'type'=>"date",'year'=>$ym['year'],'month'=>$ym['month'])),
			array() ,false ,false
		);
?>
	<li><?php echo $out; ?></li>
<?php endforeach; ?>
</ul>
