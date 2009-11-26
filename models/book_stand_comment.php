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
	);
	
	function beforeSave() {
		if (empty($this->data['BookStandComment']['posted'])) {
			$this->data['BookStandComment']['posted'] = date('Y-m-d H:i:s');
		}
		if (empty($this->data['BookStandComment']['author_ip'])) {
			$this->data['BookStandComment']['author_ip'] = $this->Controller->RequestHandler->getClientIP();
		}
		return true;
	}

}
