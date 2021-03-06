<?php
class BookStandTagsController extends BookStandAppController {

	var $name = 'BookStandTags';

	function index() {
		$conditions = array(
			'BookStandTag.book_stand_article_count >' => 0,
		);
		$contain = array(
			'BookStandArticle' => array(
				'conditions' => Set::merge(
					array('BookStandArticle.static' => 0),
					$this->BookStandTag->BookStandArticle->publishConditions()
				),
				'fields' => array(),
			),
		);
		$this->data = $this->BookStandTag->find('all' ,compact('conditions','contain'));
		return $this->data;
	}


	function admin_index() {
		$this->BookStandTag->recursive = 0;
		$this->data = $this->paginate();
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandTag', true), array('action'=>'index'));
		}
		$this->set('bookStandTag', $this->BookStandTag->read(null, $id));
	}

	function admin_add($id = null) {
		if (!empty($this->data)) {
			$this->BookStandTag->create();
			if ($this->BookStandTag->save($this->data)) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					array('action'=>'index')
				);
				return;
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		} elseif (!empty($id)) {
			$this->data = $this->{$this->modelClass}->read(null, $id);
			$this->data[ $this->modelClass ][ $this->{$this->modelClass}->primaryKey ] = null;
		}
		$this->BookStandTag->setDefault();
		$this->render('admin_edit');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid BookStandTag', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->BookStandTag->save($this->data)) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					array('action'=>'index')
				);
				return;
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BookStandTag->read(null, $id);
		}
		$this->BookStandTag->setDefault();
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandTag', true), array('action'=>'index'));
		}
		if ($this->BookStandTag->del($id)) {
			$this->flash(__('BookStandTag deleted', true), array('action'=>'index'));
		}
	}

}
