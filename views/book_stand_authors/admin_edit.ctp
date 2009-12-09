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
