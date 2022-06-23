<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class PagesController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function about()
    {
        $data=array(
            'test'=>'name','name'=>['kulwa','malando','24']);
        $name="kulwa";
        return view('about')->with($data);
    }
    public function login()
    {
        return view('login');
    }
    public function signin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);
        //$name=$request->input('email');
        //$password=$request->input('password');
        
        return 123;
        //return view('login')->with('name',$name)->with('password',$password);
        //." and ".$password." and ".$set;
    }
}
