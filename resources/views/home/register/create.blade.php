<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="/home/js/jquery.min.js" type="text/javascript"></script>
	<script src="/home/js/jquery.easyfader.min.js"></script>
	<link rel="stylesheet" href="/layui/css/layui.css">
	<script src="/layui/layui.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
		layui.use(['layer', 'form'], function(){
		  var layer = layui.layer;
		});
	</script>
</head>
<body>
	<div class="container" style="width:500px">
	<br>
	<form class="layui-form">
		{{ csrf_field() }}
	  <div class="layui-form-item">
	    <label class="layui-form-label">用户名</label>
	    <div class="layui-input-block">
	      <input type="text" name="uname" placeholder="请输入用户名" autocomplete="off" class="layui-input">    
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">密码</label>
	    <div class="layui-input-block">
	      <input type="password" name="upass" placeholder="请输入密码" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">确认密码</label>
	    <div class="layui-input-block">
	      <input type="password" name="reupass" placeholder="请确认密码" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  <div class="layui-form-item">
	    <label class="layui-form-label">验证码</label>
	    <div class="layui-input-inline">
	      <input type="text" name="code" placeholder="请输入验证码" autocomplete="off" class="layui-input">
	    </div>
	    <img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()">
	  </div>
	  <div class="layui-form-item">
	    <div class="layui-input-block">
	      <button class="layui-btn">立刻注册</button>
	      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
	    </div>
	  </div>
	</form>
</div>

<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	// 表单提交事件
	$('form.layui-form').submit(function(){
		// 接收数据
		let uname = $('.layui-form input[name="uname"]').val();
		let upass = $('.layui-form input[name="upass"]').val();
		let reupass = $('.layui-form input[name="reupass"]').val();
		let code = $('.layui-form input[name="code"]').val();

		// 数据验证
		// 验证账号合法性
		let uname_ptn = /^[\w]{8,12}$/; 
		if (!uname_ptn.test(uname)) {
			layer.msg('用户名请输入8-12位数字字母下划线');
			return false;
		}
		// 验证密码合法性
		let upass_ptn = /^[\w]{8,12}$/; 
		if (!upass_ptn.test(upass)) {
			layer.msg('密码请输入8-12位数字字母下划线');
			return false;
		}

		// 验证两次密码一致性 
		if (upass!=reupass) {
			layer.msg('两次密码不一致');
			return false;			
		}

		// 验证验证码的合法性
		let code_ptn = /^[0-9a-zA-Z]{4}$/;
		if (!code_ptn.test(code)) {
			layer.msg('验证码不合法');
			return false;
		}

		// 验证成功,发送ajax
		$.post('/home/register/store',{uname:uname,upass:upass,reupass:reupass,code:code},function(res){
			if (res.msg=='ok') {
				// 弹窗提示注册成功
				layer.msg(res.info);
				// 先提示，过1秒后关闭并跳转
				setTimeout(function(){
					// 关闭弹窗
					window.parent.location.reload();
					var index = parent.layer.getFrameIndex(window.name);
					parent.layer.close(index);
					// 跳转至登录页
					window.parent.location.href = '/home/login/index';
				},1000);
			} else if (res.msg=='error') {
				// 弹窗提示注册失败
				layer.msg(res.info);
			}
		},'json');
		
		// 阻止默认提交表单行为
		return false;
	});
</script>
</body>
</html>



