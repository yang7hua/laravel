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
	//点击菜单加载页面
	load_page : function(url) {
		var _o = $("#page");
		$.get(url, function(res) {
			_o.html(res.data);
		});
	},

	//分页加载
	page : {
		target : null,
		init : function() {
			this.target = $("[page-url]");
			var $this = this;
			$.each(this.target, function(a, b){
				var _target = $($(b).attr("page-target")); 
				_target.delegate(".pagination li a", "click", function(){
					var href = $(this).attr("href");
					var match = href.match(/page=(\d+)/);
					var page = match[1];
					_target.attr("page-page", page);
					$this.load(_target);
					return false;
				});
			});
			return this;
		},
		load : function(target) {
			if (target == undefined)
				target = this.target;
			$.each(target, function(a, b){
				var _o = $(b);
				var _url = _o.attr("page-url");
				var _target = $(_o.attr("page-target")); 
				var _page = _o.attr("page-page");
				$.ajax({
					url : _url,
					type : "get",
					dataType : "json",
					data : {
						page : _page
					},
					success : function(res) {
						if (res.status < 1)
							return;
						_target.html(res.data);
					}
				});
			})
		}
	}
};

$(function(){
	sys.load_menu();
	$("body").delegate("[menu-link]", "click", function(){
		var href = $(this).attr("menu-link");
		sys.load_page(href);
		return false;
	});

	sys.page.init().load();
});
