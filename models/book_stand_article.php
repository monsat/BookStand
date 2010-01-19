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
	var $_revision = null;
	
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
	
	function afterFind($results ,$primary) {
/*	if ($primary) {
			foreach ($results as $key => &$result) {
				if (!empty($result['BookStandArticle'])) {
					$result['BookStandArticle']['revision'] = $this->readRevision($result['BookStandArticle']['id']);
				}
			}
		}*/
		return $results;
	}
	function beforeSave() {
		// for search
		// 本文のサマリーを作成
		$this->_revision = $this->data['BookStandArticle'];
		$this->data['BookStandArticle']['body'] = strip_tags( $this->data['BookStandArticle']['revision'] );
		return true;
	}
	function afterSave($created) {
		// 記事ファイルの保存
		$this->saveRevision();
		$this->_revision = null;
	}
	// HABTM用条件追加
	function habtmCounterScope($field) {
		if ($field != 'book_stand_article_count') return array();
		$fields = 'id';
		$published = true;
		$conditions = array('draft' => 0);
		return array('book_stand_article_id' => array_values($this->find('list' ,compact('fields','published','conditions'))));
	}
	// 記事ファイルの読み込み
	function readRevision($id ,$is_all_revisions = false) {
		// values
		$heads_dir = $this->headsPath($id);
		if ($is_all_revisions) {
		// 単一記事の全履歴取得
			$results = array();
			$revisions_dir = $this->revisionsPath($id);
			$folder = new Folder($revisions_dir);
			$revisions = $folder->find('[0-9a-f]+\.html\.php');
			// 現在の記事
			$results["{$id}.html.php"] = file_get_contents($heads_dir . DS . "{$id}.html.php");
			foreach ($revisions as $revision) {
				$results[$revision] = file_get_contents($revisions_dir . DS . $revision);
			}
			return $results;
		} elseif (!is_numeric($id)) {
			// 特定の履歴
			$revisions_dir = $this->revisionsPath($id);
			return file_get_contents($revisions_dir . DS . "{$id}.html.php");
		} else {
			// 現在の記事
			$heads_file = $heads_dir . DS . "{$id}.html.php";
			return file_get_contents($heads_file);
		}
	}
	// 記事ファイル（特定の履歴）の読み込み
	function readRevisionFile($id ,$hash) {
		// values
		$heads_dir = $this->headsPath($id);
		// 特定の履歴
		$revisions_dir = $this->revisionsPath($id);
		return file_get_contents($revisions_dir . DS . "{$hash}.html.php");
	}
	// 記事ファイルの保存
	function saveRevision() {
		// values
		$id = $this->id;
		$article = $this->_revision;
		$heads_dir = $this->headsPath($id);
		$heads_file = $heads_dir . DS . "{$id}.html.php";
		// 保存前の履歴をコピーする
		$is_copy_revision = empty($article['is_revision']) || $article['is_revision'] == 'create';
		if ($is_copy_revision && file_exists($heads_file)) {
			$revisions_dir = $this->revisionsPath($id);
			$revisions_file = $revisions_dir . DS . md5_file($heads_file) . ".html.php";
			copy($heads_file ,$revisions_file);
		}
		// 保存
		if ($file = new File($heads_file ,true)) {
			$body = $file->prepare($article['revision']);
			$file->write($body);
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Storeディレクトリのパスを返す
	 * @param int $id 記事ID
	 * @return string ディレクトリのパス
	 */
	function headsPath($id) {
		return APP . Configure::read("BookStand.edit.store_path") . DS . 'heads';
	}
	/**
	 * Storeディレクトリのパスを返す
	 * @param int $id 記事ID
	 * @return string ディレクトリのパス
	 */
	function revisionsPath($id) {
		$path = APP . Configure::read("BookStand.edit.store_path") . DS . 'revisions' . DS . $id;
		if (!file_exists($path)) {
			mkdir($path);
		}
		return $path;
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
			'BookStandArticle.static' => 0,
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
					$dates[] = date('Y-m-d' ,mktime(23 ,59 ,59 ,intval($params['month']) + 1 ,0 ,$params['year']));
				} else {
					$dates[] = date('Y-m-d' ,mktime(0 ,0 ,0 ,intval($params['month']) ,intval($params['day']) ,$params['year']));
					$dates[] = date('Y-m-d' ,mktime(23 ,59 ,59 ,intval($params['month']) ,intval($params['day']) ,$params['year']));
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