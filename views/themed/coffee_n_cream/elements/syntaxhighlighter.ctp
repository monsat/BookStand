<?php
$base = 'http://alexgorbatchev.com/pub/sh/2.0.320/';
$scripts = $base . 'scripts/';
$styles = $base . 'styles/';

echo $javascript->link($scripts . 'shCore.js') . "\n";
echo $javascript->link($scripts . 'shBrushBash.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushCpp.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushCSharp.js') . "\n";
echo $javascript->link($scripts . 'shBrushCss.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushDelphi.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushDiff.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushGroovy.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushJava.js') . "\n";
echo $javascript->link($scripts . 'shBrushJScript.js') . "\n";
echo $javascript->link($scripts . 'shBrushPhp.js') . "\n";
echo $javascript->link($scripts . 'shBrushPlain.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushPython.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushRuby.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushScala.js') . "\n";
echo $javascript->link($scripts . 'shBrushSql.js') . "\n";
//	echo $javascript->link($scripts . 'shBrushVb.js') . "\n";
echo $javascript->link($scripts . 'shBrushXml.js') . "\n";
echo $html->css($styles . 'shCore.css') . "\n";
echo $html->css($styles . 'shThemeDefault.css') . "\n";

?>
<script type="text/javascript">
	$(function(){
		SyntaxHighlighter.config.clipboardSwf = '<?php echo $scripts; ?>clipboard.swf';
		SyntaxHighlighter.all();
	});
</script>
