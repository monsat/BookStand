<?php
class BookStandArticle extends BookStandAppModel {

	var $name = 'BookStandArticle';
	var $actsAs = array(
		'BookStand.attribute' => array('posted_status'),
	);
	var $validate = array(
		'title' => array(
				'rule' => array('maxlength' ,255),
				'allowEmpty' => false,
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
		'BookStandBook' => array(
			'className' => 'BookStand.BookStandBook',
			'foreignKey' => 'book_stand_book_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BookStandArticleStatus' => array(
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
	
	function beforeSave() {
		// for search
		$this->data['BookStandArticle']['body'] = strip_tags( $this->data['BookStandRevision']['body'] );
		return true;
	}
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
	
	function posted_status($article) {
		$results = array('status' => '公開' ,'date_type' => '公開' ,'date' => $article['BookStandArticle']['begin_publishing']);
		// draft
		if ($article['BookStandArticle']['book_stand_article_status_id'] == 1) {
			$results = array('status' => '下書き' ,'date_type' => '最終更新' ,'date' => $article['BookStandArticle']['modified']);
		} elseif ($date = $this->is_deleted()) {
		// deleted
			$results = array('status' => '公開終了' ,'date_type' => '公開終了' ,'date' => $date);
		} elseif (strtotime($article['BookStandArticle']['begin_publishing']) > time()) {
		// reserved
			$results['status'] = '投稿予約';
		}
		return $results;
	}
	function is_deleted($current_data = null) {
		if (is_null($current_data)) $current_data = $this->data;
		if ($current_data['BookStandArticle']['deleted'] == true) return $current_data['BookStandArticle']['deleted_time'];
		if ($current_data['BookStandArticle']['book_stand_article_status_id'] == 4) return $current_data['BookStandArticle']['end_publishing'];
		if (strtotime($current_data['BookStandArticle']['end_publishing']) < time()) return $current_data['BookStandArticle']['end_publishing'];
		return false;
	}

}
?>