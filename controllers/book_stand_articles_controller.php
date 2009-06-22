<?php
class BookStandArticlesController extends BookStandAppController {

	var $name = 'BookStandArticles';
	var $helpers = array('Fck');

	function index() {
		$this->BookStandArticle->recursive = 0;
		$this->set('bookStandArticles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BookStandArticle.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->data = $this->BookStandArticle->read(null, $id);
		
	}


	function admin_index() {
		$this->BookStandArticle->recursive = 0;
		$this->set('bookStandArticles', $this->paginate());
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
		$bookStandBooks = $this->BookStandArticle->BookStandBook->find('list');
		$bookStandSaveTypes = $this->BookStandArticle->save_types;
		$bookStandArticleStatuses = $this->BookStandArticle->BookStandArticleStatus->find('list');

//		$bookStandTags = $this->BookStandArticle->BookStandTag->find('list');
//		$bookStandAuthors = $this->BookStandArticle->BookStandAuthor->find('list');
//		$bookStandCategories = $this->BookStandArticle->BookStandCategory->find('list');
//		$this->set(compact('bookStandBooks','bookStandSaveTypes','bookStandRevisionOptions','bookStandTags', 'bookStandReferenceArticles', 'bookStandArticleStatuses', 'bookStandAuthors', 'bookStandCategories', 'bookStandRevisions'));
		$this->set(compact('bookStandBooks','bookStandSaveTypes','bookStandRevisionOptions', 'bookStandArticleStatuses'));
		$this->render('admin_edit');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('記事が見つかりませんでした。');
			$this->BookStandTool->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->BookStandArticle->set($this->data);
			// Revision Update
			$this->BookStandArticle->resetRevisionIdIfCreate();
			if ($this->BookStandArticle->saveAll()) {
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
			$this->data = $this->BookStandArticle->read(null, $id);
		}
		$bookStandBooks = $this->BookStandArticle->BookStandBook->find('list');
		$bookStandSaveTypes = $this->BookStandArticle->save_types;
		$bookStandRevisionOptions = $this->BookStandArticle->revision_options;
		$bookStandArticleStatuses = $this->BookStandArticle->BookStandArticleStatus->find('list');

//		$bookStandTags = $this->BookStandArticle->BookStandTag->find('list');
//		$bookStandAuthors = $this->BookStandArticle->BookStandAuthor->find('list');
//		$bookStandCategories = $this->BookStandArticle->BookStandCategory->find('list');
//		$this->set(compact('bookStandBooks','bookStandSaveTypes','bookStandRevisionOptions','bookStandTags', 'bookStandReferenceArticles', 'bookStandArticleStatuses', 'bookStandAuthors', 'bookStandCategories', 'bookStandRevisions'));
		$this->set(compact('bookStandBooks','bookStandSaveTypes','bookStandRevisionOptions', 'bookStandArticleStatuses'));
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

}
?>