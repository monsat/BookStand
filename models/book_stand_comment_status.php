<?php
class BookStandCommentStatus extends BookStandAppModel {

	var $name = 'BookStandCommentStatus';
	var $validate = array(
		'name' => array('notempty'),
		'note' => array('maxlength')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'BookStandComment' => array(
			'className' => 'BookStand.BookStandComment',
			'foreignKey' => 'book_stand_comment_status_id',
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