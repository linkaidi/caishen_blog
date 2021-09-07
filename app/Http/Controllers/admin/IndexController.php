<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Storage;
class IndexController extends Controller
{
    // 后台首页
    public function index()
    {
        // 获取当前用户信息
        $uid = session('admin_userinfo')->id;
        $admin_userinfo = DB::table('users')->where('id',$uid)->first();
    	return view('admin.index',['admin_userinfo'=>$admin_userinfo]);
    }

    // 后台 验证 token 操作
    public function checkToken(Request $request)
    {
    	$id = $request->input('id',0);
    	$token = $request->input('token',0);
    	// 获取token
    	$data = DB::table('users')->where('id',$id)->first();
    	// 验证token
    	if ($data->token==$token) {
    		echo 'OK';
    	} else {
    		echo 'error';
    	}
    }

    // 后台 修改 密码 操作
    public function updatePwd(Request $request)
    {
    	// 过滤垃圾数据
		$this->validate($request, [
	        'old_password' => 'required|regex:/^[\w]{8,12}$/',
	        'password' => 'required|regex:/^[\w]{8,12}$/',
	        'repassword' => 'same:password',
    	],[
    		'old_password.required' => '旧密码不能为空',
    		'old_password.regex' => '旧密码不合法',
    		'password.required' => '新密码不能为空',
    		'password.regex' => '新密码不合法',
    		'repassword.same' => '两次密码不一致',
    	]);

		$id = $request->input('id',0);
		$old_password = $request->input('old_password',0);

		// 查询旧密码
		$old_data = DB::table('users')->where('id',$id)->first();
		// 验证旧密码
		if (!(Hash::check($old_password, $old_data->upass))) {
			return back()->with('error','旧密码错误');
		}
		
		$data['upass'] = Hash::make($request->input('password',''));
		$data['token'] = str_random(50);

		$res = DB::table('users')->where('id',$id)->update($data);
    	if ($res) {
    		return back()->with('success','修改密码成功');
    	} else {
    		return back()->with('error','修改密码失败');
    	}
    }

    // 后台 修改 头像 操作
    public function updatePrf($id,Request $request)
    {
        // 验证是否更改头像
        if ($request->hasFile('profile') && $request->file('profile')->isValid()) {   
            // 上传新头像
            $data['profile'] = $request->file('profile')->store(date('Ymd',time()));
        } else {
            // 上传旧头像路径
            $data['profile'] = $request->input('old_profile','');
        }

		$data['token'] = str_random(50);

        // 更新数据
        $res = DB::table('users')->where('id',$id)->update($data);
        if ($res) {
            // 如果上传了新图片，就删除旧图片
            if ($data['profile']!=$request->input('old_profile','')) {
                Storage::delete($request->input('old_profile',''));
            }
            return back()->with('success','修改头像成功');
        } else {
            // 如果上传了新图片，就删除新图片
            if ($data['profile']!=$request->input('old_profile','')) {
                Storage::delete($data['profile']);
            }
            return back()->with('error','修改头像失败');
        }
    }
}
