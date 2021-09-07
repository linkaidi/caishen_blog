<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class TagController extends Controller
{
	// 后台 标签云 添加 显示
    public function create()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();
    	return view('admin.tag.create',['admin_userinfo'=>$admin_userinfo]);
    }

    // 后台 标签云 添加 操作
    public function store(Request $request)
    {
        if (Redis::exists('tag_redis_data')) {
            // 删除标签云数据缓存
            Redis::del('tag_redis_data');
        }

    	// 过滤垃圾数据
    	$this->validate($request, [
	        'tagname' => 'required',
	        'bgcolor' => 'required|regex:/^#[0-9a-f]{6}$/',
    	],[
    		'tagname.required' => '标签云名称不能为空',
    		'bgcolor.required' => '标签云主题颜色不能为空',
    		'bgcolor.regex' => '标签云主题格式不合法',
    	]);

    	// 接收标签云数据
    	$data['tagname'] = $request->input('tagname','其他');
    	$data['bgcolor'] = $request->input('bgcolor','#000000');

    	// 插入数据
    	$res = DB::table('tags')->insert($data);
		if ($res) {
			return redirect('admin/tag/index')->with('success','添加标签云成功');
		} else {
			return back()->with('error','添加标签云失败');
		}
	}

	// 后台 标签云 列表 显示
	public function index(Request $request)
	{
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

		$serach = $request->input('serach','');
		// 查询标签云数据
		$data = DB::table('tags')->where('tagname','like',"%{$serach}%")->paginate(10);
		return view('admin.tag.index',['data'=>$data,'serach'=>$serach,'admin_userinfo'=>$admin_userinfo]);
	}

	// 后台 标签云 修改 显示
	public function edit($id)
	{
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

		$data = DB::table('tags')->where('id',$id)->first();
		return view('admin.tag.edit',['data'=>$data,'admin_userinfo'=>$admin_userinfo]);
	}

	// 后台 标签云 修改 操作
	public function update(Request $request,$id)
	{
        if (Redis::exists('tag_redis_data')) {
            // 删除标签云数据缓存
            Redis::del('tag_redis_data');
        }

    	// 过滤垃圾数据
    	$this->validate($request, [
	        'tagname' => 'required',
	        'bgcolor' => 'required|regex:/^#[0-9a-f]{6}$/',
    	],[
    		'tagname.required' => '标签云名称不能为空',
    		'bgcolor.required' => '标签云主题颜色不能为空',
    		'bgcolor.regex' => '标签云主题格式不合法',
    	]);

    	// 接收数据
    	$data['tagname'] = $request->input('tagname','其他');
    	$data['bgcolor'] = $request->input('bgcolor','#000000');

    	// 更新数据
    	$res = DB::table('tags')->where('id',$id)->update($data);
		if ($res) {
			return redirect('admin/tag/index')->with('success','标签云修改成功');
		} else {
			return back()->with('error','标签云修改失败');
		}
	}

	// 后台 标签云 删除 操作
	public function destory(Request $request)
	{	
        if (Redis::exists('tag_redis_data')) {
            // 删除标签云数据缓存
            Redis::del('tag_redis_data');
        }
		$id = $request->input('id',0);
		$res = DB::table('tags')->where('id',$id)->delete();
		if ($res) {
			echo 'OK';
		} else {
			echo 'error'; 
		}
	}
}
