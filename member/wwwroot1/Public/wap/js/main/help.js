var helpTypeList1;
$(document).ready(
		function() {
			$.ajax({
				url : 'getHelpsList.act',
				type : 'POST',
				dataType : 'json',
				// timeout: 1000,
				error : function() {
				},
				success : function(txt) {
					helpTypeList1 = txt.data;
					var length = helpTypeList1.length;
					if (length == 0)
						return;
					var leftnav = $('<ul class="leftnav" >');
					for ( var i = 0; i < length; i++) {
						var helpType1 = helpTypeList1[i];
						var li = $('<li >');
						var hh = $('<h4><input type="hidden" value="'
								+ helpType1.id + '"><a href="#">'
								+ helpType1.type_name + '</a></h4>');
						li.append(hh);
						var helpTypeList2 = helpType1.helpTypeList;
						var ull = $('<ul>');
						for ( var j = 0; j < helpTypeList2.length; j++) {
							var helpType2 = helpTypeList2[j];
							var li2 = $('<li>');
							var a2 = $('<a href="javascript:onselect('
									+ helpType2.id + ');">'
									+ helpType2.type_name + '</a>');
							li2.append(a2);
							ull.append(li2);
						}
						li.append(ull);
						leftnav.append(li);
					}
					$('#leftnav1').append(leftnav);
					$('.leftnav').find('li').click(
							function(event) {
								$('.leftnav li,.leftnav h4')
										.removeClass('curr');
								$(this).addClass('curr');
								if ($(this).parents('li').length > 0) {// 点击二级菜单
									$(this).parents('li').addClass('curr');
									$(this).parents('ul').siblings('h4')
											.addClass('curr');
									var ht=$(this).parents('ul').siblings('h4').children("a").html();
									var htp=$(this).children("a").html();
									var obj1=$(this).parents('li');
									var dv='<a href="help">帮助中心</a> &gt;&gt; <a href="javascript:onselects();">'+ht+'</a> &gt;&gt; '+htp;
									$('.help_path').html(dv);
								} else {// 点击一级菜单
									$(this).find('h4').addClass('curr');
									var content = $(this).find('h4').find(
											'input').val();
									$('#question_content').html(
											showHelpContent(content));
									var ht=$(this).find('h4').children("a").html();
									$('.help_path').html('<a href="#">帮助中心</a> &gt;&gt; '+ht);
								}
								event.stopPropagation();
							});

				}
			});

		});

function onselects(){
	  $('li .curr').click();
}

function showHelpContent(id) {
	for ( var k = 0; k < helpTypeList1.length; k++) {
		var h = helpTypeList1[k];
		if (h.id == id) {
			var hhList = h.helpTypeList;
			var html = '';
			for ( var i = 0; i < hhList.length; i++) {
				var hh = hhList[i].helpInfoList;
				for ( var j = 0; j < hh.length; j++) {
					var help = hh[j];
					var dt = '<dl class="question_cat" id="question_content"><dt><a href="#" class="curr">'
						+ help.title
						+ '</a></dt><dd class="curr">'
						+ help.content + '</dd></dl>';
					html += dt;
				}
			}
			$('#help_content').html(
					'<dl class="question_list">' + html + '</dl>');
		}
	}
	$('.question_cat').find('dt').click(function(event) {
		var na=$(this).siblings('dd');
		var name=na.attr('class');
		if(name=='curr'){ 
			$(this).siblings('dd').removeClass('curr');
			$(this).find('a').removeClass('curr');
		}
		else { 
			$(this).siblings('dd').addClass('curr');
			$(this).find('a').addClass('curr');
		}
		event.stopPropagation();
	});
}

function onselect(id) {
	for ( var k = 0; k < helpTypeList1.length; k++) {
		var h = helpTypeList1[k];
		var hhList = h.helpTypeList;
		var html = '';
		for ( var i = 0; i < hhList.length; i++) {
			var hq = hhList[i];
			if (hq.id == id) {
				var hh = hq.helpInfoList;
				for ( var j = 0; j < hh.length; j++) {
					var help = hh[j];
					var dt = '<dt>'
						+ help.title
						+ '</dt><dd><div class="help_box_t"></div><div class="help_box_m"><em>答：</em><span>'
						+ help.content
						+ '</span></div><div class="help_box_b"></div></dd>';
					html += dt;
				}
				$('#help_content').html(
						'<dl class="question_list">' + html + '</dl>');
			}
		}
	}

}
