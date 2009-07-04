<?php
class BookStandComment extends BookStandAppModel {

	var $name = 'BookStandComment';
	var $validate = array(
		'title' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
			),
		'author' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => true,
			),
		'author_url' => array(
				'rule' => array('url'),
				'message' => 'URL文字列を確認してください',
				'allowEmpty' => true,
			),
		'author_ip' => array(
				'rule' => array('ip'),
				'allowEmpty' => true,
			),
		'body' => array('notempty'),
		'posted' => array(
				'rule' => array('custom' ,'/^[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])\s([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'),
			),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
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
		'BookStandCommentStatus' => array(
			'className' => 'BookStand.BookStandCommentStatus',
			'foreignKey' => 'book_stand_comment_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => '',
		)
	);

}
