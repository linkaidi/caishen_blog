@include('admin.layout.head')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<h3 class="title1">用户管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加用户</h4>
    </div>
    <div class="form-body">
        <form action="/admin/user/update/{{$data->id}}/{{$data->token}}" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="uname">用户名</label> 
            	<input type="text" class="form-control" id="uname" name="uname" value="{{ $data->uname }}" placeholder=""> 
            </div>            
            <div class="form-group"> 
            	<label for="email">邮箱</label> 
            	<input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" placeholder=""> 
            </div>
        	<label for="profile">更换头像</label> 
            <div class="form-group"> 
                <img data-src="holder.js/140x140" class="img-thumbnail" alt="140x140" src="/uploads/{{ $data->profile }}" data-holder-rendered="true" style="width: 100px; height: 100px;">
            	<input type="file" id="profile" name="profile">
                <input type="hidden" name="profile_path" value="{{ $data->profile }}">
            </div>
            <button type="submit" class="btn btn-default">修改</button>
			<a href="/admin/user/index" class="btn btn-default">返回</a>
        </form>
    </div>
</div>

@include('admin.layout.foot')