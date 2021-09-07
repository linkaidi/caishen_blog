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
        <h4>修改栏目</h4>
    </div>
    <div class="form-body">
        <form action="/admin/cate/update" method="post">
            {{ csrf_field() }}
            <div class="form-group"> 
                <input type="hidden" name="id" value="{{ $first->id }}">
                <label for="cname">栏目名</label> 
                <input type="text" class="form-control" id="cname" name="cname" value="{{ $first->cname }}" autocomplete="off"> 
            </div>
            <div class="form-group"> 
                <label for="pid">所属栏目</label> 
                <select id="pid"  name="pid" class="form-control">
                    <option value="0">--请选择--</option>
                    @foreach ($data as $v)
                        @if ($first->pid!=0)
                            @if ($v->id == $first->pid)
                                    <option value="{{ $v->id }}" selected style="font-weight:bold;">{{ $v->cname }}</option>
                            @else
                                @if ($v->pid!=0)
                                    <option value="{{ $v->id }}" disabled>|------{{ $v->cname }}</option>
                                @else
                                    <option value="{{ $v->id }}" style="font-weight:bold;">{{ $v->cname }}</option>
                                @endif
                            @endif 
                        @else
                            <option value="{{ $v->id }}" disabled style="font-weight:bold;">{{ $v->cname }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-default">修改</button>
        </form>
    </div>
</div>

@include('admin.layout.foot')