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


<h3 class="title1">栏目管理</h3>
<div class="form-grids row widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
        <h4>添加栏目</h4>
    </div>
    <div class="form-body">
        <form action="/admin/cate/store" method="post">
        	{{ csrf_field() }}
            <div class="form-group"> 
            	<label for="cname">栏目名</label> 
            	<input type="text" class="form-control" id="cname" name="cname" value="{{ old('cname') }}" autocomplete="off"> 
            </div>
            <div class="form-group"> 
                <label for="pid">所属栏目</label> 
                <select id="pid"  name="pid" class="form-control">
                    <option value="0">--请选择--</option>
                    @foreach ($data as $v)
                    @if($v->pid == 0)
                        <option value="{{ $v->id }}" {{ $id==$v->id ? 'selected' : ''}} style="font-weight:bold;">{{ $v->cname }}</option>
                    @else
                        <option value="{{ $v->id }}" disabled>|------{{ $v->cname }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

			<button type="submit" class="btn btn-default">添加</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')