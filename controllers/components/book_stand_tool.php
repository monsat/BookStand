<?php
class BookStandToolComponentForOverride extends Object
{
	var $Controller;
	var $_canonical = '';
	
	function startup(&$controller)
	{
		$this->Controller = $controller;
		// security
		if (!empty($this->Controller->Security)) {
			// not use require auth
			$this->Controller->Security->validatePost = false;
			// admin auth
			if (Configure::read('BookStand.admin_auth.basic') && !empty($this->Controller->params['admin'])) {
				$this->Controller->Security->loginOptions = array('type'=>'basic');
				$this->Controller->Security->loginUsers = array(
					Configure::read('BookStand.admin_auth.user') => Configure::read('BookStand.admin_auth.pw'),
				);
				$this->Controller->Security->requireLogin('*');
			}
			// admin post
			if (Configure::read('BookStand.config.isDebug')) {
				$this->Controller->Security->blackHoleCallback = 'blackHoleCallback';
			}
		}
	}
	
	function beforeRender() {
		$this->setCanonical();
		$this->setTitle();
		$this->Controller->set('controller' ,$this->Controller);
		$this->Controller->set('tool' ,$this);
	}
	
	// articleUrl
	function articleUrl($article = array()) {
		if ($article == array()) {
			$article = $this->Controller->data;
		}
		$results = array(
			'admin' => false,
			'controller' => 'book_stand_articles',
			'action' => 'view',
		);
		$allows = Configure::read('BookStand.dynamic_url');
		foreach ($allows as $allow) {
			$results[ $allow ] = $article['BookStandArticle'][ $allow ];
		}
		return $results;
	}
	
	
	// title
	function setTitle() {
		$before = '';
		$after = '';
		$after = Configure::read('BookStand.info.title');
		if (!empty($this->Controller->pageTitle)) {
			$after = ' | ' . $after;
		}
		$this->Controller->pageTitle = $before . $this->Controller->pageTitle . $after;
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
			// for admin routing
			if (!empty($this->Controller->params['admin']) && (!isset($url['admin']) || $url['admin'] != false)) {
				$defaults = array(
					'admin' => true,
					'plugin' => 'book_stand',
				);
			} else {
				$defaults = array(
					'book' => empty($this->Controller->params['book']) ? Configure::read('BookStand.dir.dynamics') : $this->Controller->params['book'],
					'plugin' => 'book_stand',
				);
			}
			$url = Set::merge($defaults ,$url);
		}
		return $url;
	}
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
				'theme' => "book_stand_default_001",			// 'Theme View'を使用しないときは ''
				'admin_theme' => "book_stand_admin_001",		// 'Theme View'を使用しないときは ''
				'admin' => 'admin',
				// Debug Mode
				'isDebug' => false,
			),
			'admin_auth' => array(
				'basic' => true,
				'user' => 'admin',
				'pw' => 'admin',
			),
			'override' => array(
				'components' => false,						// componentsをoverrideするときは、ファイル名を指定する
				'behaviors' => false,						// behaviorsをoverrideするときは、ファイル名を指定する
				'helpers' => false,							// helpersをoverrideするときは、ファイル名を指定する
			),
			'cache' => array(
				'elements' => false,
				'views' => false,
				'html_cache' => false,
			),
			// Site Info Settings
			'info' => array(
				'title' => "Blog Title",
				'description' => "Blog Description",
				'owner' => "Owner Name",
				'owner_profile' => "Owner Profile",
			),
			'dynamic_url' => array('id' ,'slug'),
			'dir' => array(
				'statics' => "info",
				'dynamics' => "blog"
			),
			// Edit
			'edit' => array(
				'editor' => true,
				'config_path' => '',
				'files_path' => '/files/book_stand/',
				'rows' => 10,
				'isRevision' => true,
				'isTab' => false,
			),
			'article' => array(
				'use_comment' => false,
				'div_comment' => 'bookStandArticleComment',
				'comment_anonymous' => "匿名",
				'comment_untitled' => "無題",
			),
			// copyright
			'admin_copyright' => array(
				// Can not override here
				'name' => 'BookStand Plugin on CakePHP',
				'url' => 'http://bookstand.tklabo.net/',
				'help_url' => 'http://bookstand.tklabo.net/info/help/',
			),
			'user_copyright' => array(
				'name' => 'BookStand Plugin on CakePHP',
				'url' => 'http://bookstand.tklabo.net/',
			),
		);
		// ユーザー設定の読み込み
		Configure::write('BookStand' ,Set::merge($default_settings ,Configure::read('BookStand')));
	}
	
}

// Override
if ($components = Configure::read('BookStand.override.components')) {
	App::import('Component' ,$components);
} else {
	class BookStandToolComponent extends BookStandToolComponentForOverride {}
}
