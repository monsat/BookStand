<ul class="clearfix">
	<li><?php echo $bs->link('ホーム' ,array('controller' => 'book_stand_articles' ,'action' => 'index')) ?></li>
	<li><?php echo $bs->link('新規追加' ,array('controller' => 'book_stand_articles' ,'action' => 'add')) ?></li>
	<li><?php echo $bs->link('記事編集' ,array('controller' => 'book_stand_articles' ,'action' => 'index')) ?></li>
	<li><?php echo $bs->link('制作者', array('controller'=> 'book_stand_comments', 'action'=>'index')); ?> </li>
	<li><?php echo $bs->link('コメント', array('controller'=> 'book_stand_comments', 'action'=>'index')); ?> </li>
	<li class="last"><?php echo $bs->link('タグ', array('controller'=> 'book_stand_tags', 'action'=>'index')); ?> </li>
</ul>
