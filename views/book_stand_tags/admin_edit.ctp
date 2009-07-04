<div class="bookStandTags form">
<?php echo $form->create('BookStandTag',aa('url', $this->here));?>
	<fieldset>
		<legend><?php echo h('タグの' . $bs->isAdd("新規追加","編集"));?></legend>
<?php
	echo $bs->tab(2,
		$bs->editNotes('タグについて' ,array(
			'<strong>タグ</strong>を使ってページを分類することができます。',
			'各投稿に、複数のタグを設定できます。',
		),0)
		."\n".
		$form->input('id')
		."\n".
		$form->input('name' ,aa('label',"名前",'class',"inputMax"))
		."\n".
		$form->input('note' ,aa('label',"内容",'class',"inputMax"))
	);
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('適用する投稿');?></legend>
<?php
	echo $bs->tab(2,
		$bs->editNotes('適用する投稿' ,array(
			'ここで設定するタグをつける投稿にチェックをしてください。',
			'同じタグが設定された投稿は一覧表示することが可能です。',
		),0)
		."\n".
		$form->input('BookStandArticle' ,aa('label',false ,'type',"select" ,'multiple',"checkbox"))
	);
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('タグを設定');?></legend>
<?php
	echo $bs->tab(2,
		$form->end(aa('label',$bs->isAdd("新規追加","設定を保存"),'class',"default floatRight" . ($bs->isAdd(' add',''))))
	);
?>

	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('BookStandTag.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BookStandTag.id'))); ?></li>
		<li><?php echo $html->link(__('List BookStandTags', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
	</ul>
</div>
