<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use DB;
use Illuminate\Support\Facades\Redis;
class BannerController extends Controller
{
	// 后台 轮播图 添加 显示
    public function create()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();
    	return view('admin.banner.create',['admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 轮播图 添加 操作
    public function store(Request $request)
    {
        if (Redis::exists('banner_redis_data')) {
            // 删除轮播图数据缓存
            Redis::del('banner_redis_data');
        }

    	// 过滤垃圾数据
    	$this->validate($request, [
	        'title' => 'required',
	        'desc' => 'required',
	        'status' => 'required|regex:/^[01]{1}$/',
	        'url' => 'required'
    	],[
    		'title.required' => '标题不能为空',
    		'desc.required' => '描述不能为空',
    		'status.required' => '状态不能为空',
    		'status.regex' => '状态不合法',
    		'url.required' => 'url不能为空',
    	]);

    	// 验证文件并上传
    	if ($request->hasFile('url') && $request->file('url')->isValid()) {
			$data['url'] = $request->file('url')->store(date('Ymd',time()));
    	} else {
    		return back()->with('error','轮播图上传失败');
    	}

    	// 接收数据
    	$data['title'] = $request->input('title','');
    	$data['desc'] = $request->input('desc','');
    	$data['status'] = $request->input('url',0);

    	// 插入数据
    	$res = DB::table('banners')->insert($data);

    	if ($res) {
    		return redirect('admin/banner/index')->with('success','轮播图添加成功');
    	} else {
            // 插入数据失败，删除上传的图片
            Storage::delete($data['url']);
    		return back()->with('error','轮播图添加失败');
    	}
    }

	// 后台 轮播图 列表 显示
    public function index(Request $request)
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

        $serach = $request->input('serach','');
    	// 查询数据
    	$data = DB::table('banners')->where('title','like',"%{$serach}%")->orderBy('id','asc')->paginate(3);
    	return view('admin.banner.index',['data'=>$data,'serach'=>$serach,'admin_userinfo'=>$admin_userinfo]);
    }

	// 后台 轮播图 修改状态 操作
	public function changeStatus(Request $request)
	{	
        if (Redis::exists('banner_redis_data')) {
            // 删除轮播图数据缓存
            Redis::del('banner_redis_data');
        }

		// 过滤垃圾数据
    	$this->validate($request, [
	        'id' => 'required',
	        'status' => 'required|regex:/^[01]{1}$/'
    	],[
    		'id.required' => 'id不能为空',
    		'status.required' => '状态不能为空',
    		'status.regex' => '状态不合法'
    	]);

    	// 接收数据
    	$id = $request->input('id',0);
  		$status = $request->input('status',0);

  		$res = DB::table('banners')->where('id',$id)->update(['status'=>$status]);

  		if ($res) {
  			return redirect('/admin/banner/index')->with('success','状态更改成功');
  		} else {
  			return back()->with('error','状态更改失败');
  		}
	}

    // 后台 轮播图 修改 显示
    public function edit($id)
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

        // 查询数据
        $data = DB::table('banners')->where('id',$id)->first();
        if ($data) {
            return view('admin.banner.edit',['data'=>$data,'admin_userinfo'=>$admin_userinfo]);
        } else {
            return back()->with('error','查询信息失败');
        }
    }

    // 后台 轮播图 修改 操作
    public function update(Request $request)
    {
        if (Redis::exists('banner_redis_data')) {
            // 删除轮播图数据缓存
            Redis::del('banner_redis_data');
        }

        // 过滤垃圾数据
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'status' => 'required|regex:/^[01]{1}$/',
        ],[
            'title.required' => '标题不能为空',
            'desc.required' => '描述不能为空',
            'status.required' => '状态不能为空',
            'status.regex' => '状态不合法'
        ]);

        // 验证文件并上传
        if ($request->hasFile('url') && $request->file('url')->isValid()) {
            $data['url'] = $request->file('url')->store(date('Ymd',time()));
        } else {
            $data['url'] = $request->input('url_path','');
        }

        $data['title'] = $request->input('title','');
        $data['desc'] = $request->input('desc','');
        $data['status'] = $request->input('status',0);
        $id = $request->input('id',0);

        // 更新数据
        $res = DB::table('banners')->where('id',$id)->update($data);

        if ($res) {
            // 如果上传了新图片，就删除旧图片
            if ($data['url']!=$request->input('url_path','')) {
                Storage::delete($request->input('url_path',''));
            }
            return redirect('/admin/banner/index')->with('success','修改轮播图成功');
        } else {
            // 如果上传了新图片，就删除新图片
            if ($data['url']!=$request->input('url_path','')) {
                Storage::delete($data['url']);
            }
            return back()->with('error','修改轮播图失败');
        }
    }

    // 后台 轮播图 删除 操作
    public function destory(Request $request)
    {
        if (Redis::exists('banner_redis_data')) {
            // 删除轮播图数据缓存
            Redis::del('banner_redis_data');
        }
        
        $id = $request->input('id',0);
        $data = DB::table('banners')->select('url')->where('id',$id)->first();
        $res = DB::table('banners')->where('id',$id)->delete();
        if ($res) {
            // 删除图片
            Storage::delete($data->url);
            echo 'OK';
        }
    }
}
