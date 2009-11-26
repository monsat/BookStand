<div class="bookStandComments index">
<h2><?php echo $bs->actionAdd() . $bs->span('コメント一覧',"comment");?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('日付' ,'posted');?></th>
	<th><?php echo $paginator->sort('ページ名' ,'book_stand_article_id');?></th>
	<th><?php echo $paginator->sort('氏名' ,'author');?></th>
	<th><?php echo $paginator->sort('タイトル / 本文' ,'body');?></th>
	<th><?php echo $paginator->sort('スパム' ,'spam');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($this->data as $comment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
<?php
	$comment_date = empty($comment['BookStandComment']['posted']) ? $comment['BookStandComment']['created'] : $comment['BookStandComment']['posted'];
	echo $bs->niceShort(strtotime($comment_date));
?>

		</td>
		<td>
<?php
	echo $bs->tab(3 ,
		$bs->link($comment['BookStandArticle']['title'] ,array('controller' => "book_stand_articles" ,'action' => "view" ,$comment['BookStandComment']['book_stand_article_id']) ,aa('title',"記事をプレビュー",'target',"_blank"))
	);
?>

		</td>
		<td>
<?php
	$author = empty($comment['BookStandComment']['author']) ? Configure::read('BookStand.article.comment_anonymous') : $comment['BookStandComment']['author'];
	if (!empty($comment['BookStandComment']['author_url'])) {
		$author = $html->link($author ,$comment['BookStandComment']['author_url'] ,array('title' => $comment['BookStandComment']['author_url'] . " - " . $comment['BookStandComment']['author_ip'] ,'target' => "_blank"));
	} else {
		$author = $html->tag('span' ,$author ,array('title' => $comment['BookStandComment']['author_ip']));
	}
	echo $author;
?>

		</td>
		<td>
<?php
	$comment_title = empty($comment['BookStandComment']['title']) ? Configure::read('BookStand.article.comment_untitled') : $comment['BookStandComment']['title'];
	echo $bs->link($comment_title ,array('action' => "edit" ,$comment['BookStandComment']['id']) ,aa('title',$comment['BookStandComment']['title']."を編集"));
	echo '<br />' . $comment['BookStandComment']['body'];
?>

		</td>
		<td>
			<?php echo $comment['BookStandComment']['spam']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), $bs->url(array('action'=>'view', $comment['BookStandComment']['id']))); ?>
			<?php echo $html->link(__('Edit', true), $bs->url(array('action'=>'edit', $comment['BookStandComment']['id']))); ?>
			<?php echo $html->link(__('Delete', true), $bs->url(array('action'=>'delete', $comment['BookStandComment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['BookStandComment']['id']))); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New BookStandComment', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Book Stand Comment Statuses', true), array('controller'=> 'book_stand_comment_statuses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Book Stand Comment Status', true), array('controller'=> 'book_stand_comment_statuses', 'action'=>'add')); ?> </li>
	</ul>
</div>
