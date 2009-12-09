<div class="bookStandComments form">
<?php echo $form->create('BookStandComment',aa('url', $this->here));?>
	<fieldset>
		<legend><?php echo h('コメント');?></legend>
<?php
		echo $form->input('id');
		echo $form->input('BookStandArticle.title' ,aa('label','記事','readonly','readonly','class',"inputMax"));
		echo $form->input('title' ,aa('label','タイトル','class',"inputMax"));
		echo $form->input('author' ,aa('label','ユーザー名'));
		echo $form->input('author_url' ,aa('label','URL','class',"inputMax"));
		echo $form->input('body' ,aa('label','本文','class','widthMax','rows',5));
		echo $form->input('author_ip' ,aa('label','IPアドレス','readonly','readonly'));
		echo $form->input('posted' ,aa('label','投稿日時'));
		echo $form->input('spam' ,aa('label','スパム判定'));
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('コメントを設定');?></legend>
		<?php echo $form->end(aa('label',$bs->isAdd("新規追加","設定を保存"),'class',"default floatRight" . ($bs->isAdd(' add',''))));?>

	</fieldset>
</div>
