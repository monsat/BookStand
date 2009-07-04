<div class="bookStandBooks index">
<h2><?php echo $bs->actionAdd() . $bs->span('Book一覧',"book");?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort("タイトル" ,'title');?></th>
	<th><?php echo $paginator->sort("備考" ,'note');?></th>
	<th><?php echo $paginator->sort("ディレクトリ" ,'dir');?></th>
	<th><?php echo $paginator->sort("総ページ数" ,'book_stand_article_count');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($this->data as $book):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
<?php
	echo $bs->tab(3 ,
		$bs->link($book['BookStandBook']['title'] ,array('action' => "edit" ,$book['BookStandBook']['id']) ,aa('title',$book['BookStandBook']['title']."を編集"))
	);
?>

		</td>
		<td>
			<?php echo $book['BookStandBook']['note']; ?>
		</td>
		<td>
			<?php echo $book['BookStandBook']['dir']; ?>
		</td>
		<td>
			<?php echo $book['BookStandBook']['book_stand_article_count']; ?>
		</td>
		<td class="actions">
			<?php echo $bs->link(__('View', true), array('action'=>'view', $book['BookStandBook']['id'])); ?>
			<?php echo $bs->link(__('Edit', true), array('action'=>'edit', $book['BookStandBook']['id'])); ?>
			<?php echo $bs->link(__('Delete', true), array('action'=>'delete', $book['BookStandBook']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $book['BookStandBook']['id'])); ?>
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
		<li><?php echo $bs->link(__('New BookStandBook', true), array('action'=>'add')); ?></li>
		<li><?php echo $bs->link(__('List Book Stand Articles', true), array('controller'=> 'book_stand_articles', 'action'=>'index')); ?> </li>
		<li><?php echo $bs->link(__('New Book Stand Article', true), array('controller'=> 'book_stand_articles', 'action'=>'add')); ?> </li>
	</ul>
</div>
