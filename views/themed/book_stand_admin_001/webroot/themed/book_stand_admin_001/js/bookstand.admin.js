$(function(){
	// 共通
	$('html').addClass('JS');
	// 角丸
	$('div.corner , span.corner')
		.filter('.corner-normal').corner().end()
		.filter('.corner-top').corner('top').end()
		.filter('.corner-bottom').corner('top').end()
		.filter('.corner-left').corner('tl bl').end()
		.filter('.corner-right').corner('tr br').end()
	;// End of Corner
});


var BookStandAdmin = {
	
	toggle: function(me ,target) {
		target = target || (me + 'Target');
		$( me ).click( function(){
			$( target ).slideToggle();
		});
	}
	,
	categoryToggle: function(jMe) {
		jMe.live("click" , function(){
			var jTarget = $( '#' + $(this).attr('id') + 'Target' );
			jTarget.toggle();
		});
	}
	,
	//
	selectSaveChange: function() {
		$('#BookStandArticleSaveTypes').change(function(){
			var v = $(this).val();
			var target = $('#bsToggleSaveTypesTarget');
			var status = $('#BookStandArticleBookStandArticleStatusId');
			switch (v) {
				case 'advanced':
					target.slideDown();
					break;
				case 'draft':
					status.val( $('option:contains("draft")' ,status).val() );
					BookStandAdmin.__('保存に[draft]が選択されました。');
					break;
				case 'now':
					status.val( $('option:contains("published")' ,status).val() );
					BookStandAdmin.__('保存に[published]が選択されました。');
					break;
			}
		});
	}
	,
	// カテゴリツリーの編集
	categoryTreeEdit: function(){
		$("a.moveup , a.movedown" , "#categorytree").live("click" ,function(){
			var is_up = $(this).hasClass("moveup");
			var li = $(this).parent("li");
			$.ajax({
				type: "GET"
				,url: $(this).attr("href")
				,cache: false
				,success: function(result) {
						switch (result) {
							case "true":
								li.animate({opacity: 0.2},{
									complete: function() {
										if (is_up) {
											li.after( li.prev("li") );
										} else {
											li.before( li.next("li") );
										}
										li.animate({opacity: 1});
									}
								});
							break;
							case "false":
								BookStandAdmin.__("この操作はできません");
							break;
							default:
								BookStandAdmin.__("データを確認してください");
								console.log(result);
						}
					}
				,error: function() {BookStandAdmin.__("通信に失敗しました");}
			});
			return false;
		});
		$("input:submit" ,"#categorytree").live("click" ,function(){
			var form = $(this).closest("form");
			var name = $("input[name='data[BookStandCategory][name]']" ,form).val();
			var move_id = $("select[name='data[BookStandCategory][parent_id]']" ,form).val();
			
			$.ajax({
				type: "POST"
				,url: $(form).attr("action")
				,data: {
					"data[BookStandCategory][name]": name
					,"data[BookStandCategory][parent_id]": move_id
				}
				,cache: false
				,success: function(result) {
						switch (result) {
							case "false":
								BookStandAdmin.__("データを確認してください");
								console.log(result);
							break;
							default:
								$("#categorytreeWrapper").animate({opacity: 0.2},{
									complete: function() {
										$(this).html(result).animate({opacity: 1});
									}
								});
						}
					}
				,error: function() {BookStandAdmin.__("通信に失敗しました");}
			});
			return false;
		});
	}
	,
	// jGrowlを使用しメッセージを表示する
	__ : function(m,d){ $.jGrowl(m,d) }
	
};