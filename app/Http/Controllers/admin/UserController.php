<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use DB;
use Storage;
class UserController extends Controller
{
    // 后台 用户 添加 显示 
    public function create()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();
    	return view('admin.user.create',['admin_userinfo'=>$admin_userinfo]);
    }

    // 后台 用户 添加 操作
    public function store(Request $request)
    {
    	// 过滤垃圾数据
		$this->validate($request, [
		    'uname' => 'required|regex:/^[\w]{8,12}$/',
		    'upass' => 'required|regex:/^[\w]{8,12}$/',
		    'repass' => 'same:upass',
		    'profile' => 'required',
		],[
			'uname.required' => '用户名不能为空',
			'uname.regex' => '用户名必须为8-12位数字字母下划线',
			'upass.required' => '密码不能为空',
			'upass.regex' => '密码必须为8-12位数字字母下划线',
			'repass.same' => '两次密码不一致',
			'profile.required' => '没有头像上传',
		]);

		// 验证并完成头像上传
        if ($request->hasFile('profile') && $request->file('profile')->isValid()) {
		  $profile = $request->file('profile')->store(date('Ymd',time()));
        }
		// 接收用户数据
		$data['uname'] = $request->input('uname','');
		$data['upass'] = Hash::make($request->input('upass',''));
		$data['profile'] = $profile;
		$data['token'] = str_random(50);
		$data['status'] = 0;
		$data['ctime'] = date('Y-m-d H:i:s',time());

		// 插入用户数据
		$res = DB::table('Users')->insert($data);
		if ($res) {
			return redirect('/admin/user/index')->with('success','添加用户成功');
		} else {
			// 插入数据失败，删除图片
			Storage::delete($profile);
			return back()->with('error','添加用户失败');
		}
    }

    // 后台 用户 列表 显示
    public function index(Request $request)
    {
    	// 搜索用户名
    	$serach = $request->input('serach');

    	$data = DB::table('users')->where('uname','like',"%{$serach}%")->orderBy('id','asc')->paginate(5);

        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

    	return view('admin.user.index',['data'=>$data,'serach'=>$serach,'admin_userinfo'=>$admin_userinfo]);
    }

    // 后台 用户 删除 操作
    public function destory(Request $request)
    {
    	// 获取要删除的id和token
        $id = $request->input('id',0);
    	$token = $request->input('token',0);
    	// 查询用户对应的token和图片路径
    	$data = DB::table('users')->where('id',$id)->select('profile','token')->first();
        // 验证token
        if ($token != $data->token) {
            echo 'error';
            exit;
        }
    	// 删除用户记录
    	$res = DB::table('users')->where('id',$id)->delete();
    	if ($res) {
            // 删除用户头像
        	Storage::delete($data->profile);
    		echo 'OK';
    	} else {
    		echo 'error';
    	}
    }

    // 后台 用户 修改 显示
    public function edit($id,$token)
    {
        // 查询id对应的token
        $data = DB::table('users')->where('id',$id)->first();
        
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();

        if ($data->token!=$token) {
            return back()->with('error','token验证失败');
        } else {
            return view('admin.user.edit',['data'=>$data,'admin_userinfo'=>$admin_userinfo]);
        }
    }

    // 后台 用户 修改 操作
    public function update(Request $request,$id,$token)
    {
        // 过滤垃圾数据
        $this->validate($request, [
            'uname' => 'required|regex:/^[\w]{8,12}$/',
            'email' => 'required|regex:/^[\w\d]+@[\w\d]{1,8}.[\w]{1,5}$/',
        ],[
            'uname.required' => '用户名不能为空',
            'uname.regex' => '用户名不合法',
            'email.required' => '邮箱不能为空',
            'email.regex' => '邮箱不合法',
        ]);

        // 验证token
        $users_token = DB::table('users')->where('id',$id)->select('token')->first();
        if ($users_token->token!=$token) {
            return back()->with('error','token验证失败');
        }

        // 验证是否更改头像
        if ($request->hasFile('profile') && $request->file('profile')->isValid()) {   
            // 上传新头像
            $data['profile'] = $request->file('profile')->store(date('Ymd',time()));
        } else {
            // 上传旧头像路径
            $data['profile'] = $request->input('profile_path','');
        }

        // 接收数据
        $data['uname'] = $request->input('uname','');
        $data['email'] = $request->input('email','');
        $data['token'] = str_random(50);

        // 更新数据
        $res = DB::table('users')->where('id',$id)->update($data);
        if ($res) {
            // 如果上传了新图片，就删除旧图片
            if ($data['profile']!=$request->input('profile_path','')) {
                Storage::delete($request->input('profile_path',''));
            }
            return redirect('/admin/user/index')->with('success','修改用户成功');
        } else {
            // 如果上传了新图片，就删除新图片
            if ($data['profile']!=$request->input('profile_path','')) {
                Storage::delete($data['profile']);
            }
            return back()->with('error','修改用户失败');
        }
    }
}
