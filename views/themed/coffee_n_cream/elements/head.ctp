<title><?php echo $title; ?></title>
<script type="text/javascript" src="http://www.google.com/jsapi"></script><script>google.load("jquery", "1.3.2");</script>
<?php
	echo $html->meta('icon') . "\n";
	echo $html->css('default') . "\n";
	echo $html->css('form') . "\n";
	echo $bs->canonical() . "\n";
	echo $javascript->link('bookstand') . "\n";
?>	
