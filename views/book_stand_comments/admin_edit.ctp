<div class="bookStandComments form">
<?php echo $form->create('BookStandComment',aa('url', $this->here));?>
	<fieldset>
		<legend><?php echo h('コメント');?></legend>
<?php
		echo $form->input('id');
		echo $form->input('title' ,aa('label','タイトル'));
		echo $form->input('author' ,aa('label','ユーザー名'));
		echo $form->input('author_url' ,aa('label','URL'));
		echo $form->input('body' ,aa('label','本文'));
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('投稿データ');?></legend>
<?php
		echo $form->input('book_stand_article_id' ,aa('label','ページID'));
		echo $form->input('user_id' ,aa('label','ユーザーID'));
		echo $form->input('book_stand_user_id' ,aa('label','BookStand ID'));
		echo $form->input('author_ip' ,aa('label','IPアドレス'));
		echo $form->input('posted' ,aa('label','投稿日時'));
		echo $form->input('spam' ,aa('label','スパム判定'));
		echo $form->input('book_stand_comment_status_id' ,aa('label','コメントステータス'));
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('コメントを設定');?></legend>
		<?php echo $form->end(aa('label',$bs->isAdd("新規追加","設定を保存"),'class',"default floatRight" . ($bs->isAdd(' add',''))));?>

	</fieldset>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('BookStandComment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BookStandComment.id'))); ?></li>
		<li><?php echo $html->link(__('List BookStandComments', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Book Stand Comment Statuses', true), array('controller'=> 'book_stand_comment_statuses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Comment Status', true), array('controller'=> 'book_stand_comment_statuses', 'action'=>'add')); ?> </li>
	</ul>
</div>
