<?php
class BookStandToolComponentForOverride extends Object
{
	var $Controller;
	var $_canonical = '';
	
	function startup(&$controller)
	{
		$this->Controller = $controller;
	}
	
	function beforeRender() {
		$this->setCanonical();
		$this->Controller->set('controller' ,$this->Controller);
		$this->Controller->set('tool' ,$this);
	}
	
	// articleUrl
	function articleUrl($type = 'dynamic' ,$article = array()) {
		if ($article == array()) $article = $this->Controller->data;
		$action = 'index';
		switch ($type) {
			case 'dynamic':
			case 'static':
				if ( empty($this->params['book']) || !($allows = Configure::read('BookStand.url.' . $this->params['book'])) ) {
					$allows = Configure::read('BookStand.allurl.' . $type);
				}
				$action = 'view';
			break;
		}
		$results = array(
			'controller' => 'book_stand_articles',
			'action' => $action,
		);
		foreach ($allows as $allow) {
			$results[ $allow ] = $article['BookStandArticle'][ $allow ];
		}
		return $results;
	}
	
	
	// canonical
	function canonical($url) {
		$this->_canonical = $url;
	}
	function setCanonical() {
		$href = $this->_canonical;
		if (is_array($href)) $href = Router::url($this->url($href) ,true);
		$this->Controller->set('canonical' ,$href);
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
				'book' => $this->Controller->params['book'],
				'plugin' => 'book_stand',
			);
			// for admin routing
			if (!empty($this->Controller->params['admin'])) {
				$defaults = Set::merge($defaults ,array('admin' => true));
			}
			$url = Set::merge($defaults ,$url);
		}
		return $url;
	}
	// 
	/**
	 * 初期設定を行ないます。
	 * このメソッドは$this->startup()よりも先に実行されます。
	 *
	 */
	function config() {
		// 設定初期値
		$default_settings = array(
			// Plugin Settings
			'config' => array(
				// This Plugin Version
				'version' => "0.0.1",
				// main
				'db_scheme' => "1",
				'theme' => "book_stand_default_001",		// 'Theme View'を使用しないときは ''
				'admin_theme' => "book_stand_admin_001",		// 'Theme View'を使用しないときは ''
				'admin' => 'admin',
				// Debug Mode
				'isDebug' => false,
			),
			'override' => array(
				'components' => false,						// componentsをoverrideするときは、ファイル名を指定する
				'behaviors' => false,						// behaviorsをoverrideするときは、ファイル名を指定する
				'helpers' => false,							// helpersをoverrideするときは、ファイル名を指定する
			),
			'cache' => array(
				'elements' => '1 hour',
				'views' => false,
				'html' => false,
			),
			// Site Info Settings
			'info' => array(
				'title' => "Blog Title",
				'description' => "Blog Description",
				'owner' => "Owner Name",
				'owner_profile' => "Owner Profile",
			),
			'allurl' => array(
				'statics' => array('slug' ,'mbslug'),
				'dynamics' => array('id' ,'mbslug'),
			),
			// Edit
			'edit' => array(
				'editor' => true,
				'config_path' => '',
				'rows' => 10,
				'isRevision' => true,
				'isTab' => false,
			),
			'article' => array(
				'use_comment' => false,
				'div_comment' => 'bookStandArticleComment',
			),
			// copyright
			'admin_copyright' => array(
				// Can not override here
				'name' => 'BookStand Plugin on CakePHP',
				'url' => 'http://bookstand.tklabo.net/',
			),
			'user_copyright' => array(
				'name' => 'BookStand Plugin on CakePHP',
				'url' => 'http://bookstand.tklabo.net/',
			),
		);
		// ユーザー設定の読み込み
		Configure::write('BookStand' ,Set::merge($default_settings ,Configure::read('BookStand')));
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

// Override
if ($components = Configure::read('BookStand.override.components')) {
	App::import('Component' ,$components);
} else {
	class BookStandToolComponent extends BookStandToolComponentForOverride {}
}
