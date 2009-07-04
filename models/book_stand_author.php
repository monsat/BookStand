<?php
class BookStandAuthor extends BookStandAppModel {

	var $name = 'BookStandAuthor';
	var $validate = array(
		'name' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
			),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_author_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterCache' => true,
			'counterQuery' => ''
		)
	);

}
