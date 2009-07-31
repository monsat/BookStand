<?php
class BookStandRevision extends BookStandAppModel {

	var $name = 'BookStandRevision';

	var $validate = array(
		'body' => array(
				'rule' => 'notempty',
			),
	);
	var $belongsTo = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_article_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => '',
		),
	);
}
