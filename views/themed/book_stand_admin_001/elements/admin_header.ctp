<div class="title">
	<div class="floatRight bold">
<?php
		echo $bs->tab(2 ,
			$bs->link('ブログを開く' ,$tool->url(array('admin' => false ,'controller' => 'book_stand_articles' , 'action' => 'index' ,'top')) ,array('target' => "_blank"))
			. ' - '
			. $html->link('ヘルプ' ,Configure::read('BookStand.admin_copyright.help_url'))
		);
?>

	</div>
	<h1>BookStand Plugin on CakePHP</h1>
</div>