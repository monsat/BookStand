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
	<th><?php echo $paginator->sort('ページ名' ,'book_stand_article_id');?></th>
	<th><?php echo $paginator->sort('タイトル' ,'title');?></th>
	<th><?php echo $paginator->sort('ユーザー' ,'user_id');?></th>
	<th><?php echo $paginator->sort('BSユーザー' ,'book_stand_user_id');?></th>
	<th><?php echo $paginator->sort('氏名' ,'author');?></th>
	<th><?php echo $paginator->sort('URL' ,'author_url');?></th>
	<th><?php echo $paginator->sort('IPアドレス' ,'author_ip');?></th>
	<th><?php echo $paginator->sort('本文' ,'body');?></th>
	<th><?php echo $paginator->sort('日付' ,'posted');?></th>
	<th><?php echo $paginator->sort('ス' ,'spam');?></th>
	<th><?php echo $paginator->sort('状態' ,'book_stand_comment_status_id');?></th>
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
	echo $bs->tab(3 ,
		$bs->link($comment['BookStandComment']['title'] ,array('action' => "edit" ,$comment['BookStandComment']['id']) ,aa('title',$comment['BookStandComment']['title']."を編集"))
	);
?>

		</td>
		<td>
			<?php echo $comment['BookStandComment']['title']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['user_id']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['book_stand_user_id']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['author']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['author_url']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['author_ip']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['body']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['posted']; ?>
		</td>
		<td>
			<?php echo $comment['BookStandComment']['spam']; ?>
		</td>
		<td>
			<?php echo $html->link($comment['BookStandCommentStatus']['name'], array('controller'=> 'book_stand_comment_statuses', 'action'=>'view', $comment['BookStandCommentStatus']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $comment['BookStandComment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $comment['BookStandComment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $comment['BookStandComment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['BookStandComment']['id'])); ?>
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
