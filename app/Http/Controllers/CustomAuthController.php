<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Validator;
// use Hash;

class CustomAuthController extends Controller
{
    public function login() {
        return view("auth.login");
    }

    public function registration() {
        return view("auth.registration");
    }

    public function registerUser(Request $request) {
        // $isValid = 0; 
        $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:4|max:20'
       ]);
    //    if(!($isValid)) {
    //     return ["Result"=>"Invalid Email or Password"];  
    //    }
       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = $request->password;
       $res = $user->save();
       if($res) {
            // return back()->with('success','You have registered successfully');
            return ["Result"=>"Registered successfully"];
       }
       else {
            // return back()->with('fail',"Failed to register");
            return ["Result"=>"Failed to register"];
            // return "Failed to register";
       } 
    }

    public function loginUser(Request $request){
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email',
        //     'password'=>'required|min:4|max:20'
        //    ]);
        $rules = array(
            "email"=>"required|email",
            "password"=>"required|min:4|max:20"
        );

        $isValid = Validator::make($request->all(),$rules);
        if($isValid->fails()) {
            return response()->json($isValid->errors(),401);
        }
        $user = User::where('email','=', $request->email)->first();
        if($user) {
            if($request->password == $user->password) {
                // $request->session()->put('loginId', $user->id);
                // return redirect('dashboard');
                return ['Result'=>'Logged in successfully'];
            }
            else {
                // return back()->with('fail',"Wrong password");
                return ['Result'=>'Wrong password'];
            }
        } else {
            // return back()->with('fail',"This email is not registered");
            return ['Result'=>'This email is not registered'];
        } 
    }

    public function getData() {
        return User::all();

    }

    public function getDataByID($id) {
        return User::find($id);
    }

    public function dashboard() {
        return "Welcome to dashboard";
    }


    public function postData(Request $request) {
        if($request->value>0) {
            return ["result"=>"Data has been saved"];
        }
        return ["result"=>"Data has not been saved"];
    }

    public function editData(Request $request) {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $res = $user->save();
        if($res) {
            return ["result"=>"data updated"];
        }
        else {
            return ["result"=>"data not updated"];
        }
    }

    public function searchByName($name) {
        $result =  User::where("name","like",$name."%")->get();
        if(count($result)) {
            return $result;
        }
        else {
            return ["Result"=>"No records found"];
        }
    }

    public function removeByID($id) {
        $user = User::find($id);
        $result = $user->delete();
        if($result) {
            return [
                "name"=>"$user->name",
                "email"=>"$user->email",
                "Result"=>"Data is deleted"
            ];
        }
        else {
            return ["Result"=>"Delete operation failed"];
        }
    }
}

