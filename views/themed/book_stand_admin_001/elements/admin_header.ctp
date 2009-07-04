<div class="title">
	<div class="floatRight">
<?php
		$name = 'ゲスト';
		if ($session->check('BookStand.admin.username')) {
			$name = $session->read('BookStand.admin.username');
		}
		echo $bs->tab(2 ,'<strong>' . $name . '</strong>' . h('さん。こんにちは' . ' - '));
		echo $bs->tab(2 ,$bs->link('ログアウト' ,array('controller' => 'book_stand_articles' , 'action' => 'admin_logout')));
?>

	</div>
	<h1>BookStand Plugin on CakePHP</h1>
</div>