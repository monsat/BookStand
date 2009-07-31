<?php
class BookStandCategory extends BookStandAppModel {

	var $name = 'BookStandCategory';
	var $actsAs = array(
		'Tree',
	);
	var $validate = array(
		'name' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
			),
	);
	var $order = array('lft ASC');

	var $hasMany = array(
		'BookStandArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'foreignKey' => 'book_stand_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
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
				$this->Controller->set('parents' ,$this->generatetreelist(null ,null ,null ,'　'));
				$this->recursive = -1;
				$order = 'lft ASC';
				$this->Controller->set('bookStandCategories' , $this->find('all' ,compact('order')) );
		}
	}
	
	function move($id = 0 ,$count = 0) {
		$this->Controller->autoRender = false;
		Configure::write('debug' ,0);
		if (!$id || $count == 0) return 'error:' . $id . ':' . $count;
		// true or false
		if ($count > 0) {
			$result = $this->moveup($id ,$count);
		} else {
			$result = $this->movedown($id ,abs($count));
		}
		return $result ? 'true' : 'false';
	}

}
