<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Nav;
use App\Novel;
use App\Yuming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dologin(Request $request)
    {
        $this->validate($request , [
                'name'=>'required',
                'password'=>'required',
            ],
            [
                'name.required'=>'用户名必须写',
                'password.required'=>'密码不必须写',
            ]
        );
        $name =  $request->input('name');
        $password =  $request->input('password');
        if (Auth::attempt(['name'=>$name,'password'=>$password])){
            return  response()->json(['status'=>200,'msg'=>'登陆成功']);
        }else{
            return  response()->json(['status'=>500,'msg'=>'登陆失败']);
        }
    }



}
