<?php
/**
 * BookStand Plugin Original Helper
 *
 */
class BsHelper extends Helper
{
	var $helpers = array('Html' ,'Form' ,'Time' ,'Session' ,'Javascript');
	var $monthNames = array('1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月');
	var $articles = array(
	);
	
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * HtmlHelper::linkの拡張
	 * リバースルーティング用
	 *
	 * @param string $title 以下すべてHtmlHelperと同一
	 * @param mixed $url
	 * @param array $htmlattributes
	 * @param array $confirmMessage
	 * @param array $escapeTitle
	 * @return string 出力文字列
	 */
	function link($title ,$url = null ,$htmlattributes = array() ,$confirmMessage = false ,$escapeTitle = true) {
		return $this->Html->link($title ,$this->url($url) ,$htmlattributes ,$confirmMessage ,$escapeTitle);
	}
	/**
	 * リバースルーティング用URLの生成
	 *
	 * @param mixed $url 以下すべてHtmlHelperと同一
	 * @return mixed Router用URL
	 */
	function url($url = array()) {
		if (is_array($url)) {
			$view = ClassRegistry::getObject('view');
			$defaults = array(
				'book' => $this->Session->read('BookStand.book'),
				'plugin' => 'book_stand',
			);
			// for admin routing
			$admin = Configure::read('BookStand.config.admin');
			if (!empty($view->params[ $admin ])) {
				$admin_defaults = array(
					$admin => true,
				);
				$defaults = Set::merge($defaults ,$admin_defaults);
			}
			$url = Set::merge($defaults ,$url);
		}
		//	debug($url);
		//	debug(Router::url($url));
		return $url;
	}
	/**
	 * FormHelperの$options用URLを自動生成する
	 *
	 * @return array 出力文字列
	 */
	function urls() {
		return array('url' => $this->url());
	}
	/**
	 * admin(prefix)ルーティング用に現在のアクションよりprefixを削除したアクション名を返す
	 * ex) admin_index -> index
	 * 
	 * @return string 出力文字列
	 */
	function getAction() {
		$view = ClassRegistry::getObject('view');
		$admin = Configure::read('BookStand.config.admin');
		if (empty($view->params[ $admin ])) return $view->params['action'];
		return substr($view->params['action'] ,strlen($view->params['prefix']) + 1);
	}
	// layout用
	/**
	 * htmlにタブを挿入する
	 *
	 * @param int $n タブ数
	 * @param string $output 入力文字列
	 * @param string $code 改行コード
	 * @return string 出力文字列
	 */
	function tab($n = 1 ,$output = '' ,$code = "\n") {
		$lines = explode($code ,$output);
		$tabs = str_repeat("\t" ,$n);
		$out = implode($code . $tabs ,$lines);
		return $out;
	}
	/**
	 * エレメントのhtmlにタブを挿入する
	 *
	 * @param int $n タブ数
	 * @param string $element エレメント名
	 * @param array $params Html::elementを参照
	 * @param boolean $loadHelpers Html::elementを参照
	 * @return string 出力文字列
	 */
	function tabElement($n ,$element ,$params = array() ,$loadHelpers = false) {
		$view = ClassRegistry::getObject('view');
		return $this->tab($n ,$view->element($element ,$params ,$loadHelpers));
	}
	
