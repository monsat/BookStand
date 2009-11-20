<?php

$this->set('channel', array (
		'title' => Configure::read('BookStand.info.title'),
		'link' => $bs->url(array('controller' => 'book_stand_articles', 'action' => 'index', 'top')),
		'description' => Configure::read('BookStand.info.description'),
	)
);
echo $rss->items($this->data, array($bs, 'rss_transform'));
