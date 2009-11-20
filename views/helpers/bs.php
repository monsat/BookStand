<?php
/**
 * BookStand Plugin Original Helper
 *
 */
class BsHelper extends AppHelper {
	/**
	 * 当ヘルパーで使用するヘルパー
	 * @var array
	 */
	var $helpers = array('Html' ,'Form' ,'Time' ,'Session' ,'Javascript');
	/**
	 * View参照用
	 * @var object
	 */
	var $view;
	/**
	 * タグ変換用メソッド
	 * @var array
	 */
	var $tags = array('_tagLinks');
	
	/**
	 * 呼び出し元のViewを$this->viewに入れる
	 */
	function __construct() {
		$this->view = ClassRegistry::getObject('view');
		parent::__construct();
	}
	/**
	 * HtmlHelper::linkの拡張
	 * リバースルーティング用
	 * $html->link()の代わりに使用。pluginやbook等既定のパラメーターをセットします。
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
			// for admin routing
			if (!empty($this->view->params['admin']) && (!isset($url['admin']) || $url['admin'] !== false)) {
				$defaults = array(
					'admin' => true,
					'plugin' => 'book_stand',
				);
			} else {
				$defaults = array(
					'book' => empty($this->view->params['book']) ? Configure::read('BookStand.dir.dynamics') : $this->view->params['book'],
					'plugin' => 'book_stand',
				);
			}
			$url = Set::merge($defaults ,$url);
		}
		return $url;
	}
	
	/**
	 * admin(prefix)ルーティング用に現在のアクションよりprefixを削除したアクション名を返す
	 * ex) admin_index -> index
	 * 
	 * @return string 出力文字列
	 */
	function getAction() {
		$view = ClassRegistry::getObject('view');
		if (empty($view->params['admin'])) return $view->params['action'];
		return substr($view->params['action'] ,strlen('admin') + 1);
	}
	/**
	 * 実行中のアクションが add or admin_add かどうかを判定します。
	 * trueであれば第一引数に指定した文字列等をfalseであれば第二引数に指定した文字列等を返します。
	 * デフォルトは true / false をそのまま返します。
	 * @param mixed $true addアクション時に返すデータ
	 * @param mixed $false addアクションではない時に返すデータ
	 * @return mixed
	 */
	function isAdd($true = true ,$false = false) {
		return $this->isAction($true ,$false );
	}
	/**
	 * 実行中のアクションが edit or admin_edit かどうかを判定します。
	 * trueであれば第一引数に指定した文字列等をfalseであれば第二引数に指定した文字列等を返します。
	 * デフォルトは true / false をそのまま返します。
	 * @param mixed $true editアクション時に返すデータ
	 * @param mixed $false editアクションではない時に返すデータ
	 * @return mixed
	 */
	function isEdit($true = true ,$false = false) {
		return $this->isAction($true ,$false ,'edit');
	}
	/**
	 * 実行中のアクションが 第三引数で指定したアクションかどうかを判定します。
	 * trueであれば第一引数に指定した文字列等をfalseであれば第二引数に指定した文字列等を返します。
	 * デフォルトは true / false をそのまま返します。
	 * @param mixed $true editアクション時に返すデータ
	 * @param mixed $false editアクションではない時に返すデータ
	 * @return mixed
	 */
	function isAction($true = true ,$false = false ,$action = 'add') {
		$is_action = $this->view->params['action'] == $action || $this->view->params['action'] == 'admin_' . $action;
		return ($is_action) ? $true : $false;
	}
	// layout用
	/**
	 * htmlにタブを挿入します。
	 *
	 * @param int $n タブ数
	 * @param string $output 入力文字列
	 * @param string $code 改行コード
	 * @return string 出力文字列
	 */
	function tab($n = 1 ,$output = '' ,$code = "\n") {
		if (!Configure::read('BookStand.edit.isTab')) return $output;
		$lines = explode($code ,$output);
		$tabs = str_repeat("\t" ,$n);
		$out = implode($code . $tabs ,$lines);
		return $out;
	}
	/**
	 * エレメントのhtmlにタブを挿入します。
	 *
	 * @param int $n タブ数
	 * @param string $element エレメント名
	 * @param array $params Html::elementを参照
	 * @param boolean $loadHelpers Html::elementを参照
	 * @return string 出力文字列
	 */
	function tabElement($n ,$element ,$params = array() ,$loadHelpers = false) {
		return $this->tab($n ,$this->view->element($element ,$params ,$loadHelpers));
	}
	/**
	 * canonical を生成します。
	 * controllerにてcanonicalを設定している場合に動作します。
	 * @return string canonicalが存在しない場合は空の文字列を返します。
	 */
	function canonical() {
		$url = $this->view->getVar('canonical');
		return empty($url) ? '' : "<link rel=\"canonical\" href=\"{$url}\" />";
	}
	// Article用
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
		if ($beforeSeparator = strpos($body ,$separator)) {
			$out = substr($body ,0 ,$beforeSeparator + strlen($separator));
		} else {
			$out = $body;
		}
		if (is_null($url)) {
			return $out;
		} elseif ($beforeSeparator) {
			$out .= '<div class="bookStandReadMore">' . $this->link($link_text ,$url ,$link_attr) . '</div>';
		}
		return $out;
	}
	/**
	 * 本文中の特殊タグを変換します。
	 * $this->tagsで指定したメソッドをすべて実行します。
	 * @param string $body 変換前の本文
	 * @return string 変換後の出力文字列
	 */
	function bsTags($body) {
		$tags = $this->tags;
		foreach ($tags as $tag) $body = $this->{$tag}($body);
		return $body;
	}
	/**
	 * [link id=n xxxx]をArticleID n のリンク文字列に置換します。
	 * xxxxを指定しない場合は記事タイトルが使われます。
	 * @param string $body
	 * @return string
	 */
	function _tagLinks($body) {
		$body = preg_replace_callback('/\[link id=([0-9]+)(\s(.+?))?\]/' ,array($this ,'_tagLinksCallback') ,$body);
		return $body;
	}
		/**
		 * _tagLinksメソッドで使用するコールバックメソッド
		 * @param array $matches 正規表現のマッチ結果
		 * @return string HTML文字列
		 */
		function _tagLinksCallback($matches) {
			$api_url = $this->url(array('controller'=>"book_stand_articles",'action'=>"link",'admin'=>false,$matches[1]));
			$data = unserialize( $this->view->requestAction(Router::url($api_url)) );
			if (!is_array($data)) return $matches[0];
			return $this->link(
				empty($matches[3]) ? $data['BookStandArticle']['title'] : $matches[3],
				$this->view->getVar('tool')->articleUrl($data)
			);
		}
	
	function rss_transform($item)
	{
		$Item = $item['BookStandArticle'];
		return array(
				'title' => $Item['title'],
				'link' => $this->url( $this->view->getVar('tool')->articleUrl($item) ),
				'description' => array(
					'value' => $item['BookStandRevision']['body'],
					'cdata' => true,
					'convertEntities' => false,
				),
				'pubDate' => $Item['posted'],
			);
	}
	// head用
	/**
	 * HEAD用JavaScript読み込みリンクを生成します。
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
	 * JavaScript用リンクを生成します。
	 *
	 * @param string $id ID属性
	 * @param string $class class属性
	 * @param string $text リンク文字列
	 * @return string 出力文字列
	 */
	function jsLink($id ,$class='' ,$text = '開閉') {
		$class = 'jslink ' . $class;
		return $this->Html->link($text ,'javascript:void(0)' ,aa('id',$id,'class',$class));
	}
	/**
	 * JavaScript等をheadに書き出します。
	 * 配列で指定した場合は、複数行に分けて出力します。
	 *
	 * @param mixed $scripts JavaScript等文字列
	 * @param string $name 出力場所を指定 ex) title_for_layout content_for_layout cakeDebug
	 * @return string output
	 */
	function addScript($scripts) {
		$scripts = implode("\n" ,(array)$scripts);
		if (empty($this->view->__scripts['scripts_for_layout'])) $this->view->__scripts['scripts_for_layout'] = '';
		$this->view->__scripts['scripts_for_layout'] .= $this->tab(3 ,$scripts);
		return '';
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
		$body = (array)$body;
		$last = count($body) - 1;
		if ($hidden) $id = 'bsToggleHelp' . substr( md5($title . implode('' ,$body)) ,0 ,8 );
		foreach ($body as $key => $p) {
			if ($key == $hidden && $hidden != 0) {
				$this->addScript("BookStandAdmin.toggle('#{$id}');");
				$out .= '<div id="' . $id . 'Target" class="jsHide">';
			}
			$out .= '<p' . ($key == $last ? ' class="last">' : '>') . $p . '</p>'
					. (($key == $last && $hidden != 0) ? '</div>' : '')
					. (($key == $last && $hidden != 0) ? '<div class="alignRight">' . $this->jsLink($id ,'' ,'すべて表示') . '</div>' : '');
		}
		$out = '<div class="notes">' . $out . '</div>';
		return $out;
	}
	
	/**
	 * 見出し内に add action を追加します。
	 *
	 * @param string $wrap To wrap tags
	 * @return string output
	 */
	function actionAdd($wrap = '<span class="floatRight">%s</span>') {
		$out = $this->link('新規追加' ,$this->url(aa('action',"add")) ,aa('class',"add"));
		return sprintf($wrap ,$out);
	}
	
	/**
	 * 見出し内に 履歴一覧リンク を追加します。
	 *
	 * @param string $wrap To wrap tags
	 * @return string output
	 */
	function revisionList($wrap = '<span class="floatRight">%s</span>') {
		if (empty($this->view->data['BookStandArticle']['id'])) return '';
		$out = $this->link('履歴一覧' ,$this->url(array('controller'=>"book_stand_articles" ,'action'=>"revisions",$this->view->data['BookStandArticle']['id'])) ,aa('class',"revision"));
		return sprintf($wrap ,$out);
	}
	
	/**
	 * span タグの生成
	 *
	 * @param string $text
	 * @param string $class
	 * @param boolean $escape If true ,escape text
	 * @return string output
	 */
	function span($text ,$class ,$escape = true) {
		if ($escape) $text = h($text);
		return "<span class=\"{$class}\">{$text}</span>";
	}
	/**
	 * CKeditor用のTextAreaを生成します。
	 * configでCKeditorを使用しない場合は通常のTextAreaタグを出力します。
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
		$this->addScript("CKEDITOR.replace('{$results[1]}'{$config});");
		return $out;
	}
	/**
	 * 和暦対応 date()の拡張します。
	 * 日付文字列に Vv年 と指定すると 昭和60年 のように出力可能です。
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
	
	/**
	 * 月別リスト作成用
	 *
	 * @param string $ym date('Ym') ex)200901
	 * @return array
	 */
	function yearMonth($ym) {
		$results = array(
			'text' => substr($ym ,0 ,4) . '年' . substr($ym ,4 ,2) . '月',
			'year' => substr($ym ,0 ,4),
			'month' => substr($ym ,4 ,2),
		);
		return $results;
	}
	
	function copyright($admin = false) {
		$copies = ($admin) ? Configure::read('BookStand.admin_copyright') : Configure::read('BookStand.user_copyright');
		return $this->link($copies['name'] ,$copies['url'] ,aa('class',"copyright"));
	}
}
