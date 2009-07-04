<div id="content">
	<?php $session->flash(); ?>

	<?php echo $bs->tab(1 ,$content); ?>

</div>
<div id="sidenav">
	<?php echo $bs->tabElement(2 ,'admin_sidenav' ,aa('cache',"2 seconds") ); ?>

</div>
