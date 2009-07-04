<div class="bookStandCategories index">
<h2><?php echo $bs->span('カテゴリ一覧',"category");?></h2>
<div id="categorytreeWrapper">
<?php
	echo $tree->generate($bookStandCategories ,aa('id',"categorytree",'element',"category_tree_index"));
?>

</div>
<?php
	$bs->addScript(array(
		'BookStandAdmin.categoryToggle($(".editcategory" ,"#categorytree"));',
		'BookStandAdmin.categoryTreeEdit();',
	));
?>
</div>
<div class="bookStandCategories form">
	<?php echo $form->create('BookStandCategory',aa('url' ,$this->here));?>

	<fieldset>
		<legend><?php echo h('カテゴリの新規追加');?></legend>
<?php
		echo $form->input('id');
		echo $form->input('name' ,aa('label',"カテゴリ名" ,'class',"inputMax"));
		echo $form->input('parent_id' ,aa('label',"親カテゴリ",'options',$parents ,'empty',"最上位に登録"));
?>
	</fieldset>

<?php
		echo $form->end(aa('label',"新規追加",'class',"default floatRight add"));
?>

</div>
