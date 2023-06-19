<?php

namespace App\Http\Controllers;

use Cache;
use App\Helpers\Helper;
use App\Models\ViewCounters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoutesController extends Controller
{
    public function welcome()
    {
        try {
            return view('welcome');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function standartpage($slug)
    {
        try {
            $data = standartpages($slug, 'slug');
            return view('pages.standartpage', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function services(Request $request)
    {
        try {
            if (isset($request->category) && !empty($request->category)) {
                $category = categories($request->category);
                $products = product_category($category->id, 'category');
            } else {
                $category = null;
                $products = products();
            }
            return view('services.index', compact('products', 'category'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function service($slug)
    {
        try {
            $data = product($slug, true);

            DB::transaction(function () use ($data) {
                $viewcount = new ViewCounters();
                $viewcount->element_id = $data->id;
                if (Auth::check() && !empty(Auth::user()->id)) {
                    $viewcount->user_id = Auth::user()->id;
                }
                $viewcount->type = "product";
                $viewcount->save();
            });
            return view('services.show', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }

    public function editservice($slug)
    {
        try {
            $data = product($slug, true);
            $token = $data->token;
            return view('auth.addservice', compact('data', 'token'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function companies()
    {
        try {
            $data = user_companies();
            return view('companies.index', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function company($slug)
    {
        try {
            $data = user_company($slug);
            DB::transaction(function () use ($data) {
                $viewcount = new ViewCounters();
                $viewcount->element_id = $data->user->id;
                if (Auth::check() && !empty(Auth::user()->id)) {
                    $viewcount->user_id = Auth::user()->id;
                }
                $viewcount->type = "user";
                $viewcount->save();
            });
            return view('companies.show', compact('data'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }finally{
            Helper::dbdeactive();
        }
    }
    public function myservices()
    {
        try {
            $data = Auth::user()->products;
            return view('auth.myservices', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e)->getMessage();
        }
    }
    public function notfound()
    {
        try {
            return view("pages.notfound");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
