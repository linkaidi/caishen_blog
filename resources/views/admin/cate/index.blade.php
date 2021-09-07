@include('admin.layout.head')
	<h3 class="title1">栏目管理</h3>
	<div class="panel-body widget-shadow">
    <h4>栏目列表</h4>
    
    <table class="table">
        <thead>
            <tr>
                <th>栏目ID</th>
                <th>栏目名称</th>
                <th>父级ID</th>
                <th>等级路径</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        	@foreach ($data as $v)
                @if ($v->pid == 0)
                    <tr class="success">
                @else
                    <tr class="info">
                @endif
                        <td>{{ $v->id }}</td>
                        
                        @if ($v->pid == 0)
                           <td style="font-weight:bold;">{{ $v->cname }}</td>
                        @else
                           <td>|------{{ $v->cname }}</td>
                        @endif
                        <td>{{ $v->pid }}</td>
                        <td>{{ $v->path }}</td>
                        <td>
                            <a href="/admin/cate/edit/{{ $v->id }}" class="btn btn-success">修改栏目名称</a>
                            @if ($v->pid == 0)
                                <a href="/admin/cate/create/{{ $v->id }}" class="btn btn-info">增加子栏目</a>
                            @endif
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@include('admin.layout.foot')