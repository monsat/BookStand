<?php
class BookStandArticleStatus extends BookStandAppModel {

	var $name = 'BookStandArticleStatus';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_article_status_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>