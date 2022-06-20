<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

class CustomeAuthenticationController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function registerUser(Request $request)
    {

        //validate the coming data..

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'

        ]);

        //store data in db...

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $result = $user->save();


        if ($result) {
            return back()->with('success', 'You have successfully Registered');
        } else {
            return back()->with('fail', 'something wrong');
        }


    }

    public function loginUser(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'

        ]);

        // logged in

        $user=User::Where('email','=',$request->email)->first();

        if ($user==true){

            if(Hash::check($request->password,$user->password)){

                $request->Session()->put('loginId',$user->id);
                return redirect('home');

            }else{
                return back()->with('fail', 'Password not matched');
            }

        }else{
            return back()->with('fail', 'something wrong!! mail is not Registered');

        }
    }


    public function home()
    {
        $data =array();

        if (Session::has('loginId')){

           $data=User::Where('id','=',Session::get('loginId'))->first();

        }
        return view('home',compact('data'));
    }

    public function logout()
    {
        if (Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
