<div class="bookStandArticles index">
<h2><?php echo $bs->actionAdd() . $bs->span('ページ一覧',"page");?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Book','book_stand_book_id');?></th>
	<th><?php echo $paginator->sort('投稿','title');?></th>
	<th><?php echo $paginator->sort('制作者','book_stand_author_id');?></th>
	<th><?php echo $paginator->sort('カテゴリ','book_stand_category_id');?></th>
	<th><?php echo $paginator->sort($html->image("fam/comments.png" ,aa('alt',"コメント",'title','コメント')) ,'book_stand_comment_count' ,aa('escape',false));?></th>
	<th><?php echo $paginator->sort($html->image("fam/tag_red.png" ,aa('alt',"タグ",'title','タグ')) ,'book_stand_tag_count' ,aa('escape',false));?></th>
	<th><?php echo h('日付');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
	$i = 0;
	foreach ($this->data as $article):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>

	<tr<?php echo $class;?>>
		<td class="alignCenter">
			<?php echo $html->link($article['BookStandBook']['title'], array('controller'=> 'book_stand_books', 'action'=>'view', $article['BookStandBook']['id'])); ?>
		</td>
		<td>
<?php
		echo $bs->link($article['BookStandArticle']['title'] ,array('action'=>"edit",$article['BookStandArticle']['id']) ,aa('title' ,$article['BookStandArticle']['title'] . 'を編集する') );
		if ($article['BookStandArticle']['posted_status']['is_draft']) {
			echo $html->link($html->image('fam/page_white_edit.png'), $bs->url(array('action'=>'edit',$article['BookStandArticle']['id']) ) ,aa('title',"下書き" ,'alt',"下書き") ,null ,false);
		} elseif ($article['BookStandArticle']['posted_status']['is_deleted']) {
			echo $html->image('fam/page_white_delete.png' ,aa('title',"削除済み" ,'alt',"削除済み"));
		}
?>

		</td>
		<td class="alignCenter">
			<?php echo $html->link($article['BookStandAuthor']['name'], array('controller'=> 'book_stand_authors', 'action'=>'view', $article['BookStandAuthor']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($article['BookStandCategory']['name'], array('controller'=> 'book_stand_categories', 'action'=>'view', $article['BookStandCategory']['id'])); ?>
		</td>
		<td class="alignCenter">
			<?php echo (int)$article['BookStandArticle']['book_stand_comment_count']; ?>
		</td>
		<td class="alignCenter">
			<?php echo (int)$article['BookStandArticle']['book_stand_tag_count']; ?>
		</td>
		<td class="alignCenter">
<?php
		echo $bs->tab(3 ,
			$bs->niceShort(strtotime($article['BookStandArticle']['posted_status']['date']))
			."\n".
			$html->image("fam/{$article['BookStandArticle']['posted_status']['icon']}.png" ,aa('alt',$article['BookStandArticle']['posted_status']['date_type'],'title',$article['BookStandArticle']['posted_status']['date_type']))
		);
?>

		</td>
		<td class="actions">
<?php
		echo $bs->tab(3 ,
			$html->link($html->image('fam/page_go.png' ,aa('alt',"投稿をプレビュー")), $bs->url(array('action'=>'view','admin'=>false, $article['BookStandArticle']['id']) ) ,aa('target',"preview" ,'title',"投稿をプレビュー") ,null ,false)
			."\n".
			$html->link($html->image('fam/page_copy.png' ,aa('alt',"この投稿を下書きに新規作成")), $bs->url(array('action'=>'add','admin'=>false, $article['BookStandArticle']['id']) ) ,aa('title',"この投稿を下書きに新規作成") ,null ,false)
			."\n".
			$html->link($html->image('fam/delete.png' ,aa('alt',"投稿を削除")), $bs->url(array('action'=>'delete', $article['BookStandArticle']['id']) ), aa('title',"投稿を削除"), sprintf(__('Are you sure you want to delete # %s?', true), $article['BookStandArticle']['id']) ,false)
		);
?>

		</td>
	</tr>
<?php endforeach; ?>

</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), aa('url',$bs->url()), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers(aa('url',$bs->url()));?>
	<?php echo $paginator->next(__('next', true).' >>', aa('url',$bs->url()), null, array('class'=>'disabled'));?>
</div>
