<div class="bookStandAuthors form">
<?php echo $form->create('BookStandAuthor',aa('url', $this->here));?>
	<fieldset>
 		<legend><?php echo h('執筆者を' . $bs->isAdd("新規追加","編集"));?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name' ,aa('label',"氏名",'class',"inputMax"));
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo h('備考');?></legend>
	<?php
		echo $form->input('note' ,aa('label',false,'class',"widthMax"));
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo h('執筆者を設定');?></legend>
	<?php echo $form->end(aa('label',$bs->isAdd("新規追加","設定を保存"),'class',"default floatRight" . ($bs->isAdd(' add',''))));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('BookStandAuthor.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BookStandAuthor.id'))); ?></li>
		<li><?php echo $html->link(__('List BookStandAuthors', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
	</ul>
</div>
