<div id="bookStandArticlesEdit">
<h2><?php echo $bs->revisionList() . $bs->span('ページの' . $bs->isAdd("新規追加","編集"),"page");?></h2>
<?php
	echo $bs->tab(1, $form->create('BookStandArticle',aa('url', $this->here)));
	echo $bs->tab(1, $bs->isEdit($form->input('BookStandRevision.id',aa('type',"hidden") ) ,''));
?>

	<fieldset>
		<legend><?php echo h('基本情報');?></legend>
<?php
	echo $bs->tab(2,
		$bs->editNotes('基本情報について' ,array(
			'<strong>Bookとは</strong>ページの集合を指します。通常はブログ全体でひとつのBookとなります。',
			'BookStandでは、複数のブログや複数の静的ページを管理できます。',
			'<strong>Slugとは</strong>URLに組み込まれるキーワードです。URL以外に使用されません。'
		),1)
		."\n".
		$form->input('id')
		."\n".
		$form->input('book_stand_book_id' ,aa('label',"Book選択",'default',$session->read('BookStand.book_id')))
		."\n".
		$form->input('title' ,aa('label',"タイトル",'class',"inputMax"))
		."\n".
		$form->input('slug' ,aa('label',"英字Slug",'class',"inputMax"))
		."\n".
		$form->input('mbslug' ,aa('label',"日本語Slug",'class',"inputMax"))
		."\n".
		$form->input('book_stand_author_id')
		//."\n".
		//	$form->input('book_stand_category_id')
		."\n".
		$form->input('book_stand_revision_id' ,aa('type',"hidden"))
		."\n".
		$form->input('BookStandRevision.copied_body' ,aa('type',"hidden"))
	);
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('本文');?></legend>
<?php
	//	echo $bs->tab(3, $fck->input('BookStandRevision.body' ,aa('label',false,'class',"widthMax",'rows',Configure::read('BookStand.edit.rows'))) );
	echo $bs->tab(2,
		//	$form->input('BookStandRevision.body' ,aa('label',false,'class',"ckeditor"))
		$bs->ckeditor('BookStandRevision.body' ,aa('label',false,'class','widthMax','rows',Configure::read('BookStand.edit.rows'),'div',aa('class','body')) )
	);
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('保存の設定');?></legend>
<?php
	echo $bs->tab(2,
		$bs->editNotes('保存の設定について' ,array(
			'<strong>編集の履歴とは</strong>過去の編集内容の記録です。編集に手違いがあった場合でも、簡単に差し戻すことができます。',
			'上書き保存を選択すると、前回の編集内容は失います。',
			'<strong>下書き保存</strong>をすると、ページは公開されません。公開するときは今すぐ投稿するを選択してください。'
		),1)
		."\n".
		(empty($bookStandRevisionOptions) ? '' :
			$form->input('is_revision' ,aa('type',"radio",'legend',"編集の履歴",'label',true,'options',$bookStandRevisionOptions,'default',(Configure::read('BookStand.edit.isRevision') == true ? 'create' : update) ) ) . "\n"
		) .
		$form->input('save_types' ,aa('label',"投稿",'options',$bookStandSaveTypes,'class',"",'after',$bs->jsLink('bsToggleSaveTypes')) )
		."\n".
		$form->input('posted' ,aa('label',"表示する投稿日時",'dateFormat',"YMD",'timeFormat',"24",'interval',10,'separator'," / ",'minYear',date('Y')-5,'maxYear',date('Y')+5,'monthNames',false))
		."\n".
		$form->input('book_stand_article_status_id' ,aa('label',"保存"))
	);
	$bs->addScript(array(
		'BookStandAdmin.toggle("#bsToggleSaveTypes");',
		'BookStandAdmin.selectSaveChange();',
	));
?>

		<div id="bsToggleSaveTypesTarget">
<?php
	echo $bs->tab(3,
		$form->input('begin_publishing' ,aa('label',"公開日時",'dateFormat',"YMD",'timeFormat',"24",'interval',10,'separator'," / ",'minYear',date('Y')-1,'maxYear',date('Y')+5,'monthNames',false))
		."\n".
		$form->input('end_publishing' ,aa('label',"公開終了",'dateFormat',"YMD",'timeFormat',"24",'interval',60,'separator'," / ",'minYear',date('Y')-1,'empty',true,'monthNames',false))
	);
?>

		</div>
	</fieldset>
	<fieldset>
		<legend><?php echo h('カテゴリ・タグ');?></legend>
<?php
	echo $bs->tab(2,
		$bs->editNotes('タグについて' ,array(
			'<strong>タグ</strong>を使ってページを分類することができます。',
			'複数のタグを設定できます。',
		),0)
		."\n".
		$form->input('BookStandTag' ,aa('label',"タグ" ,'type',"select" ,'multiple',"checkbox"))
		."\n".
		$form->input('book_stand_category_id' ,aa('label',"カテゴリ" ,'type',"select"))
	);
?>

	</fieldset>
	<fieldset>
		<legend><?php echo h('記事の投稿');?></legend>
<?php
		echo $bs->tab(2,
			$form->end(aa('label',$bs->isAdd("新規追加","編集を保存"),'class',"default floatRight" . ($bs->isAdd(' add','')),'before',$bs->link('編集を破棄し記事一覧に戻る' ,aa('action',"index",'class',"floatLeft"))))
		);
?>

	</fieldset>
</div>
