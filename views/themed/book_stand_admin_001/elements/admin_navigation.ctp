<ul class="clearfix">
	<li class="current"><?php echo $bs->link('ホーム' ,array('controller' => 'book_stand_articles' ,'action' => 'index')) ?></li>
	<li><?php echo $bs->link('新規追加' ,array('controller' => 'book_stand_articles' ,'action' => 'add')) ?></li>
	<li><?php echo $bs->link('記事編集' ,array('controller' => 'book_stand_articles' ,'action' => 'index')) ?></li>
	<li><a href="javascript:void(0)">メディア</a></li>
	<li><?php echo $bs->link('コメント', array('controller'=> 'book_stand_comments', 'action'=>'index')); ?> </li>
	<li><a href="javascript:void(0)">ヘルプ</a></li>
</ul>
