<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        try {
            return view('auth.login');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function register()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function forgetpassword()
    {
        try {
            return view('auth.forgetpassword');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function change_password()
    {
        try {
            return view('auth.type_pin');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return redirect(route("auth.login"));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function profile()
    {
        try {
            $data = users(Auth::id(), 'id');
            return view('auth.profile', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function settings()
    {
        try {
            $data = users(Auth::id(), 'id');
            return view('auth.settings', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function addservice()
    {
        try {
            $token = Helper::createRandomCode("string", 255);
            return view('auth.addservice', compact("token"));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function wishlist()
    {
        try {
            return view('auth.wishlist');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function messages()
    {
        try {
            return view('messages.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function authenticated()
    {
        try {
            $user = users(Auth::id(), 'id');
            return response()->json([$user]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function orders(Request $request)
    {
        try {
            $pagination =$request->page ?? 1;
            if (Auth::check() && !empty(Auth::user())) {
                if(Auth::user()->type==1){
                    $data = orders(Auth::id(), 'to_id', $pagination);
                }else{
                    $data = orders(Auth::id(), 'from_id', $pagination);
                }
                return view('orders.index', compact('data'));
            }else{
                return redirect((route('fallback.index')));
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function order(Request $request, $uid)
    {
        try {
            $data = orders($uid, 'uid');
            return view('orders.show', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public function payments(Request $request)
    {
        try {
            $pagination =$request->page ?? 1;

            if (Auth::check() && !empty(Auth::user())) {
                if(Auth::user()->type==1){
                    $data = payments(Auth::id(), 'to_id',$pagination);
                }else{
                    $data = payments(Auth::id(), 'from_id',$pagination);
                }
                return view('payments.index', compact('data'));
            }else{
                return redirect((route('fallback.index')));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
