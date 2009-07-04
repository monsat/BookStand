<?php
class BookStandTag extends BookStandAppModel {

	var $name = 'BookStandTag';
	var $actsAs = array(
		'BookStand.CounterCacheHabtm',
	);
	var $order = array('book_stand_article_count DESC','name ASC');
	
	var $validate = array(
		'name' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
			),
		'note' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => true,
			),
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
			'insertQuery' => '',
			'counterScope' => array(),
		)
	);

}
