<?php
// BookStand Plugin Config
$config['BookStand']['config']['theme'] = "coffee_n_cream";
#$config['BookStand']['config']['isDebug'] = true;
$config['BookStand']['config']['admin'] = "admin";
// BookStand Edit
$config['BookStand']['edit'] = array(
	//	'editor' => false,
	'config_path' => '/js/book_stand_cke_config.js',
);
// BookStand Plugin Info
$config['BookStand']['info']['title'] = "[ Book Stand ] CakePHP ブログ・プラグイン";
// BookStand Plugin Books
//// static books
$config['BookStand']['dir']['statics'] = 'info';
$config['BookStand']['dir']['dynamics'] = 'blog';

$config['BookStand']['dynamic_url'] = array('id' ,'slug');

