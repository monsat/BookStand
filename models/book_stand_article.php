<?php
class BookStandArticle extends BookStandAppModel {

	var $name = 'BookStandArticle';
	var $actsAs = array(
		'BookStand.attribute' => array('posted_status'),
		'BookStand.CounterCacheHabtm',
		'BookStand.Publishable',
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
		'posted' => array(
				'rule' => array('custom' ,'/^[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])\s([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'),
			),
		'draft' => array(
				'rule' => array('boolean'),
			),
		'reserved' => array(
				'rule' => array('boolean'),
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
	
	var $order = array('posted DESC');
	
	var $save_types = array(
		'draft' => '下書き保存',
		'now' => '今すぐ投稿',
		'advanced' => '日時を指定して投稿',
	);
	var $revision_options = array(
		'update' => '前回の履歴に上書き保存',
		'create' => '履歴を残して保存',
	);
	
	var $belongsTo = array(
		'BookStandAuthor' => array(
			'className' => 'BookStand.BookStandAuthor',
			'foreignKey' => 'book_stand_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => '',
		),
		'BookStandCategory' => array(
			'className' => 'BookStand.BookStandCategory',
			'foreignKey' => 'book_stand_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => '',
		),
		'BookStandRevision' => array(
			'className' => 'BookStand.BookStandRevision',
			'foreignKey' => 'book_stand_revision_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
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
			'order' => 'BookStandRevisionHistory.modified DESC'
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
			'insertQuery' => '',
			'counterScope' => array(),
		),
	);
	
	function beforeSave() {
		// for search
		if (!empty($this->data['BookStandRevision'])) {
			// 本文のサマリーを作成
			$this->data['BookStandArticle']['body'] = strip_tags( $this->data['BookStandRevision']['body'] );
		}
		return true;
	}
	function afterSave($created) {
		// id を BookStandRevision book_stand_article_id に
		if (empty($this->data['BookStandRevision']['id'])) {
			$this->BookStandRevision->saveField('book_stand_article_id' ,$this->id);
		}
		
	}
	
	// HABTM用条件追加
	function habtmCounterScope($field) {
		if ($field != 'book_stand_article_count') return array();
		$fields = 'id';
		$published = true;
		$conditions = array('draft' => 0);
		return array('book_stand_article_id' => array_values($this->find('list' ,compact('fields','published','conditions'))));
	}
	
	function resetRevisionIdIfCreate() {
		if ($this->data['BookStandArticle']['is_revision'] == 'create') {
			$body = str_replace("\t",'',$this->data['BookStandRevision']['body']);
			$copied_body = str_replace("\t",'',$this->data['BookStandRevision']['copied_body']);
			if ($body === $copied_body) {
				// 本文の更新がされていなければ履歴を更新しない
				unset( $this->data['BookStandRevision'] );
			} else {
				// 本文更新
				$this->data['BookStandRevision']['id'] = null;
			}
		}
	}
	/**
	 * 投稿ステータスを自動生成
	 * attribute behavior
	 *
	 * @param array $article 単一記事データ
	 * @return array 修正済みの単一記事データ
	 */
	function posted_status($article) {
		$Article = $article['BookStandArticle'];
		// 通常のfind以外では使用しない
		if (!isset($Article['begin_publishing'],$Article['modified'])) {
			return null;
		}
		$results = array();
		$defaults = array(
			'status' => '公開' ,
			'date_type' => '公開' ,
			'icon' => 'accept' ,
			'date_icon' => 'accept' ,
			'date' => $Article['begin_publishing'] ,
		);
		if (!empty($article['deleted'])) {
			// deleted
			$results = array(
				'status' => '削除' ,
				'date_type' => '削除' ,
				'icon' => 'page_white_delete' ,
				'date_icon' => 'calendar_delete' ,
				'date' => $Article['modified'] ,
			);
		} elseif (!empty($Article['draft'])) {
			// draft
			$results = array(
				'status' => '下書き' ,
				'date_type' => '最終更新' ,
				'icon' => 'page_white_edit' ,
				'date_icon' => 'pencil' ,
				'date' => $Article['modified'] ,
			);
		} elseif (!empty($Article['end_publishing']) && strtotime($Article['end_publishing']) < time()) {
			// end publishing
			$results = array(
				'status' => '公開終了' ,
				'date_type' => '公開終了' ,
				'icon' => 'calendar_delete' ,
				'date_icon' => 'calendar_delete' ,
				'date' => $Article['end_publishing'] ,
			);
		} elseif (strtotime($Article['begin_publishing']) > time()) {
			// reserved
			$results = array(
				'status' => '投稿予約',
				'icon' => 'calendar_add',
				'date_icon' => 'calendar_add' ,
			);
		}
		return Set::merge($defaults ,$results);
	}
	
	function setDefault($type = 'common') {
		switch ($type) {
			case 'add':
				
			break;
			case 'edit':
				$bookStandRevisionOptions = $this->revision_options;
				$this->Controller->set(compact('bookStandRevisionOptions'));
		
			break;
			default:
				$bookStandSaveTypes = $this->save_types;
		
				$bookStandTags = $this->BookStandTag->find('list');
				$bookStandAuthors = $this->BookStandAuthor->find('list');
				$bookStandCategories = $this->BookStandCategory->generatetreelist(null ,null ,null ,'-> ');
				$this->Controller->set(compact('bookStandSaveTypes','bookStandRevisionOptions','bookStandTags', 'bookStandAuthors', 'bookStandCategories'));
		}
	}
	
	function getTypeToOptions($type ,$names) {
		$data = array();
		$params = $this->Controller->params;
		$conditions = array(
			'BookStandArticle.draft' => 0,
		);
		$published = true;
		switch ($type) {
			case 'categories':
				$conditions['BookStandCategory.name'] = $names[1];
				return compact('conditions','published');
			break;
			case 'tags':
				unset($names[0]);
				$this->BookStandArticlesBookStandTag->bindModel(array('belongsTo' => array('BookStandTag')));
				$tag_ids = $this->BookStandArticlesBookStandTag->find('list',array(
					'fields' => array(
						'BookStandArticlesBookStandTag.book_stand_article_id',
					),
					'conditions' => array('BookStandTag.name' => $names),
					'recursive' => 0,
				));
				if (($count = count($names)) != 1) {
					$counter = array();
					foreach ($tag_ids as $tag_id) {
						$counter[ $tag_id ] = isset($counter[ $tag_id ]) ? ($counter[ $tag_id ] + 1) : ($count * -1 + 1);
					}
					$tag_ids = array_keys( array_filter($counter ,array($this ,'_filter_id')) );
				}
				
				$conditions['BookStandArticle.id'] = $tag_ids;
				return compact('conditions','published');
				break;
			case 'date':
				if (empty($params['day'])) {
					$dates[] = date('Y-m-d' ,mktime(0 ,0 ,0 ,intval($params['month']) ,1 ,$params['year']));
					$dates[] = date('Y-m-d' ,mktime(0 ,0 ,0 ,intval($params['month']) + 1 ,0 ,$params['year']));
				} else {
					$dates[] = date('Y-m-d' ,mktime(0 ,0 ,0 ,intval($params['month']) ,intval($params['day']) ,$params['year']));
					$dates[] = date('Y-m-d' ,mktime(0 ,0 ,0 ,intval($params['month']) ,intval($params['day']) ,$params['year']));
				}
				$conditions['BookStandArticle.posted BETWEEN ? AND ?'] = $dates;
				return compact('conditions');
			break;
		}
		return $data;
	}
	
	function getIds($model ,$names = array()) {
		foreach ($names as $key => $name) {
			if (!$key) continue;
			$conditions['OR'][] = array($model . '.name' => $name);
		}
		$ids = $this->{$model}->find('list' ,compact('conditions'));
		return array_keys($ids);
	
	}
	
	function _filter_id($count) {
		return ($count == 0);
	}
}
?>