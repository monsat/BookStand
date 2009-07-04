<?php
class BookStandCategoriesController extends BookStandAppController {

	var $name = 'BookStandCategories';
	var $helpers = array('BookStand.Tree');
	
	function index() {
		$conditions = array(
			'BookStandCategory.book_stand_article_count >' => 0,
		);
		$this->data = $this->BookStandCategory->find('all' ,compact('conditions'));
		
		return $this->data;
	}
	function admin_index() {
		$this->setAction('admin_add');
	}
	function admin_add() {
		if (!empty($this->data)) {
			// add
			$this->BookStandCategory->create();
			$this->BookStandCategory->set($this->data);
			if ($this->BookStandCategory->save()) {
				$this->Session->setFlash('正常に投稿されました。');
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		}
		$this->BookStandCategory->setDefault();
	}
	
	function admin_edit($id = null) {
		$this->autoRender = false;
		Configure::write('debug' ,0);
		if (!$id || empty($this->data)) return 'false';
		// save
		$this->BookStandCategory->id = $id;
		$this->BookStandCategory->set($this->data);
		if (!$this->BookStandCategory->save()) return 'false';
		// return tree
		$this->BookStandCategory->setDefault();
		$this->render(null, false);
	}
	
	function admin_moveup($id = null ,$count = 1) {
		return $this->BookStandCategory->move($id , (int)$count);
	}
	
	function admin_movedown($id = null ,$count = 1) {
		$this->autoRender = false;
		return $this->BookStandCategory->move($id , ((int)$count) * -1 );
	}
}
