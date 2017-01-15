var util = {

	moreheigh : function(box, low) {
		if (low)
			box.attr("more-heigh", false);
		else
			box.attr("more-heigh", true);
	},

	shake : function(o) {
			o.focus();
			o.addClass('input-empty');
			setTimeout(function(){
				o.removeClass('input-empty');
			}, 500);
	},
	
	reloadCaptcha : function(obj) {
		var src = obj && obj.attr("src") || '/image/captcha';
		src = src.split('?')[0];
		src += "?v=" + Math.random();	
		if (typeof obj == 'object')
			obj.attr("src", src);
		else
			$(".captcha").attr("src", src);
	},

	bindEnter : function(o, callback) {
		o.keydown(function(e){
			if (e.keyCode == 13) {
				if (typeof callback == 'function')
					callback();
			}
		});
	},
	isCh : function(string) {
		return string.match(/^[\u4e00-\u9fa5]+$/);
	},
	hasCh : function(string) {
		return string.match(/[\u4e00-\u9fa5]+/);
	},

	setCookie: function (name,value,exp,path,domain) {
        var exp = exp || 0;
        var et = new Date();
        if ( exp != 0 ) {
            et.setTime(et.getTime() + exp*3600000);
        } else {
            et.setHours(23); et.setMinutes(59); et.setSeconds(59); et.setMilliseconds(999);
        }
        var more = "";
        var path = path || "/";
        var domain = domain || "";
        if (domain != "")
            more += "; domain="+domain;
        more += "; path="+path;
        document.cookie = name + "=" + escape(value) + more + "; expires=" + et.toGMTString();
    },

    getCookie: function (name) {
        var res = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
        return null != res ? unescape(res[2]) : null;
    },

    delCookie: function(name) {
        var value = this.getCookie(name);
        if (null != value) { this.setCookie(name,value,-9); }
    },

	tips : {
		success : function(msg) {
			$("#tips-msg").addClass("tips-msg").html(msg);	
		},
		error : function(msg) {
			$("#tips-msg").addClass("tips-msg tips-msg-error").html(msg);
		}
	},

	template : function(template_id, data, o) {
		var html = $("#"+template_id).html(),
			fields = html.match(/{[a-zA-Z_]+}/g);
		if (fields && fields.length > 1) {
			for (var i in fields) {
				field = fields[i].slice(1,-1);
				html = html.replace(fields[i], data[field]);
			}
			o.html(html);
		}
	},

	loading : function(obj, flag) {
		if (flag)
			obj.addClass("loading");
		else
			obj.removeClass("loading");
	},
	disablebtn : function(obj, flag) {
		if (flag)
			obj.addClass("btn-disabled");
		else
			obj.removeClass("btn-disabled");
	},

	find_value_inarray_bykey : function(array, key, key_key, key_value) {
		for (var i in array) {
			if (array[i][key_key] == key)
				return array[i][key_value];
		}
		return "";
	},

	tooltip : function(o, title, hide) {
		var option = {
			//placement:'bottom',
			trigger : 'click'
		};
		if (title)
			$(o).attr("data-original-title", title);
		if (hide) {
			$(o).attr("data-original-title", "").tooltip('hide');
		} else {
			$(o).tooltip(option).tooltip('show');
		}
	},

	msg : {
		success : function(msg) {
			alert(msg);
		},

		error : function(msg) {
			alert(msg);
		}
	}
};

//submit functions of elements that has attribute submit
//<button type="submit" submit="form name" submit-ok="function name" submit-ok-param="some params"></button>
var submit = {
	//reload comment list for detail
	comment_reload: function(id) {
		$.get('/comment/', {bid:id}, function(res){
			console.log(res);
		});
	},

	//append the comment to comment list after somebody comment the blog
	comment_append: function(data) {
		$("#comments").append(data);
		$("#comment-publish [name=pid]").val(0);
	}
};

