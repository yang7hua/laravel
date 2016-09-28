//这里可以在提交的时候临时指定
var data = null;

$(function(){
	
	function analyseFieldValidator(obj)
	{
		var _class = obj.attr("class");
		if (!_class)
			return;
		var sepStart = _class.indexOf('{'),
			sepEnd = _class.lastIndexOf('}');
		if (sepStart == -1 || sepEnd == -1)
			return;
		var validator_str = _class.substr(sepStart, sepEnd);
		return validator_str;
	}

	function getFieldName(obj)
	{
		return obj.attr("name") || null;
	}

	function ajaxSubmitCallback(res)
	{
		//res = eval('(' + res + ')');
		if (res['status'] < 1) {
			alert(res['info']);
			util.reloadCaptcha();
			return;
		}
		if (res.info)
			util.setCookie('msg', res.info);

		if (res.url)
			location.href = res.url;
		//location.reload();
	}

	//表单提交
	$.validator.setDefaults({
			debug : true,
			ignore : ".ignore",
			focusInvalid : false,
			submitHandler : function(form){
				var Form = $(form),
					btn = Form.find("[type=submit]");
				$(form).ajaxSubmit({
					data : data,
					beforeSubmit : function(){
						btn.addClass("btn-disabled");		
					},
					success : function(res){
						btn.removeClass("btn-disabled");	
						ajaxSubmitCallback(res);
					},
					timeout : 3000
				});
				return false;
			},
			errorPlacement : function(error, element) {
				var box = element.parents('.form-group').find(".help-block");
				/*
				if (box.size() < 1) {
					var placeholder = element.attr('placeholder');
					error = "<p>"+placeholder + error[0]['outerText'] + "<p>";
					box = element.parents('.form-group').siblings('.msg-block');
					box.append(error).show();
					return;
				}
				*/
				error.appendTo(box);
			}
	});

	$.validator.addMethod('regex', function(value, element, param){
		//var regex = new RegExp(param); 
		var regex = new RegExp(param);
		
		return regex.test(value);
	}, "格式不正确");

	$.validator.addMethod('ch', function(value, element, param){
		return util.isCh(value); 
	}, "必须为中文");

	$.validator.addMethod('date', function(value, element, param){
		var regex = new RegExp('^(20[\\d]{2}-[\\d]{1,2}-[\\d]{1,2})?$'); 
		return regex.test(value);
	}, "格式不正确");

	//表单验证
	$("form").each(function(){
		var form = $(this),
			fields = form.find("[name]");
		if (fields.size() < 1)
			return;
		if (form.hasClass("search"))
			return;
		if (form.attr("init"))
			return;
		form.attr("init", 1);

		var rules = {};
		fields.each(function(){
			var $this = $(this);
			var name = getFieldName($this),
				validator_str = analyseFieldValidator($this);
			if (name && validator_str) {
				rules[name] = eval('('+validator_str+')');
			}
		});	
		form.validate({
			rules : rules,
			messages : {
				uname : {
					remote : "已存在"
				}
			}
		});
	});
});