	/**
	 * 続きを読むリンク作成
	 *
	 * @param string $body
	 * @param mixed $url BsHelper::url
	 * @param string $link_text HtmlHelper::link
	 * @param array $link_attr HtmlHelper::link
	 * @param string $separator この文字列以降を続きと見なす
	 * @return string 出力文字列
	 */
	function readMore($body ,$url = null ,$link_text = '続きを読む' ,$link_attr = array('rel' => 'nofollow') ,$separator = '<!-- BookStand Read More -->') {
		$out = substr($body ,0 ,strpos($body ,$separator) + strlen($separator));
		if (is_null($url)) return $out;
		$out = '<div class="bookStandReadMore">' . $this->Html->link($link_text ,$this->url($url)) . '</div>';
		return $out;
	}
	/**
	 * HEAD用JavaScript読み込みリンクを生成
	 *
	 * @return string 出力文字列
	 */
	function head_js_load()
	{
		$out = '';
		$out .= '<script type="text/javascript" src="http://www.google.com/jsapi"></script><script>google.load("jquery", "1.3.2");</script>';
		if (!empty($this->params[ Configure::read('BookStand.config.admin') ])) {
			$out .= $this->Javascript->link('bookstand.admin');
		}
		$out .= $this->Javascript->link(
			array(
				'jquery/jquery.corner',
				'jquery/jquery.jgrowl',
				'ckeditor/ckeditor',
/*		
				'jquery/jquery.ui',
				'jquery/jquery.ui.draggable',
				'jquery/jquery.ui.resizable',
				'jquery/jquery.ui.sortable',
				'wymeditor/jquery.wymeditor.pack',
				'wymeditor/plugins/hovertools/jquery.wymeditor.hovertools',
				'wymeditor/plugins/resizable/jquery.wymeditor.resizable',
			
*/
			)
		);
		return $out;
	}
	/**
	 * JavaScript用リンクを生成
	 *
	 * @param string $id ID属性
	 * @param string $class class属性
	 * @param string $text リンク文字列
	 * @return string 出力文字列
	 */
	function jsLink($id ,$class='' ,$text = '開閉') {
		return $this->Html->link($text ,'javascript:void(0)' ,aa('id',$id,'class',$class));
	}
	/**
	 * Wrap Script Tag and jQuery's window.onload
	 *
	 * @param string $scripts JavaScript文字列
	 * @param boolean $wrap trueでscriptタグ生成
	 * @return string output
	 */
	function jquery($scripts ,$wrap = true) {
		if (is_array($scripts)) {
			$scripts = implode("\n" ,$scripts);
		}
		$out = "$(function(){\n\t{$this->tab(1 ,$scripts)}\n});";
		if (!empty($wrap)) {
			$out = "<script type=\"text/javascript\">\n\t{$this->tab(1 ,$out)}\n</script>";
		}
		return $out;
	}
	/**
	 * 編集画面用注意事項
	 *
	 * @param string $title 注意事項のタイトル
	 * @param mixed $body 
	 * @param int $hidden この数値の分は初期状態で表示されます。以降の分は開閉して開きます。
	 * @return string
	 */
	function editNotes($title ,$body = array() ,$hidden = 0) {
		$out = "<h4>{$title}</h4>";
		if (!is_array($body)) $body = array($body);
		$last = count($body) - 1;
		if ($hidden) $id = 'bsToggleHelp' . substr( md5($title . implode('' ,$body)) ,0 ,8 );
		foreach ($body as $key => $p) {
			$out .= ($key == $hidden ? $this->jquery("BookStandAdmin.toggle('#{$id}');") . '<div id="' . $id . 'Target" class="jsHide">' : '')
					. '<p' . ($key == $last ? ' class="last">' : '>') . $p . '</p>'
					. ($key == $last ? '</div>' : '')
					. ($key == $last && $hidden != 0 ? '<div class="alignRight">' . $this->jsLink($id ,'' ,'すべて表示') . '</div>' : '');
		}
		$out = '<div class="notes">' . $out . '</div>';
		return $out;
	}
	/**
	 * CKeditor用のTextAreaを生成
	 * configでCKeditorを使用しない場合は通常のTextAreaタグを出力
	 *
	 * @param string $fieldName FormHelper::inputと同一
	 * @param array $options FormHelper用
	 * @return string 出力文字列
	 */
	function ckeditor($fieldName, $options = array()) {
		$options = array_merge($options, array('type' => 'textarea'));
		$out = $this->Form->input($fieldName, $options);
		// not use editor
		if (Configure::read('BookStand.edit.editor') == false) return $out;
		// custom config
		$path = Configure::read('BookStand.edit.config_path');
		$config = !empty($path) ? " ,{customConfig : CKEDITOR.getUrl( '{$path}' )}" : '';
		// name
		preg_match('/\sname="(.+?)"/' ,$out ,$results);
		// output
		$out .= "\n" .
			$this->jquery(array(
				"CKEDITOR.replace('{$results[1]}'{$config});",
			));
		return $out;
	}
	/**
	 * 和暦対応 date()の拡張
	 * 日付文字列に Vv年 と指定すると 昭和60年 のように出力可能
	 *
	 * @param string $format date()と同一
	 * @param int $timestamp date()と同一
	 * @return string 出力文字列
	 */
	function jDate($format, $timestamp = null){
		//	function jdate($format, $timestamp = null){
		if ($timestamp === null) {
			$timestamp = time();
		}
		$ymd = date('Ymd', $timestamp);
		$year = date('Y', $timestamp);
		if ($ymd <= "19120729") {
			$label = "明治";
			$wareki = $year - 1867;
		} else if ($ymd >= "19120730" && $ymd <= "19261224") {
			$label = "大正";
			$wareki = $year - 1911;
		} else if ($ymd >= "19261225" && $ymd <= "19890107") {
			$label = "昭和";
			$wareki = $year - 1925;
		} else if ($ymd >= "19890108") {
			$label = "平成";
			$wareki = $year - 1988;
		}
	
		$ret = date($format, $timestamp);
		$ret = str_replace('V', $label, $ret);
		$ret = str_replace('v', $wareki, $ret);
		return $ret;
	}
	/**
	 * 日付を整形する
	 *
	 * @param string $dateString 日付文字列
	 * @return string
	 */
	function niceShort($dateString)
	{
		$date = $dateString ? $this->Time->fromString($dateString) : time();
		
		if ($this->Time->isThisMonth($date)) {
			$out = date("j日H:i", $date);
		} else {
			$ymd = $this->Time->isThisYear($date) ? 'n月j日' : 'Y年n月';
			$out = date($ymd, $date);
		}
		return $out;
	}
}
