<div class="bookStandArticles index">
<h2><?php echo $bs->actionAdd() . $bs->span("ページ一覧","page");?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $bs->pageSort('種別','static');?></th>
	<th><?php echo $bs->pageSort('投稿','title');?></th>
	<th><?php echo $bs->pageSort('制作者','book_stand_author_id');?></th>
	<th><?php echo $bs->pageSort('カテゴリ','book_stand_category_id');?></th>
	<th><?php echo $bs->pageSort($html->image("fam/comments.png" ,aa('alt',"コメント",'title','コメント')) ,'book_stand_comment_count' ,aa('escape',false));?></th>
	<th><?php echo $bs->pageSort($html->image("fam/tag_red.png" ,aa('alt',"タグ",'title','タグ')) ,'book_stand_tag_count' ,aa('escape',false));?></th>
	<th><?php echo h('日付');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
	$i = 0;
	foreach ($this->data as $article):
		$Article = $article['BookStandArticle'];
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>

	<tr<?php echo $class;?>>
		<td><?php echo empty($Article['static']) ? '' : 'P' ?></td>
		<td>
<?php
		echo $html->image("fam/{$Article['posted_status']['icon']}.png" ,aa('title',$Article['posted_status']['status']));
		echo $bs->link($Article['title'] ,array('action'=>"edit",$Article['id']) ,aa('title' ,$Article['title'] . 'を編集する') );
?>

		</td>
		<td class="alignCenter">
			<?php echo $html->link($article['BookStandAuthor']['name'], array('controller'=> 'book_stand_authors', 'action'=>'view', $article['BookStandAuthor']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($article['BookStandCategory']['name'], array('controller'=> 'book_stand_categories', 'action'=>'view', $article['BookStandCategory']['id'])); ?>
		</td>
		<td class="alignCenter">
			<?php echo (int)$Article['book_stand_comment_count']; ?>
		</td>
		<td class="alignCenter">
			<?php echo (int)$Article['book_stand_tag_count']; ?>
		</td>
		<td class="alignCenter">
<?php
		echo $bs->tab(3 ,
			$bs->niceShort(strtotime($Article['posted_status']['date']))
			."\n".
			$html->image("fam/{$Article['posted_status']['date_icon']}.png" ,aa('title',$Article['posted_status']['date_type']))
		);
?>

		</td>
		<td class="actions">
<?php
		echo $bs->tab(3 ,
			$html->link($html->image('fam/page_go.png' ,aa('alt',"投稿をプレビュー")), $bs->url(array('action'=>'view', $Article['id']) ) ,aa('target',"preview" ,'title',"投稿をプレビュー") ,null ,false)
			."\n".
			$html->link($html->image('fam/page_copy.png' ,aa('alt',"この投稿を下書きに新規作成")), $bs->url(array('action'=>'add','admin'=>false, $Article['id']) ) ,aa('title',"この投稿を下書きに新規作成") ,null ,false)
			."\n".
			$html->link($html->image('fam/delete.png' ,aa('alt',"投稿を削除")), $bs->url(array('action'=>'delete', $Article['id']) ), aa('title',"投稿を削除"), sprintf(__('Are you sure you want to delete # %s?', true), $Article['id']) ,false)
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
