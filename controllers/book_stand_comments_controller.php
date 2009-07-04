<?php
class BookStandCommentsController extends BookStandAppController {

	var $name = 'BookStandComments';
	
	function add($id = null) {
		if (!empty($this->data)) {
			$this->{$this->modelClass}->create();
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->save()) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					$this->data['BookStand']['referer']
				);
				return;
			} else {
				$this->Session->setFlash('修正が必要な項目があります。');
			}
		} elseif (!empty($id)) {
			$this->data = $this->{$this->modelClass}->read(null, $id);
			$this->data[ $this->modelClass ][ $this->{$this->modelClass}->primaryKey ] = null;
			// default
			$this->{$this->modelClass}->setDefault('add');
		}
		// default
		$this->{$this->modelClass}->setDefault();
		$this->render('edit');
	}
}
