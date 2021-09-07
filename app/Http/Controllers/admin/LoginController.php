<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
class LoginController extends Controller
{
    // 后台 登录 显示
    public function index()
    {
    	return view('admin.login.index');
    }

    // 后台 登录 操作
    public function doLogin(Request $request)
    {
    	$uname = $request->input('uname','');
    	$upass = $request->input('upass','');
    	// 查询对应的账号信息
    	$data = DB::table('users')->where('ulevel',1)->where('uname',$uname)->first();
    	
		// 验证信息是否查询到
    	if (empty($data)) {
			return back()->with('error','账号或密码错误');
		}
		
		// 验证密码是否一致
    	if (!(Hash::check($upass, $data->upass))) {
			return back()->with('error','账号或密码错误');
		}

		// 验证成功，压入session
		session(['admin_login'=>true]);
		session(['admin_userinfo'=>$data]);

		// 跳转后台首页
		return redirect('/admin/index');
    }

    // 后台 退出 操作
    public function logout()
    {
    	session()->forget(['admin_login','admin_userinfo']);
    	return back();
    }

}
