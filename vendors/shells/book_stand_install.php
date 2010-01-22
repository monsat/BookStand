<?php

class BookStandInstallShell extends Shell {
	
	var $version = 'beta - 0.5';
	var $output_encode = 'utf-8';
	
	var $plugin_dir;
	var $config_dir;
	var $app_config_dir;
	var $webroot_themed_dir;
	var $upload_dir;
	var $parent_upload_path;
	
	var $config_file_name = 'book_stand_config.php';
	var $routes_file_name = 'book_stand_routes.php';
	
	function startup() {
		parent::startup();
		
		// prepare
		$this->plugin_dir = dirname(dirname(dirname(__FILE__)));
		$this->config_dir = $this->plugin_dir . DS . 'config';
		$this->app_config_dir = $this->params['working'] . DS . 'config';
		$this->webroot_themed_dir = $this->params['webroot'] . DS . 'themed';
		// Configure::read('BookStand') Default
		App::import('Component', 'BookStand.BookStandTool');
		$this->BookStandTool = new BookStandToolComponent($this);
		$this->BookStandTool->config();
		$this->upload_dir = Configure::read('BookStand.edit.files_path');
		$this->parent_upload_path = $this->params['working'] . DS . $this->params['webroot'];
		
		// Welcome Message
		$this->out("BookStand Plugin Installer (Upgrader) {$this->version}");
		$this->out($this->plugin_dir);
		$this->hr();
		//	debug($this->params ,false ,false);
		//	$this->hr();
		// 文字コードを指定する
		$result = $this->in("Can I use Japanese ?\n[D]efault:{$this->output_encode}\n[E]uc-jp\n[U]tf-8\n[N]o ,use English\n" ,array('D','E','U','N') ,'D');
		$encodes = array(
			'D' => $this->output_encode,
			'd' => $this->output_encode,
			'U' => $this->output_encode,
			'u' => $this->output_encode,
			'E' => 'euc-jp',
			'e' => 'euc-jp',
		);
		$this->output_encode = (empty($encodes[ $result ])) ? '' : $encodes[ $result ];
	}
	function main() {
		// データベース
		$this->_database();
		// Store
		$this->_store();
		// 設定ファイル
		$this->_configFiles();
		// Routes
		$this->_routes();
		// シンボリックリンク
		$this->_makeSymLinks();
		// CKFinder
		$this->_makeCkfDir();
	}
	
	function _database() {
		//debug($this->DbConfig ,false ,false);
	}
	
	function _store() {
		$this->hr();
		$this->mbout('Store Directory' ,'Article 保存ディレクトリをコピーします');
		$this->mbout('Checking exist file' ,'ディレクトリの有無を確認します');
		
		$default_store_dir = $this->plugin_dir . DS . 'store.default';
		$app_store_dir = $this->params['working'] . DS . 'store';
		if (file_exists($app_store_dir)) {
			$this->mbout("exists: {$app_store_dir}");
		} else {
			$method = "cp -pR {$default_store_dir} {$app_store_dir}";
			$this->mbout("Copy" ,"コピーします。");
			$this->mbout("> $method");
			if (system($method) !== FALSE) {
				$this->mbout("copied: {$app_store_dir}");
			} else {
				$this->done("failure: {$app_store_dir}" , "コピーできませんでした( {$app_store_dir} )");
			}
		}
	}
	
	function _configFiles() {
		$this->hr();
		$this->mbout('Config Files' ,'設定ファイルをコピーします');
		$this->mbout('Checking exist file' ,'設定ファイルの有無を確認します');
		
		$filename = $this->config_file_name;
		$app_config_file = $this->app_config_dir . DS . $filename;
		if (file_exists($app_config_file)) {
			$this->mbout("exists: {$filename}");
		} else {
			if (copy($this->config_dir . DS . $filename , $app_config_file)) {
				$this->mbout("copied: {$filename}");
				$this->mbout('write this in bootstrap.php , and edit ' . $filename ,"bootstrap.php に以下を記述し、{$filename}の内容を編集してください");
				$this->mbout("\n# " . $this->app_config_dir . DS . 'bootstrap.php');
				$this->mbout("Configure::load('book_stand_config');\n");
				// 継続確認
				$result = $this->in('Continue ?' ,array('Continue' ,'Exit') ,'Continue');
				if ($result == 'Exit') $this->done();
			} else {
				$this->done("failure: {$filename}" , "コピーできませんでした( {$filename} )");
			}
		}
	}
	
