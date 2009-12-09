<div class="bookStandTags index">
<h2><?php echo $bs->actionAdd() . $bs->span('タグ一覧',"tag");?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $bs->pageSort('タグ' ,'name');?></th>
	<th><?php echo $bs->pageSort('備考' ,'note');?></th>
	<th><?php echo $bs->pageSort('投稿数' ,'book_stand_article_count');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($this->data as $tag):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $bs->link($tag['BookStandTag']['name'] ,$bs->url(array('action' => "edit" ,$tag['BookStandTag']['id'])) ); ?>
		</td>
		<td>
			<?php echo $tag['BookStandTag']['note']; ?>
		</td>
		<td>
			<?php echo $tag['BookStandTag']['book_stand_article_count']; ?>
		</td>
		<td class="actions">
			<?php echo $bs->link(__('Edit', true), array('action'=>'edit', $tag['BookStandTag']['id'])); ?>
			<?php echo $bs->link(__('Delete', true), array('action'=>'delete', $tag['BookStandTag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['BookStandTag']['id'])); ?>
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
