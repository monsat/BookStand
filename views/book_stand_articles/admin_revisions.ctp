<div class="bookStandRevisions index">
<h2><?php echo $bs->span('履歴一覧',"revision");?></h2>
<?php echo $bs->link($this->data['BookStandArticle']['title'], array('action'=>'edit', $this->data['BookStandArticle']['id']) ,aa('class',"page")); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo h('本文');?></th>
</tr>
<?php
/**/
$i = 0;
foreach ($this->data['BookStandArticle']['revisions'] as $key => $revision):
	$class = null;
	$is_current = false;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if ($i == 1) {
		$is_current = true;
		$class = ' class="important"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php if (!$is_current) echo $bs->link("この内容でページを編集" ,$bs->url(array('action'=>"edit" ,$this->data['BookStandArticle']['id'] ,md5($revision))) ); ?><br />
			<hr />
			<?php echo nl2br(strip_tags($revision)); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
