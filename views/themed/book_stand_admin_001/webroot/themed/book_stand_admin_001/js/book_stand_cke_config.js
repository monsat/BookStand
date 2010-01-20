/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.height = 300;
	
	config.toolbar = [
		['Source','-','Save','NewPage','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print','SpellChecker','Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
		['Maximize','ShowBlocks','-','About'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor']
	];
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	
	config.templates_replaceContent = false;
	config.startupOutlineBlocks = true;
	config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP Code
	
	config.stylesCombo_stylesSet = 'book_stand_styles';
	
	// Do not edit under this line
	config.language = 'ja';
	
	config.width = 640;
	config.resize_minWidth=640;
	config.resize_maxWidth=640;
	// upload
	config.filebrowserBrowseUrl = '/themed/book_stand_admin_001/js/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/themed/book_stand_admin_001/js/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = '/themed/book_stand_admin_001/js/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl = '/themed/book_stand_admin_001/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '/themed/book_stand_admin_001/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserImageUploadUrl = '/themed/book_stand_admin_001/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
};
CKEDITOR.addStylesSet( 'book_stand_styles',[
	/* Block Styles */

	// These styles are already available in the "Format" combo, so they are
	// not needed here by default. You may enable them to avoid placing the
	// "Format" combo in the toolbar, maintaining the same features.
	{ name : 'コード:PHP'		, element : 'pre', attributes : { 'class' : 'brush: php code' } },
	{ name : 'コード:Html'		, element : 'pre', attributes : { 'class' : 'brush: html code' } },
	{ name : 'コード:CSS'		, element : 'pre', attributes : { 'class' : 'brush: css code' } },
	{ name : 'コード:JavaScript', element : 'pre', attributes : { 'class' : 'brush: js code' } },
	{ name : 'コード:shell'		, element : 'pre', attributes : { 'class' : 'brush: shell code' } },
	{ name : 'コード:SQL'		, element : 'pre', attributes : { 'class' : 'brush: sql code' } },
	{ name : 'コード:Plain'		, element : 'pre', attributes : { 'class' : 'brush: plain code' } },
	
	
	/* Inline Styles */

	// These are core styles available as toolbar buttons. You may opt enabling
	// some of them in the Styles combo, removing them from the toolbar.
	{ name : 'Marker: Yellow'	, element : 'span', styles : { 'background-color' : '#ff0' } },
	{ name : 'Marker: LightYellow'	, element : 'span', styles : { 'background-color' : '#ffffe0' } },
	{ name : 'Marker: Green'	, element : 'span', styles : { 'background-color' : '#0f0' } },
	{ name : 'Marker: LightSkyBlue'	, element : 'span', styles : { 'background-color' : '#87cefa' } },

	/* Object Styles */

	{
		name : '（画像）左寄せ',
		element : 'img',
		attributes :
		{
			'style' : 'padding: 5px; margin-right: 5px',
			'class' : 'floatLeft'
		}
	},

	{
		name : '（画像）右寄せ',
		element : 'img',
		attributes :
		{
			'style' : 'padding: 5px; margin-left: 5px',
			'class' : 'floatRight'
		}
	}
]);
