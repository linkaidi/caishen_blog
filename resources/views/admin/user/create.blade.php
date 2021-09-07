@include('admin.layout.head')

<h3 class="title1">用户管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加用户</h4>
    </div>
    <div class="form-body">
        <form action="/admin/user/store" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="uname">用户名</label> 
            	<input type="text" class="form-control" id="uname" name="uname" value="{{ old('uname') }}" placeholder="请输入8-12位数字字母下划线"> 
            </div>
            <div class="form-group"> 
            	<label for="upass">密码</label> 
            	<input type="password" class="form-control" id="upass" name="upass" placeholder="请输入8-12位数字字母下划线"> 
            </div>
            <div class="form-group"> 
            	<label for="repass">确认密码</label> 
            	<input type="password" class="form-control" id="repass" name="repass" placeholder="请输入8-12位数字字母下划线"> 
            </div>
            <div class="form-group"> 
            	<label for="profile">请上传头像</label> 
            	<input type="file" id="profile" name="profile">
            </div>
			<button type="submit" class="btn btn-default">添加</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')