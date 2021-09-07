<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class CateController extends Controller
{
    public static function cnamesList()
    {
        $list = DB::table('cates')->select(DB::raw('concat(path,",",id) as pi'),'id','cname','pid','path')->orderby('pi','asc')->get();
        return $list;
    }

	// 后台 栏目 添加 显示
	public function create($id = 0)
	{
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

		// 获取所属栏目名称列表
		$data = self::cnamesList();
		return view('admin.cate.create',['data'=>$data,'id'=>$id,'admin_userinfo'=>$admin_userinfo]);
	}

	// 后台 栏目 添加 操作
    public function store(Request $request)
    {
        if (Redis::exists('cates_redis_data')) {
            // 删除栏目数据缓存
            Redis::del('cates_redis_data');
        } else if (Redis::exists('cateNames_redis_data')) {
            // 删除栏目名称数据缓存
            Redis::del('cateNames_redis_data');
        }



    	// 过滤垃圾数据
    	$this->validate($request, [
        	'cname' => 'required'
    	],[
    		'cname.required' => '栏目名称不能为空'
    	]);
    	// 接收所属栏目id
    	$pid = $request->input('pid',0);
    	// 判断栏目等级，拼接顶级path
    	if ($pid == 0) {
    		$path = $pid;
    	} else {
    		$cates = DB::table('cates')->where('id',$pid)->select('path')->first();
    		$path = $cates->path.','.$pid;
    	}
    	$data['cname'] = $request->input('cname','');
    	$data['pid'] = $pid;
    	$data['path'] = $path;
    	// 插入数据
    	$res = DB::table('cates')->insert($data);
    	if ($res) {
    		return redirect('/admin/cate/index')->with('success','添加栏目成功');
    	} else {
    		return back()->with('error','添加栏目失败');
    	}
    }

	// 后台 栏目 列表 显示
    public function index()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();
    	// 查询栏目数据
    	$data = $data = self::cnamesList();
    	return view('admin.cate.index',['data'=>$data,'admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 栏目 修改 显示
    public function edit($id)
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

        $first = DB::table('cates')->where('id',$id)->first();
        $data = self::cnamesList();
        return view('admin.cate.edit',['first'=>$first,'data'=>$data,'admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 栏目 修改 操作
    public function update(Request $request)
    {
        if (Redis::exists('cates_redis_data')) {
            // 删除栏目数据缓存
            Redis::del('cates_redis_data');
        } else if (Redis::exists('cateNames_redis_data')) {
            // 删除栏目名称数据缓存
            Redis::del('cateNames_redis_data');
        }
        // 过滤垃圾数据
        $this->validate($request, [
            'cname' => 'required'
        ],[
            'cname.required' => '栏目名称不能为空'
        ]);
        // 接收所属栏目id
        $pid = $request->input('pid',0);
        // 判断栏目等级，拼接顶级path
        if ($pid == 0) {
            $path = $pid;
        } else {
            $cates = DB::table('cates')->where('id',$pid)->select('path')->first();
            $path = $cates->path.','.$pid;
        }
        $id = $request->input('id',0);
        $data['cname'] = $request->input('cname','');
        $data['pid'] = $pid;
        $data['path'] = $path;
        // 插入数据
        $res = DB::table('cates')->where('id',$id)->update($data);
        if ($res) {
            return redirect('/admin/cate/index')->with('success','修改栏目成功');
        } else {
            return back()->with('error','修改栏目失败');
        }
    }
}
