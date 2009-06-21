<div class="bookStandArticles index">
<h2><?php echo h('ページ編集');?></h2>
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
	<th><?php echo $paginator->sort('カテゴリー','book_stand_category_id');?></th>
	<th><?php echo $paginator->sort('コ','book_stand_comment_count');?></th>
	<th><?php echo $paginator->sort('タグ','book_stand_tag_count');?></th>
	<th><?php echo h('日付');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($bookStandArticles as $bookStandArticle):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo h($bookStandAllBooks[ $bookStandArticle['BookStandArticle']['book_stand_book_id'] ]); ?>
		</td>
		<td>
<?php
	echo $bs->link($bookStandArticle['BookStandArticle']['title'] ,array('action'=>"edit",$bookStandArticle['BookStandArticle']['id']) ,aa('title' ,$bookStandArticle['BookStandArticle']['title'] . 'を編集する') );
	if ($bookStandArticle['BookStandArticleStatus']['name'] == 'draft') {
		echo ' - ' . $bookStandArticle['BookStandArticleStatus']['note'];
	}
?>
		</td>
		<td>
			<?php echo $html->link($bookStandArticle['BookStandAuthor']['name'], array('controller'=> 'book_stand_authors', 'action'=>'view', $bookStandArticle['BookStandAuthor']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($bookStandArticle['BookStandCategory']['name'], array('controller'=> 'book_stand_categories', 'action'=>'view', $bookStandArticle['BookStandCategory']['id'])); ?>
		</td>
		<td>
			<?php echo $bookStandArticle['BookStandArticle']['book_stand_comment_count']; ?>
		</td>
		<td>
			<?php echo $bookStandArticle['BookStandArticle']['book_stand_tag_count']; ?>
		</td>
		<td>
<?php
	if (true) {
		echo $bs->niceShort(strtotime($bookStandArticle['BookStandArticle']['begin_publishing'])) . '公開';
	} elseif (true) {
		echo $bs->niceShort(strtotime($bookStandArticle['BookStandArticle']['modified'])) . '最終更新';
	} elseif (true) {
		echo $bs->niceShort(strtotime($bookStandArticle['BookStandArticle']['end_publishing'])) . '公開終了';
	}
	
?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), $bs->url(array('action'=>'view',Configure::read('BookStand.admin')=>false, $bookStandArticle['BookStandArticle']['id']) ) ,aa('target',"preview")); ?>
			<?php echo $html->link(__('Delete', true), $bs->url(array('action'=>'delete', $bookStandArticle['BookStandArticle']['id']) ), null, sprintf(__('Are you sure you want to delete # %s?', true), $bookStandArticle['BookStandArticle']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
