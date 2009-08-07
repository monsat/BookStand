<h2>BookStand</h2>
<ul>
	<li><?php echo $bs->link('ホーム' ,array('controller'=> 'book_stand_articles', 'action' => 'index')) ?></li>
	<li><?php echo $bs->link('新規追加' ,array('controller'=> 'book_stand_articles', 'action' => 'add')) ?></li>
	<li><?php echo $bs->link('記事編集' ,array('controller'=> 'book_stand_articles', 'action' => 'index')) ?></li>
</ul>

<h2>リストページ</h2>
<ul>
	<li><?php echo $bs->link('ページ', array('controller'=> 'book_stand_articles', 'action'=>'index'));?></li>
	<li><?php echo $bs->link('制作者', array('controller'=> 'book_stand_authors', 'action'=>'index')); ?> </li>
	<li><?php echo $bs->link('カテゴリ', array('controller'=> 'book_stand_categories', 'action'=>'index')); ?> </li>
	<li><?php echo $bs->link('コメント', array('controller'=> 'book_stand_comments', 'action'=>'index')); ?> </li>
	<li><?php echo $bs->link('タグ', array('controller'=> 'book_stand_tags', 'action'=>'index')); ?> </li>
</ul>
