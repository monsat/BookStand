<?php echo $form->create('BookStandComment',aa('url', $bs->url(array('controller'=>"book_stand_comments",'action'=>"add"))));?>
<fieldset>
	<legend><?php echo h('コメント');?></legend>
<?php
	echo $bs->editNotes('コメント' ,array(
			'投稿者名とURLは任意です。',
		),0);
	echo $form->input('BookStandArticle.id' ,aa('type','hidden','value',$this->data['BookStandArticle']['id']));
	echo $form->input('book_stand_article_id' ,aa('type','hidden','value',$this->data['BookStandArticle']['id']));
	echo $form->input('author' ,aa('label','投稿者名'));
	echo $form->input('author_url' ,aa('label','URL'));
	echo $form->input('body' ,aa('label','本文','rows',"2"));
	echo $form->input('BookStand.referer' ,aa('type','hidden','value',
			empty($this->data['BookStand']['referer']) ? Router::url($bs->url($controller->BookStandTool->articleUrl())) : $this->data['BookStand']['referer']
		));
	echo '<div class="alignRight">' . $form->end(aa('label',"新規追加"),'class',"default add") . '</div>';
?>

</fieldset>
