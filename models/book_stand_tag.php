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

	function setDefault($type = 'common') {
		switch ($type) {
			case 'add':
				
			break;
			case 'edit':
				
			break;
			default:
				$conditions = array('BookStandArticle.static' => 0);
				$bookStandArticles = $this->BookStandArticle->find('list',compact('conditions'));
				$this->Controller->set(compact('bookStandArticles'));
		}
	}
	
}
