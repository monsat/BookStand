<?php
/**
 * $data['BookStandCategory']
 */
$category = $data['BookStandCategory'];
$id = 'bsToggleCategory' . substr( md5(serialize($data)) ,0 ,8 );
$article_count = empty($category['book_stand_article_count']) ? '' : ('(' . $category['book_stand_article_count'] . ')');
echo "\t" . $bs->tab(1 ,
	$bs->span($category['name'] ,'categorytreename parent_id_' . $category['parent_id']) . "\n"
	. $bs->span($article_count ,'categorytreecount colorLight') . "\n"
	. ' - ' . $bs->link('上へ' ,array('action' => 'moveup' ,$category['id']) ,aa('class','jslink moveup'))
	. ' - ' . $bs->link('下へ' ,array('action' => 'movedown' ,$category['id']) ,aa('class','jslink movedown'))
	. ' - ' . $bs->jsLink($id ,'editcategory' ,'編集') . "\n"
	. '<div class="bsToggleCategory jsHide" id="' . $id . 'Target">' . "\n"
		. $form->create('BookStandCategory' ,aa('id',$id . '_editname_form','url',$bs->url(array('action' => 'edit' ,$category['id']))))
			. '<input type="text" name="data[BookStandCategory][name]" value="' . $category['name'] . '" />'
			. '<input type="hidden" name="bookStand[parent_id]" value="' . $category['parent_id'] . '" />'
			. $form->select('parent_id' ,$parents ,$category['parent_id'] ,aa('id',null ,'label',false) ,'親カテゴリを選択')
		. '<input type="submit" value ="保存" /></form>'
	. '</div>'

);
