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
	/**
	 * BookStandArticle Model
	 * @var BookStandArticle
	 */
	var $BookStandArticle;
	/**
	 * BookStandArticle Model
	 * @var BookStandCategory
	 */
	var $BookStandCategory;
	/**
	 * BookStandArticle Model
	 * @var BookStandComment
	 */
	var $BookStandComment;
	/**
	 * BookStandArticle Model
	 * @var BookStandTag
	 */
	var $BookStandTag;
	
	/**
	 * BookStandToolComponent Component
	 * @var BookStandToolComponent
	 */
	var $BookStandTool;
	/**
	 * BookStandAdminComponent Component
	 * @var BookStandAdminComponent
	 */
	var $BookStandAdmin;
	/**
	 * RequestHandlerComponent Component
	 * @var RequestHandlerComponent
	 */
	var $RequestHandler;
	/**
	 * SessionComponent Component
	 * @var SessionComponent
	 */
	var $Session;
	/**
	 * SecurityComponent Component
	 * @var SecurityComponent
	 */
	var $Security;
	/**
	 * AclComponent Component
	 * @var AclComponent
	 */
	var $Acl;
	/**
	 * AuthComponent Component
	 * @var AuthComponent
	 */
	var $Auth;
	/**
	 * QdmailComponent Component
	 * @var QdmailComponent
	 */
	var $Qdmail;
	
	var $components = array(
			'BookStand.BookStandTool',
//			'BookStand.BookStandAdmin',
			'Session',
			'RequestHandler',
			'Security',
		);
	var $helpers = array(
			'BookStand.Bs',
			'Html',
			'Form',
			'Text',
			'Session',
			'Cache',
		);
	function beforeFilter() {
		// ユーザー設定の読み込み
		$this->BookStandTool->config();
		// Session
		// Book
		if (empty($this->params['book'])) {
			$this->params['book'] = Configure::read('BookStand.info.is_subdomain');
		}
		// Theme
		if (empty($this->params['admin']) && Configure::read('BookStand.config.theme') !== '') {
			// User Theme
			$this->view = 'Theme';
			$this->theme = Configure::read('BookStand.config.theme');
		} elseif (Configure::read('BookStand.config.admin_theme') !== '') {
			// Admin Theme
			$this->view = 'Theme';
			$this->theme = Configure::read('BookStand.config.admin_theme');
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
	
	// Common Actions
	
	function admin_index() {
		$this->{$this->modelClass}->recursive = 0;
		$this->data = $this->paginate();
	}
	
	function admin_add($id = null) {
		if (!empty($this->data)) {
			$this->{$this->modelClass}->create();
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->save()) {
				$this->BookStandTool->redirect(
					'正常に投稿されました。',
					array('action'=>'index')
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
		$this->render('admin_edit');
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid BookStandBook', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->{$this->modelClass}->set($this->data);
			if ($this->{$this->modelClass}->save()) {
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
			$this->data = $this->{$this->modelClass}->read(null, $id);
			// default
			$this->{$this->modelClass}->setDefault('edit');
		}
		// default
		$this->{$this->modelClass}->setDefault();
	}
	
	function blackHoleCallback($error) {
		debug($error);
	}
}
