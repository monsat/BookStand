<div id="content">
	<?php $session->flash(); ?>

	<?php echo $bs->tab(1 ,$content); ?>

</div>
<div id="sidenav">
	<?php echo $bs->tabElement(2 ,'sidenav' ,aa('cache',Configure::read('BookStand.cache.elements')) ); ?>

</div>
<div class="clearer"><span></span></div>