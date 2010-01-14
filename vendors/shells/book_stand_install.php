<?php

class BookStandInstallShell extends Shell {
	
	var $output_encode = 'utf-8';
	var $plugin_dir;
	var $webroot_themed_dir;
	var $config_file_name = 'book_stand_config.php';
	
	function startup() {
		parent::startup();
		
		// prepare
		$this->plugin_dir = dirname(dirname(dirname(__FILE__)));
		$this->webroot_themed_dir = 'webroot' . DS . 'themed';
		
		// Welcome Message
		$this->out('BookStand Plugin Installer (Upgrader)');
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
		// 設定ファイル
		$this->_configFiles();
		// シンボリックリンク
		$this->_makeSymLinks();
	}
	
	function _database() {
		//debug($this->DbConfig ,false ,false);
	}
	
	function _configFiles() {
		
		
		$this->hr();
		$this->mbout('Config Files' ,'設定ファイルをコピーします');
		$this->mbout('Checking exist file' ,'設定ファイルの有無を確認します');
		
		$config_dir = $this->plugin_dir . DS . 'config';
		$config_file = $this->config_file_name;
		$target_dir = $this->params['working'] . DS . 'config';
		if (file_exists($target_dir . DS . $config_file)) {
			$this->mbout("exists: {$config_file}");
		} else {
			if (copy($config_dir . DS . $config_file , $target_dir . DS . $config_file)) {
				$this->mbout("copied: {$config_file}");
				$this->mbout('write this in bootstrap.php , and edit ' . $config_file ,"bootstrap.php に以下を記述し、{$config_file}の内容を編集してください");
				$this->mbout("\n# " . $target_dir . DS . 'bootstrap.php');
				$this->mbout("Configure::load('book_stand_config');\n");
				// 継続確認
				$result = $this->in('Continue ?' ,array('Continue' ,'Exit') ,'Continue');
				if ($result == 'Exit') $this->done();
			} else {
				$this->done("failure: {$config_file}" , "コピーできませんでした( {$config_file} )");
			}
		}
	}
	
	function _makeSymLinks() {
		$themes = array();
		
		$this->hr();
		$this->mbout('Make symlinks' ,'必要ファイルへのシンボリックリンクを作成します');
		$this->mbout('If you can not use symlinks ,copy files' ,'シンボリックリンクが作成できない場合は、ファイルをコピーします');
		$this->mbout('Checking symlinks' ,'ディレクトリの有無を確認します' ,false);
		
		$themed_dir = $this->plugin_dir . DS . 'views' . DS . 'themed';
		$dir = dir($themed_dir);
		while (($ent = $dir->read()) !== FALSE) {
			$this->mbout(' .' ,'。' ,false);
			$webroot_themed_dir = $themed_dir . DS . $ent . DS . $this->webroot_themed_dir . DS . $ent;
			if (is_dir($themed_dir . DS . $ent) && file_exists($webroot_themed_dir)) {
				$themes[ $ent ] = $webroot_themed_dir;
			}
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