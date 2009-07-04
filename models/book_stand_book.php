<?php
class BookStandBook extends BookStandAppModel {
	var $name = 'BookStandBook';
	var $validate = array(
		'name' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
			),
		'dir' => array(
				'rule' => array('custom' ,'[a-z]{1,255}'),
				'message' => '半角アルファベットで入力してください。',
				'allowEmpty' => false,
			),
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_book_id',
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
