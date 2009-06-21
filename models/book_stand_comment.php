<?php
class BookStandComment extends BookStandAppModel {

	var $name = 'BookStandComment';
	var $validate = array(
		'title' => array('notempty'),
		'author_url' => array('url'),
		'author_ip' => array('ip'),
		'posted' => array('time')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
/*		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BookStandUser' => array(
			'className' => 'BookStand.BookStandUser',
			'foreignKey' => 'book_stand_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
*/		'BookStandCommentStatus' => array(
			'className' => 'BookStand.BookStandCommentStatus',
			'foreignKey' => 'book_stand_comment_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>