//functions of elements that has attribute func
//<element func="function name" func-param="arguments for function"></element>
var func = {
	//reply of detail's comment
	comment_reply : function(comment_id) {
		var _comment = $("[comment-id="+comment_id+"]");
		var _uname = _comment.find(".comment-uname").text();
		var _content = _comment.find(".comment-content").html();
		var content = "<blockquote><quote>Refer to "+_uname+"'s comment:</quote>"+_content+"</blockquote>";
		$("#comment-publish [name=content]").val(content).focus();
		$("#comment-publish [name=pid]").val(comment_id);
	},

	//approve detail's comment
	comment_approve : function(comment_id) {
		$.get('/comment/'+comment_id+'/approve', function(res){
			if (res.status > 0)
				return util.msg.error(res.msg);
			var _o = $("[comment-id="+comment_id+"] .comment-approve");
			var _old = parseInt(_o.text());
			_old += 1;
			_o.text(_old);
		});	
	}
};

$(function(){

	$("[type=checkbox]").on("click", function(){
		if ($(this).attr("checked"))
			util.form.checkbox.check($(this), false);
		else
			util.form.checkbox.check($(this));
	});

	var form = {
		checkbox : {
			check : function(obj, checked)
			{
				if (checked == undefined)
					checked = true;
				if (checked)
					obj.attr("checked", true);
				else
					obj.removeAttr("checked");
			},
			isChecked : function(obj) {
				return obj.attr("checked") ? true : false;
			}
		},
	};


	$.extend(util, {form : form});

	$("textarea").on("focus", function(){
		util.moreheigh($(this));
	})
	$("textarea").on("blur", function(){
		util.moreheigh($(this), true);
	})

	$('.collapse').collapse();

	$(".search").each(function(){
		var form = $(this),
			_btn = form.find(".btn-search");
		_btn.on("click", function(){
			form.submit();
		})
	});

	//disabled
	$(".disabled").find("input").each(function(){
		$(this).attr("disabled", true);
	});

	$(".captcha").on("click", function(){
		util.reloadCaptcha($(this));
	});

	//msg tips
	if (util.getCookie('msg'))
	{
		if ($("#tips-msg").size() > 0)
		{
			util.tips.success(util.getCookie('msg'));
		}
		util.delCookie('msg');
	}

	$("[ajax=true]").each(function(){
		var $this = $(this);
		$this.on("click", function(){
			var action = $this.attr("ajax-action"),
				data = {};
			if (!action)
				return false;
			var ajax_data = $this.attr("ajax-data");
			if (ajax_data) {
				$.extend(data, {data:ajax_data});
			}
			$.ajax({
				url : action,
				dataType : "json",
				type : "post",
				data : data,
				success : function(res) {
					if (res.ret < 1) {
						alert(res.msg);
						return false;
					}
					var modal = $this.attr("ajax-modal");
					if (modal) {
						$("#modal-content").html(res.data.html);
						$(modal).modal();
					} else {
						location.reload();
					}
				}
			});
			return false;
		})
	});

	if (typeof(datetimepicker) != 'undefined') {
		$(".datepicker").datetimepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			minView:2
		});
	}

	//delete tooltip for input
	$("body").delegate("input,textarea", "focus", function(){
		util.tooltip($(this), null, true);
	});

	//bind event for element that has attribute submit
	$("body").delegate("[submit]", "click", function(){
		var _this = $(this);
		var _formname = $(this).attr("submit");
		var _form = $("form[name="+_formname+"]");
		var _func = $(this).attr("submit-ok");
		var _func_param = $(this).attr("submit-ok-param");

		var data = _form.serialize();
		$.ajax({
			url : _form.attr("action"),
			type : "post",
			dataType : "json",
			data : data,
			success : function(res) {
				if (res.status > 0) {
					if (res.msg)
						util.msg.error(res.msg);
					if (res.data) {
						$.each(res.data, function(k,v){
							for (var i in v) {
								util.tooltip("[name="+k+"]", v);
							}
						});
					}
					return;
				}
				//util.msg.success(res.msg);
				if (_func == undefined) {
					return _form[0].reset();
				}

				if (typeof submit[_func] == "function") {
					if (_func_param == undefined)
						_func_param = res.data;
					submit[_func](_func_param);
				}

				return _form[0].reset();
			}
		});
		return false;
	})

	//bind elements's attr func
	$("body").delegate("[func]", "click", function(){
		var _this = $(this);
		var _func = _this.attr("func");
		var _func_param = _this.attr("func-param");
		if (typeof func[_func] == "function") {
			func[_func](_func_param);
		}
		return false;
	});

});