	function _routes() {
		$this->hr();
		$this->mbout('routes.php' ,'URLルーティングファイルをコピーします');
		$this->mbout('Checking exist file' ,'ファイルの有無を確認します');
		
		$filename = $this->routes_file_name;
		$app_routes_file = $this->app_config_dir . DS . $filename;
		if (file_exists($app_routes_file)) {
			$this->mbout("exists: {$filename}");
		} else {
			if (copy($this->config_dir . DS . $filename , $app_routes_file)) {
				$this->mbout("copied: {$filename}");
				$this->mbout('write this in routes.php , and edit ' . $filename ,"routes.php に以下を記述し、{$filename}の内容を編集してください");
				$this->mbout("\n# " . $this->app_config_dir . DS . 'routes.php');
				$this->mbout("include('{$app_routes_file }');\n");
				// 継続確認
				$result = $this->in('Continue ?' ,array('Continue' ,'Exit') ,'Continue');
				if ($result == 'Exit') $this->done();
			} else {
				$this->done("failure: {$filename}" , "コピーできませんでした( {$filename} )");
			}
		}
	}
	
	function _makeSymLinks() {
		$themes = array();
		
		$this->hr();
		$this->mbout('Make symlinks' ,'必要ファイルへのシンボリックリンクを作成します');
		$this->mbout('If you can not use symlinks ,copy files' ,'シンボリックリンクが作成できない場合は、ファイルをコピーします');
		$this->mbout('Checking symlinks' ,'ディレクトリの有無を確認します' ,false);
		// plugins/views/themed
		$themed_dir = $this->plugin_dir . DS . 'views' . DS . 'themed';
		$this->__themes($themes ,$themed_dir);
		// app/views/themed
		$themed_dir = $this->params['working'] . DS . 'views' . DS . 'themed';
		if (file_exists($themed_dir)) {
			$this->__themes($themes ,$themed_dir);
		}
		$this->out('');
		
		if (!file_exists($this->params['working'] . DS . $this->webroot_themed_dir)){
			$this->mbout('themed dir in webroot does not exists. making...' , 'webroot に themed ディレクトリがありません。作成します');
			if (!mkdir($this->params['working'] . DS . $this->webroot_themed_dir)) {
				$this->done('can not make the directory' , 'ディレクトリを作成できませんでした');
			}
		}
		
		foreach ($themes as $name => $path) {
			if (!file_exists($from = $this->params['working'] . DS . $this->webroot_themed_dir . DS . $name)){
				if (symlink($themes[ $name ] ,$from)) {
					$this->mbout("symlinked: {$name}");
				} elseif (copy($from ,$themes[ $name ])) {
					$this->mbout("copied: {$name}");
				} else {
					$this->done("failure: {$name}" , "失敗: {$name}");
				}
			} else {
				$this->mbout("exists: {$name}");
			}
		}
	}
	function __themes(&$themes ,$themed_dir) {
		$dir = dir($themed_dir);
		while (($ent = $dir->read()) !== FALSE) {
			$this->mbout(' .' ,'。' ,false);
			$webroot_themed_dir = $themed_dir . DS . $ent . DS . $this->webroot_themed_dir . DS . $ent;
			if (is_dir($themed_dir . DS . $ent) && file_exists($webroot_themed_dir)) {
				$themes[ $ent ] = $webroot_themed_dir;
			}
		}
	}
	
	function _makeCkfDir() {
		$this->hr();
		$this->mbout('Make Directory for CKFinder' ,'CKFinder用のディレクトリを作成します');
		$this->mbout($this->parent_upload_path . $this->upload_dir);
		// ディレクトリチェック
		$dir = trim($this->upload_dir ,'/');
		$dirs = explode('/' ,$dir);
		$count = count($dirs);
		$tmp_dir = $this->parent_upload_path;
		for ($i=0;$i<$count-1;$i++) {
			$tmp_dir .= DS . $dirs[$i];
			if (!file_exists($tmp_dir)){
				$this->mbout("parent dir does not exists. making..." , '上位ディレクトリがありません。作成します');
				if (!mkdir($tmp_dir)) {
					$this->done('can not make the directory' , 'ディレクトリを作成できませんでした');
				}
			}
		}
		if (!file_exists($this->parent_upload_path . $this->upload_dir)){
			$this->mbout("Upload dir does not exists. making..." , 'アップロードディレクトリがありません。作成します');
			if (!mkdir($this->parent_upload_path . $this->upload_dir)) {
				$this->done('can not make the directory' , 'ディレクトリを作成できませんでした');
			}
		} else {
			$this->mbout("exists: {$this->upload_dir}");
		}
	}
	
	function mbout($english ,$japanese = '' ,$newline = true) {
		// 英語のみ or 英語指定
		if (empty($japanese) || empty($this->output_encode)) {
			return parent::out( $english ,$newline );
		}
		return parent::out( mb_convert_encoding($japanese ,$this->output_encode ,'utf-8') ,$newline );
		// 使用例
		$this->mbout('test' ,'テスト');
	}
	
	function done($english = '' ,$japanese = '') {
		$this->mbout('');
		if (!empty($english)) {
			$this->mbout($english ,$japanese);
		}
		$this->mbout('stop installing' ,'中止します');
		$this->mbout('');
		exit;
	}
}