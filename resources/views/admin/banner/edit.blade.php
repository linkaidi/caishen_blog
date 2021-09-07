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
        <h4>修改轮播图</h4>
    </div>
    <div class="form-body">
        <form action="/admin/banner/update" method="post" enctype="multipart/form-data">
        	{{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="form-group"> 
            	<label for="title">标题</label> 
            	<input type="text" class="form-control" id="title" name="title" value="{{ $data->title }}"> 
            </div>
            <div class="form-group"> 
                <label for="desc">描述</label> 
                <input type="text" class="form-control" id="desc" name="desc" value="{{ $data->desc }}"> 
            </div>
            <div class="form-group"> 
                <label for="status">状态</label> 
                <input type="radio" id="status" name="status" value="0"{{ $data->status==0? 'checked' : ''}}> 未激活
                <input type="radio" id="status" name="status" value="1"{{ $data->status==1? 'checked' : ''}}> 激活
            </div>
            <img data-src="holder.js/140x140" src="/uploads/{{ $data->url }}" alt="轮播图" class="img-thumbnail"  data-holder-rendered="true" style="width: 300px; height: 160px;">
            <div class="form-group"> 
            	<label for="url">链接</label> 
            	<input type="file" id="url" name="url">
                <input type="hidden" name="url_path" value="{{ $data->url }}">
            </div>
			<button type="submit" class="btn btn-default">修改</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')