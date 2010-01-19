<div class="bookStandRevisions index">
<h2><?php echo $bs->span('履歴一覧',"revision");?></h2>
<?php echo $bs->link($this->data['BookStandArticle']['title'], array('action'=>'edit', $this->data['BookStandArticle']['id']) ,aa('class',"page")); ?>
<?php
foreach ($this->data['BookStandArticle']['revisions'] as $key => $revision):
	$class = 'revision_list';
	if (empty($is_current)) {
		$is_current = true;
		$class .= ' important';
	}
?>
<div class="<?php echo $class;?>">
	<div class="revision_list_header">
<?php
	if (!empty($revision['hash'])) {
		echo $bs->link("この内容でページを編集" ,$bs->url(array('action'=>"edit" ,$this->data['BookStandArticle']['id'] ,md5($revision['hash']))) );
	} else {
		echo "現在投稿されている内容";
	}
	echo "&nbsp;[最終更新：" . date('Y/m/d H:i:s' ,$revision['modified']) . "]";
?>

	</div>
	<div class="revision_list_body"><?php echo nl2br(strip_tags($revision['body'])); ?></div>
</div>
<?php endforeach; ?>
</div>
