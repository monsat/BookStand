<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class BookStandAppController extends AppController {
	/*
	 * Models
	 * @var BookStandArticle
	 * 
	 * Components
	 * @var BookStandToolComponent
	 * @var BookStandAdminComponent
	 * @var RequestHandlerComponent
	 * @var SessionComponent
	 * @var AuthComponent
	 * @var AclComponent
	 * @var QdmailComponent
	 */
	var $BookStandArticle;
	
	var $BookStandTool;
	var $BookStandAdmin;
	var $RequestHandler;
	var $Session;
	var $Acl;
	var $Auth;
	var $Qdmail;
	
	var $components = array(
			'BookStand.BookStandTool',
//			'BookStand.BookStandAdmin',
			'Session',
		);
	var $helpers = array(
			'Bs',
			'Form',
			'Text',
			'Session',
		);
	function beforeFilter() {
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
				// Debug Mode
				'isDebug' => false,
			),
			// Site Info Settings
			'info' => array(
				'title' => "Blog Title",
				'description' => "Blog Description",
				'owner' => "Owner Name",
				'owner_profile' => "Owner Profile",
			),
			// Edit
			'edit' => array(
				'editor' => true,
				'config_path' => '',
				'rows' => 10,
				'isRevision' => true,
			),
		);
		// ユーザー設定の読み込み
		Configure::write('BookStand' ,Set::merge($default_settings ,Configure::read('BookStand')));
		// Session
		// Book
		if (!empty($this->params['book'])) {
			$this->Session->write('BookStand.book' ,$this->params['book']);
		} else {
			$this->Session->write('BookStand.book' ,null);
		}
		// Books.all
		$static_books = Configure::read('BookStand.books.statics');
		foreach ($static_books as $book) $all_books[ $book['id'] ] = $book['name'];
		$dynamic_books = Configure::read('BookStand.books.dynamics');
		foreach ($dynamic_books as $book) $all_books[ $book['id'] ] = $book['name'];
		Configure::write('BookStand.books.all' ,$all_books);
		
		// Theme
		if (empty($this->params[ Configure::read('BookStand.config.admin') ])) {
			// User Theme
			if (Configure::read('BookStand.config.theme') !== '') {
				$this->view = 'Theme';
				$this->theme = Configure::read('BookStand.config.theme');
			}
		} else {
			// Admin Theme
			if (Configure::read('BookStand.config.admin_theme') !== '') {
				$this->view = 'Theme';
				$this->theme = Configure::read('BookStand.config.admin_theme');
			}
		}
		// Debug Mode
		if (Configure::read('BookStand.config.isDebug')) {
			debug(Configure::read('BookStand.config'));
		}
		// set controller
		$this->{$this->modelClass}->Controller =& $this;
		parent::beforeFilter();
	}
	
	function beforeRender() {
		parent::beforeRender();
	}
}
