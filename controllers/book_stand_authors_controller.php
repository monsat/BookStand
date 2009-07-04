<?php
class BookStandAuthorsController extends BookStandAppController {

	var $name = 'BookStandAuthors';

	function index() {
		$this->BookStandAuthor->recursive = 0;
		$this->set('bookStandAuthors', $this->paginate());
	}


	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandAuthor', true), array('action'=>'index'));
		}
		$this->set('bookStandAuthor', $this->BookStandAuthor->read(null, $id));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandAuthor', true), array('action'=>'index'));
		}
		if ($this->BookStandAuthor->del($id)) {
			$this->flash(__('BookStandAuthor deleted', true), array('action'=>'index'));
		}
	}

}
?>