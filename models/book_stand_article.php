<?php
class BookStandArticle extends BookStandAppModel {

	var $name = 'BookStandArticle';
	var $validate = array(
		'title' => array(
				'rule' => 'notempty',
			),
		'slug' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => true,
			),
		'mbslug' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => true,
			),
		'posted' => array(
				'rule' => array('custom' ,'/^[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])\s([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'),
			),
		'begin_publishing' => array(
				'rule' => array('custom' ,'/^[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])\s([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'),
				'allowEmpty' => true,
			),
		'end_publishing' => array(
				'rule' => array('custom' ,'/^[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])\s([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'),
				'allowEmpty' => true,
			),
	);
	
	var $books = array();
	var $save_types = array(
		'draft' => '下書き保存',
		'now' => '今すぐ投稿',
		'advanced' => '日時を指定して投稿',
	);
	var $revision_options = array(
		'update' => '前回の履歴に上書き保存',
		'create' => '履歴を残して保存',
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
/*		'BookStandBook' => array(
			'className' => 'BookStand.BookStandBook',
			'foreignKey' => 'book_stand_book_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
*/		'BookStandArticleStatus' => array(
			'className' => 'BookStand.BookStandArticleStatus',
			'foreignKey' => 'book_stand_article_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BookStandAuthor' => array(
			'className' => 'BookStand.BookStandAuthor',
			'foreignKey' => 'book_stand_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BookStandCategory' => array(
			'className' => 'BookStand.BookStandCategory',
			'foreignKey' => 'book_stand_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BookStandRevision' => array(
			'className' => 'BookStand.BookStandRevision',
			'foreignKey' => 'book_stand_revision_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasOne = array(
	);

	var $hasMany = array(
		'BookStandComment' => array(
			'className' => 'BookStand.BookStandComment',
			'foreignKey' => 'book_stand_article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BookStandRevisionHistory' => array(
			'className' => 'BookStand.BookStandRevision',
			'foreignKey' => 'book_stand_article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'BookStandTag' => array(
			'className' => 'BookStand.BookStandTag',
			'joinTable' => 'book_stand_articles_book_stand_tags',
			'foreignKey' => 'book_stand_article_id',
			'associationForeignKey' => 'book_stand_tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'RelatedArticle' => array(
			'className' => 'BookStand.BookStandArticle',
			'joinTable' => 'book_stand_relations',
			'foreignKey' => 'book_stand_article_id',
			'associationForeignKey' => 'book_stand_related_article_id',
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
	
	function afterSave($created) {
		// id を BookStandRevision book_stand_article_id に
		if (empty($this->data['BookStandRevision']['id'])) {
			$this->BookStandRevision->saveField('book_stand_article_id' ,$this->id);
		}
		
	}
	
	
	function resetRevisionIdIfCreate() {
		if ($this->data['BookStandArticle']['is_revision'] == 'create') {
			$this->data['BookStandRevision']['id'] = null;
		}
	}
	function bookStandBooksList() {
		if (!empty($this->books)) return $this->books;
		$config_books = Configure::read('BookStand.books');
		$results['ページ'] = $this->_booksList($config_books['statics']);
		$results['ブログ'] = $this->_booksList($config_books['dynamics']);
		return $results;
	}
	function _booksList($books) {
		$book_name = $this->Controller->Session->read('BookStand.book');
		foreach ($books as $book) {
			$results[ $book['id'] ] = $book['name'];
			if ($book['dir'] == $book_name) {
				$this->Controller->Session->write('BookStand.book_id' ,$book['id']);
			}
		}
		return $results;
	}

}
?>