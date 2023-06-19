<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StandartPages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommonControllers extends Controller
{
    public function ckEditorUpload(Request $request)
    {
        try {
            $task = new StandartPages();
            $task->id = 0;
            $task->exists = true;
            $image = $task->addMedia($request->file("upload"))->toMediaCollection('images', 'uploads');

            return response([
                "url" => $image->getUrl('thumb')
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    public function notfound()
    {
        try {
            return view('layouts.404');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    public function login()
    {
        return view("auth.login");
    }

    public function auth(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255|min:3',
                'password' => 'required|string|string|max:255|min:8',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }
            $user = users($request->email,'email'); 
            $hash = app('hash');
            if (!$user) {
                return redirect()->back()->with('error', 'İstifadəçi tapılmadı');
            }
            if (!$hash->check($request->password, $user->password)) {
                return redirect()->back()->with('error', 'Şifrə yalnışdır');
            }

            Auth::login($user);
            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
