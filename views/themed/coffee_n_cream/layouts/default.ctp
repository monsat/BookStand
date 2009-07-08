<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html lang="ja">
<head>
	<?php echo $bs->tabElement(1, 'head' ,aa('title',$title_for_layout , 'cache',Configure::read('BookStand.cache.elements')) ); ?>

	<?php echo $bs->tabElement(1, 'syntaxhighlighter' ,aa('cache',Configure::read('BookStand.cache.elements')) ); ?>

	<script type="text/javascript">
		$(function(){
			<?php echo $scripts_for_layout; ?>

		});
	</script>
</head>
<body>
<div id="container">
	<div id="header">
		<?php echo $bs->tabElement(2 ,'header' ,aa('cache',Configure::read('BookStand.cache.elements')) ); ?>

	</div>
	<div id="navigation">
		<?php echo $bs->tabElement(2 ,'navigation' ,aa('cache',Configure::read('BookStand.cache.elements')) ); ?>

	</div>
	<div id="main">
		<?php echo $bs->tabElement(2 ,'main' ,aa('content',$content_for_layout) ); ?>

	</div>
	<div id="footer">
		<?php echo $bs->tabElement(2 ,'footer' ,aa('cache',Configure::read('BookStand.cache.elements')) ); ?>

	</div>
</div>
<?php echo $cakeDebug; ?>

<?php echo $this->element('analytics' ,aa('cache',Configure::read('BookStand.cache.elements'))); ?>

</body>
</html>
