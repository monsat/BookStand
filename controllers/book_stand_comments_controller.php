<?php
class BookStandCommentsController extends BookStandAppController {

	var $name = 'BookStandComments';
	var $helpers = array('Xml');
	
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
	
	/**
	 * Trackback受信
	 *
	 * @author Hayden Harnett
	 * @url http://hayden.id.au
	 * @url http://github.com/hharnett/cakephp-trackback-controller
	 * @param string $id
	 */
	function trackback($id = null) {
		Configure::write('debug' ,0);
		// ヘッダーをセット
		$this->RequestHandler->respondAs('xml');
		$this->layoutPath = 'xml';
		
		$error = 1;
		$error_msg = 'failed';
		
		if (isset($this->params['form']) && !empty($this->params['form']) && !empty($id)) {
			// Here I check the blog posts table to make sure that the post specified actually exists in the database
			$conditions = array(
				'id' => $id,
				'static' => 0,
				'draft' => 0,
				'deleted' => 0,
			);
			$recursive = -1;
			$article = $this->BookStandComment->BookStandArticle->find('count', compact('conditions' ,'recursive'));
			if (!empty($article)) {
				if (isset($this->params['form']['url'])) {
					$conditions = array('BookStandComment.author_url' => $this->params['form']['url']);
					$comments = $this->BookStandComment->find('all', compact('conditions'));
					// 同一URLで複数のトラックバックの送信はNGにしている模様
					if (!$this->BookStandComment->find('all', compact('conditions'))) {
						// All data is valid so add a new Trackback record
						// At this point you could add a comment to the post etc
						$this->params['form'] = $this->BookStandTool->convertEncording($this->params['form']);
						$title = empty($this->params['form']['title']) ? $this->params['form']['url'] : $this->params['form']['title'];
						$author = empty($this->params['form']['blog_name']) ? null : $this->params['form']['blog_name'];
						$body = empty($this->params['form']['excerpt']) ? 'trackback article' : $this->params['form']['excerpt'];
						$this->data = array(
							'BookStandComment' => array(
								'book_stand_article_id' => $id,
								'title' => '[Trackback]' . $title,
								'author_url' => $this->params['form']['url'],
								'author' => $author,
								'body' => $body,
							)
						);
						$this->BookStandComment->create();
						$this->BookStandComment->set($this->data);
						if ($this->BookStandComment->save()) {
							$error = 0;
							$error_msg = 'success';
						} else {
							$error_msg = 'can not save';
						}
					} else {
						$error_msg = 'duplicate url';
					}
				} else {
					$error_msg = 'url is nothing';
				}
			} else {
				$error_msg = 'article is nothing';
			}
		}
		
		// Yes this could be improved but it is simple as is and it works
		$data = "<response><error>{$error}</error><message>{$error_msg}</message></response>";
		
		// Set $data - To use this just echo $data in the trackback view (app/views/trackback/xml/index.ctp)
		$this->set('data', $data);
	}
}
