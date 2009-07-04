<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="ja">
<head>
	<?php echo $bs->tabElement(1, 'admin_head' ,aa('title',$title_for_layout , 'scripts',$scripts_for_layout , 'cache',"2 seconds") ); ?>

	<script type="text/javascript">
		$(function(){
			<?php echo $scripts_for_layout; ?>

		});
	</script>
</head>
<body>
<div id="container">
	<div id="header">
		<?php echo $bs->tabElement(2 ,'admin_header'); ?>

	</div>
	<div id="navigation">
		<?php echo $bs->tabElement(2 ,'admin_navigation' ,aa('cache',"2 seconds") ); ?>

	</div>
	<div id="main" class="clearfix">
		<?php echo $bs->tabElement(2 ,'admin_main' ,aa('content',$content_for_layout) ); ?>

	</div>
	<div id="footer">
		<?php echo $bs->tabElement(2 ,'admin_footer' ,aa('cache',"2 seconds") ); ?>

	</div>
</div>
<?php echo $cakeDebug; ?>

</body>
</html>
