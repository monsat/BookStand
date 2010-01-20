<?php
/* SVN FILE: $Id: routes.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

/*
 * For BookStand Plugin
 */
	// for RSS
	Router::parseExtensions('rss');
	// admin
	$bs_admin = Configure::read('BookStand.config.admin') ? Configure::read('BookStand.config.admin') : 'admin';
	Router::connect("/{$bs_admin}/book_stand/:controller/:action/*", array(
			'prefix' => 'admin', 'plugin' => 'book_stand', 'admin' => true ,
		)
	);
	// 静的ページ
	$bs_book = Configure::read('BookStand.dir.statics') != false ? Configure::read('BookStand.dir.statics') : 'info';
	// /info/static-page-title >>> 静的ページ（タイトルに「/」を含めることができます）
	Router::connect("/:book/:slug/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'view', 'static' => true,
		),array('slug' => "[\/\*\-\.@_\+a-zA-Z0-9]+" ,'book' => $bs_book)
	);
	
	// 動的ページ
	$bs_book = Configure::read('BookStand.dir.dynamics') != false ? Configure::read('BookStand.dir.dynamics') : 'blog';
	// /blog/trackback.xml
	Router::connect("/:book/tb/*", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_comments', 'action' => 'trackback',
		),array('book' => $bs_book)
	);
	// comment
	Router::connect("/:book/comments/:action/*", array(
			'controller' => 'book_stand_comments', 'plugin' => 'book_stand',
		),array('book' => $bs_book)
	);
	// /blog/ >>> ブログのトップ
	Router::connect("/:book/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'index', 'top',
		),array('book' => $bs_book)
	);
	// /blog/index.rss
	Router::connect("/:book/index", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'index', 'top',
		),array('book' => $bs_book)
	);
	// /blog/2009/12/31/encoded-title >>> URLに日付とブログタイトルを含める形式のURLによる記事表示
	Router::connect("/:book/:year/:month/:day/:slug/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'view',
		),
		array('year' => '[12][0-9]{3}', 'month' => '0[1-9]|1[012]', 'day' => '0[1-9]|[12][0-9]|3[01]' ,'slug' => '[\*\-\.@_\+%a-zA-Z0-9]+' ,'book' => $bs_book)
	);
	// /blog/2009/12/ >>> 月別の記事リスト
	Router::connect("/:book/:year/:month/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'index',
			'type' => 'date' ,		// params
		),
		array('year' => '[12][0-9]{3}', 'month' => '0[1-9]|1[012]' ,'book' => $bs_book)
	);
	// /blog/2009/12/31/ >>> 日付別の記事リスト
	Router::connect("/:book/:year/:month/:day/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'index',
			'type' => 'date',		// params
		),
		array('year' => '[12][0-9]{3}', 'month' => '0[1-9]|1[012]', 'day' => '0[1-9]|[12][0-9]|3[01]' ,'book' => $bs_book)
	);
	// /blog/blogID/encoded-title >>> URLにブログIDと記事タイトルを含める形式のURLによる記事表示
	Router::connect("/:book/:id/:slug/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'view',
		),
		array('id' => '[0-9]+' ,'slug' => "[^\/]+" ,'book' => $bs_book)
	);
	// /blog/blogID/ >>> ブログIDのURLによる記事表示
	Router::connect("/:book/:id/", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'view',
	),
		array('id' => '[0-9]+' ,'book' => $bs_book)
	);
	// /blog/tags >>> タグの一覧
	Router::connect("/:book/tags", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_tags', 'action' => 'index',
		),
		array('book' => $bs_book)
	);
	// /blog/categories >>> カテゴリの一覧
	Router::connect("/:book/categories", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_categories', 'action' => 'index',
		),
		array('book' => $bs_book)
	);
	// /blog/tags/tag-name >>> タグ（カテゴリ）別一覧
	Router::connect("/:book/:type/*", array(
			'plugin' => 'book_stand', 'controller' => 'book_stand_articles', 'action' => 'index',
		),
		array('type' => '(tags|categories)' ,'book' => $bs_book)
	);
	// common
	Router::connect("/:book/:controller/:action/*", array(
			'plugin' => 'book_stand',
		),array('book' => $bs_book)
	);
	// requestAction用
	Router::connect("/request/:book/:controller/:action/*", array(
			'plugin' => 'book_stand' ,'request' => true ,
		),array('book' => $bs_book)
	);
	// 当てはまらない場合は 404 not found
	Router::connect('/:book/*', array('controller' => 'nothing'));
/*
 * End Of Routing For BookStand Plugin
 */
	
	/*
	 * 通常のルーティング（プラグイン無し）
	 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
