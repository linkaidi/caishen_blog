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
        <form action="/admin/tag/store" method="post">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="tagname">名称</label> 
            	<input type="text" class="form-control" id="tagname" name="tagname" value="{{ old('tagname') }}"> 
            </div>
            <div class="form-group"> 
            	<label for="bgcolor">颜色</label> 
            	<input type="color" id="bgcolor" name="bgcolor" value="{{ old('bgcolor') }}">
            </div>
			<button type="submit" class="btn btn-default">添加</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')