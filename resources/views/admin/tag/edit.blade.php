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


<h3 class="title1">标签云管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加标签云</h4>
    </div>
    <div class="form-body">
        <form action="/admin/tag/update/{{$data->id}}" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="tagname">用户名</label> 
            	<input type="text" class="form-control" id="tagname" name="tagname" value="{{ $data->tagname }}" placeholder=""> 
            </div>      
            <div class="form-group"> 
                <label for="bgcolor">主题颜色</label> 
                <input type="color" class="form-control" id="bgcolor" name="bgcolor" value="{{ $data->bgcolor }}" placeholder=""> 
            </div>      
            <button type="submit" class="btn btn-default">修改</button>
			<a href="/admin/tag/index" class="btn btn-default">返回</a>
        </form>
    </div>
</div>

@include('admin.layout.foot')