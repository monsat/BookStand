<?php
class BookStandArticlesController extends BookStandAppController {
	var $name = 'BookStandArticles';
	var $cacheAction = array(
		'view/' => 36000//
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->BookStandArticle->belongsTo['BookStandCategory']['counterScope'] = $this->BookStandArticle->publishConditions();
	}
	function index() {
		if (!empty($this->params['type'])) {
			$names = func_get_args();
			$this->paginate = $this->BookStandArticle->getTypeToOptions($this->params['type'] ,$names);
			$this->data = $this->paginate();
			if (empty($this->data)) {
				$this->Session->setFlash('ページが見つかりません。<br />最新の一覧を表示します。');
			}
		}
		if (empty($this->data)) {
			$this->BookStandArticle->recursive = 0;
			$this->paginate = array(
				'published' => true,
			);
			$this->data = $this->paginate();
		}
		
		return $this->data;
	}
	
	function view($id = null) {
		if (!$id && empty($this->params['id'])) {
			$this->BookStandTool->redirect('ページが見つかりません', array('action'=>'index'));
		}
		$id = empty($this->params['id']) ? $id : $this->params['id'];
		$conditions = array(
			'BookStandArticle.id' => $id,
		);
		$published = true;
		$this->data = $this->BookStandArticle->find('first', compact('conditions','published'));
		if (empty($this->data)) {
			$this->BookStandTool->redirect('ページが存在しないか、削除された可能性があります。<br />最新の一覧を表示します。', array('action'=>'index'));
		}
		$this->BookStandTool->canonical( $this->BookStandTool->articleUrl() );
	}

	function link($id = null) {
		if (!$id || !($id = intval($id))) return '';
		$this->BookStandArticle->recursive = -1;
		$this->data = $this->BookStandArticle->read(null ,$id);
		unset($this->data['BookStandArticle']['body']);
		if (empty($this->data)) return '';
		return serialize($this->data);
	}
	
	function monthly_list($is_zero = false) {
		$contain = array();
		$published = true;
		$articles = $this->BookStandArticle->find('all' ,compact('contain','published'));
		$results = array();
		foreach ($articles as $article) {
			$month = date('Ym' ,strtotime($article['BookStandArticle']['posted']));
			if (empty($results[ $month ])) {
				$results[ $month ] = 1;
			} else {
				$results[ $month ] += 1;
			}
		}
		return $results;
	}

	function admin_index() {
		$this->BookStandArticle->recursive = 0;
		$this->data = $this->paginate();
	}

	function admin_add($id = null) {
		if (!empty($this->data)) {
			$this->BookStandArticle->create();
			$this->BookStandArticle->set($this->data);
			if ($this->BookStandArticle->saveAll()) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					array('action'=>'index')
				);
				return;
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		} elseif (!empty($id)) {
			$this->data = $this->BookStandArticle->read(null, $id);
			$this->data[ $this->modelClass ][ $this->{$this->modelClass}->primaryKey ] = null;
		}
		// default
		$this->{$this->modelClass}->setDefault();
		$this->render('admin_edit');
	}

	function admin_edit($id = null ,$revision_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('記事が見つかりませんでした。');
			$this->BookStandTool->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->BookStandArticle->set($this->data);
			// Revision Update
			$this->BookStandArticle->resetRevisionIdIfCreate();
			if ($this->BookStandArticle->saveAll(null ,array('validate' => 'first'))) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					array('action'=>'index')
				);
				return;
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		} else {
			$this->data = $this->BookStandArticle->read(null, $id);
			if ($revision_id) {
				// 履歴を遡って編集
				$this->data['BookStandRevision'] = null;
				foreach ($this->data['BookStandRevisionHistory'] as $history) {
					if ($history['id'] == $revision_id) break;
				}
				$this->data['BookStandRevision']['body'] = $history['body'];
				$this->data['BookStandArticle']['is_revision'] = 'create';
			} else {
				$this->data['BookStandRevision']['copied_body'] = $this->data['BookStandRevision']['body'];
			}
		}
		// default
		$this->{$this->modelClass}->setDefault('edit');
		$this->{$this->modelClass}->setDefault();
		
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BookStandArticle', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BookStandArticle->del($id)) {
			$this->Session->setFlash(__('BookStandArticle deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function admin_revisions($id = null) {
		if (!$id) {
			$this->Session->setFlash('記事が見つかりませんでした。');
			$this->BookStandTool->redirect(array('action'=>'index'));
		}
		$conditions = array(
			'BookStandArticle.id' => $id,
		);
		$this->data = $this->{$this->modelClass}->find('first' ,compact('conditions'));
	}
	

}
?>