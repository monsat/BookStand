<div class="bookStandRevisions index">
<h2><?php echo $bs->span('履歴一覧',"revision");?></h2>
<?php echo $bs->link($this->data['BookStandArticle']['title'], array('action'=>'edit', $this->data['BookStandArticle']['id']) ,aa('class',"page")); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo h('ID');?></th>
	<th><?php echo h('本文');?></th>
	<th><?php echo '作成日付<br />最終更新';?></th>
</tr>
<?php
/**/
$i = 0;
foreach ($this->data['BookStandRevisionHistory'] as $history):
	$class = null;
	$is_current = false;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if ($history['id'] == $this->data['BookStandArticle']['book_stand_revision_id']) {
		$is_current = true;
		$class = ' class="important"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $history['id']; ?>
		</td>
		<td>
			<?php echo nl2br(strip_tags($history['body'])); ?>
		</td>
		<td>
			<?php echo "作成日：" . $bs->niceShort($history['created']); ?><br />
			<?php echo "最終更新：" . $bs->niceShort($history['modified']); ?><br />
			<hr />
			<?php if (!$is_current) echo $bs->link("この内容でページを編集" ,$bs->url(array('action'=>"edit" ,$this->data['BookStandArticle']['id'] ,$history['id'])) ); ?><br />
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
