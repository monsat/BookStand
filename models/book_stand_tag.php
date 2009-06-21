<?php
class BookStandTag extends BookStandAppModel {

	var $name = 'BookStandTag';
	var $validate = array(
		'name' => array('notempty'),
		'note' => array('maxlength')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'joinTable' => 'book_stand_articles_book_stand_tags',
			'foreignKey' => 'book_stand_tag_id',
			'associationForeignKey' => 'book_stand_article_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>