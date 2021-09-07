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


<h3 class="title1">轮播图管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加轮播图</h4>
    </div>
    <div class="form-body">
        <form action="/admin/banner/store" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="title">标题</label> 
            	<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"> 
            </div>
            <div class="form-group"> 
                <label for="desc">描述</label> 
                <input type="text" class="form-control" id="desc" name="desc" value="{{ old('desc') }}"> 
            </div>
            <div class="form-group"> 
                <label for="status">状态</label> 
                <input type="radio" id="status" name="status" value="0" checked> 未激活
                <input type="radio" id="status" name="status" value="1"> 激活
            </div>
            <div class="form-group"> 
            	<label for="url">链接</label> 
            	<input type="file" id="url" name="url">
            </div>
			<button type="submit" class="btn btn-default">添加</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')