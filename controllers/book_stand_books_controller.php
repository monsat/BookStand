<?php
class BookStandBooksController extends BookStandAppController {

	var $name = 'BookStandBooks';


	function admin_view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandBook', true), array('action'=>'index'));
		}
		$this->set('bookStandBook', $this->BookStandBook->read(null, $id));
	}


	function admin_delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid BookStandBook', true), array('action'=>'index'));
		}
		if ($this->BookStandBook->del($id)) {
			$this->flash(__('BookStandBook deleted', true), array('action'=>'index'));
		}
	}

}
