<?php
class BookStandToolComponent extends Object
{
	var $Controller;
	
	function startup(&$controller)
	{
		$this->Controller = $controller;
	}
	
	
	// リダイレクト or メッセージ表示後リダイレクト
	function redirect($message ,$url = array() ,$statusRedirect = 200 ,$flgExit = true)
	{
		// リダイレクトURL
		$url = $this->url($url);
		
		$this->Controller->Session->setFlash( $message );
		if (Configure::read() == 0) {
			$this->Controller->redirect( $url ,$statusRedirect ,$flgExit);
		}else{
			$this->Controller->flash($message ,$url);
		}
	}
	// URL Default
	function url($url = array()) {
		if (is_array($url)) {
			$defaults = array(
				'book' => $this->Controller->Session->read('BookStand.book'),
				'plugin' => 'book_stand',
			);
			// for admin routing
			$admin = Configure::read('BookStand.config.admin');
			if (!empty($this->Controller->params[ $admin ])) {
				$defaults = Set::merge($defaults ,array($admin => true));
			}
			$url = Set::merge($defaults ,$url);
		}
		return $url;
	}
	
	// 内部関数
	// ログインリダイレクト用
	function _loginRedirect()
	{
		$cont_actions = array('Users.add' ,'Users.register' ,'Users.reissue' ,'Users.login' ,'Users.logout' ,'Users.edit_force' ,'Users.ds_login' ,);
		if (
				!in_array($this->Controller->name . '.' . $this->Controller->action ,$cont_actions) &&
					!(isset($this->Controller->params['prefix']) && $this->Controller->params['prefix'] == 'api')
		) {
			$this->Controller->Session->write('Tmp.redirect' ,'/' . $this->Controller->params['url']['url']);
		}
		
	}
}
