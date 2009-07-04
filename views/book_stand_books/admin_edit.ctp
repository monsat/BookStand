<div class="bookStandBooks form">
<?php echo $form->create('BookStandBook',aa('url', $this->here));?>
	<fieldset>
		<legend><?php echo h('Bookの' . $bs->isAdd("新規追加","編集"));?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('title' ,aa('label',"Bookのタイトル",'class',"inputMax"));
		echo $form->input('dir' ,aa('label',"ディレクトリ"));
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo h('備考');?></legend>
	<?php
		echo $form->input('note' ,aa('label',false,'class',"widthMax"));
	?>
	</fieldset>
	<fieldset>
		<legend><?php echo h('Bookを設定');?></legend>
	<?php echo $form->end(aa('label',$bs->isAdd("新規追加","設定を保存"),'class',"default floatRight" . ($bs->isAdd(' add',''))));?>
	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('BookStandBook.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BookStandBook.id'))); ?></li>
		<li><?php echo $html->link(__('List BookStandBooks', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
	</ul>
</div>
