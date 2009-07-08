<?php
	// コメント表示フラグ
	if (Configure::read('BookStand.article.use_comment')) {
	
		// コメント
		if (empty($comments)) $comments = $controller->data['BookStandComment'];
		$out = '';
		foreach ($comments as $comment) {
			$out .= $this->element('comment' ,array('comment' => $comment));
		}

?>
<div class="comments">
	<div class="caption"><span class="floatRight"><?php echo $bs->jsLink('bsCommentEdit' ,'edit' ,'コメントを書く') ?></span>コメント/トラックバック <?php echo count($comments) . '件'; ?></div>
	<div id="bsCommentEditTarget" class="comment_edit jsHide">
		<?php echo $bs->tabElement(2 ,'comment_add') ?>

	</div>
	<div class="body">
		<?php echo $bs->tab(2 ,$out) ?>

	</div>
</div>

<?php
		$bs->addScript('BookStand.toggle("#bsCommentEdit");');
	}
?>