var util = {
	url : function(url) {
		return '/xadmin/'+url;
	},
};
var sys = {
	//加载左侧菜单
	load_menu : function() {
		var _o = $("#menu .list-group");
		$.get(util.url('sys/menus'), function(res) {
			if (res.status < 1) {
				return;
			}
			$.each(res.data, function(k, row){
				_o.append('<a href="#" menu-link="'+row.link+'" class="list-group-item">'+row.text+'</a>');
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
