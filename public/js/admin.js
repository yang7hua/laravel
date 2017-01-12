var util = {
	url : function(url) {
		return '/xadmin/'+url;
	},
};
var sys = {
	//加载左侧菜单
	load_menu : function() {
		var _o = $("#dashboard-left .menubox");
		$.get(util.url('sys/menus'), function(res) {
			if (res.status < 1) {
				return;
			}
			$.each(res.data, function(k, row){
				var html = '<a href="'+row.link+'" class="menu">';
				if (row.module == _MODULE_NAME) {
					html = '<a href="'+row.link+'" class="menu on">';
					//$("#dashboard-top-title").text(row.text);
				}
				html += '<span class="glyphicon glyphicon-'+row.icon+'"></span>'+row.text+'</a>';
				_o.append(html);
			});
		});
	},
	load_page : function(url) {
		var _o = $("#page");
		$.get(url, function(res) {
			_o.html(res.data);
		});
	}
};

$(function(){
	sys.load_menu();
	$("body").delegate("[menu-link]", "click", function(){
		var href = $(this).attr("menu-link");
		sys.load_page(href);
		return false;
	});
});
