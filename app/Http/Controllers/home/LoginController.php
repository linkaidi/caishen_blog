<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
class LoginController extends Controller
{
    // 前台 登录 显示
    public function index()
    {
    	return view('home.login.index');
    }

    // 前台 登录 操作
    public function dologin(Request $request)
    {
    	$uname = $request->input('uname','');
    	$upass = $request->input('upass','');

    	// 查询对应的账号信息
    	$data = DB::table('users')->where('uname',$uname)->first();
    	
		// 验证信息是否查询到
    	if (empty($data)) {
			echo json_encode(['msg'=>'error','info'=>'账号或密码错误']);
			exit;
		}
		
		// 验证密码是否一致
    	if (!(Hash::check($upass, $data->upass))) {
			echo json_encode(['msg'=>'error','info'=>'账号或密码错误']);
			exit;
		}

		// 验证成功，压入session
		session(['home_login'=>true]);
		session(['home_userinfo'=>$data]);

		echo json_encode(['msg'=>'ok','info'=>'登陆成功']);
    }

    // 前台 退出 操作
    public function logout()
    {
    	session()->forget(['home_login','home_userinfo']);
    	return redirect('/');
    }
}
