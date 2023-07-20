<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserAdditionals;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Stichoza\GoogleTranslate\GoogleTranslate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $type = $request->type;
            if (isset($type) && $type == "normal") {
                $data = User::orderBy("id", "DESC")->where('is_admin', false)->where('type', 1)->get();
            } elseif (isset($type) && $type == "company") {
                $data = User::orderBy("id", "DESC")->where('is_admin', false)->where('type', 3)->get();
            } else {
                $data = User::orderBy('id', 'DESC')->where('is_admin', false)->get();
            }
            return view('orders.users.index', ['data' => $data, 'type' => $request->type]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $exploded = explode('?type=', url()->previous());
            $type = $exploded[1] ?? 'normal';
            return view('orders.users.create_edit', ['type' => $type]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $password = strtolower(Helper::createRandomCode("string", 8));

            $user = new User();
            $user->name_surname = $request->name_surname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->phone_2 = $request->phone_2;
            $user->password = bcrypt($password);
            $user->is_admin = false;
            $user->type = $request->type;
            $user->save();

            if (isset($request->company_en_name) && !empty($request->company_en_name)) {

                $company_name = [
                    'az_name' => $request->company_en_name ?? $request->name_surname,
                    'ru_name' => trim(GoogleTranslate::trans($request->company_en_name ?? $request->name_surname, 'ru')),
                    'en_name' => trim(GoogleTranslate::trans($request->company_en_name ?? $request->name_surname, 'en')),
                    'tr_name' => trim(GoogleTranslate::trans($request->company_en_name ?? $request->name_surname, 'tr')),
                ];

                $company_slugs = [
                    'az_slug' => Str::slug($company_name['az_name']),
                    'ru_slug' => Str::slug($company_name['ru_name']),
                    'en_slug' => Str::slug($company_name['en_name']),
                    'tr_slug' => Str::slug($company_name['tr_name']),
                ];
            } else {
                $company_name = [];

                $company_slugs = [];
            }

            if (isset($request->company_en_description) && !empty($request->company_en_description)) {
                $company_description = [
                    'az_description' => $request->company_en_description ?? '',
                    'ru_description' => isset($request->company_ru_description) && !empty($request->company_ru_description) ? $request->company_ru_description : trim(GoogleTranslate::trans($request->company_en_description, 'ru')),
                    'en_description' => isset($request->company_en_description) && !empty($request->company_en_description) ? $request->company_en_description : trim(GoogleTranslate::trans($request->company_en_description, 'en')),
                    'tr_description' => isset($request->company_tr_description) && !empty($request->company_tr_description) ? $request->company_tr_description : trim(GoogleTranslate::trans($request->company_en_description, 'tr')),
                ];
            } else {
                $company_description = [];
            }

            $useradditional = new UserAdditionals();
            $useradditional->user_id = $user->id;
            $useradditional->company_name = $company_name;
            $useradditional->company_slugs = $company_slugs;
            $useradditional->company_description = $company_description;
            $useradditional->original_pass = $password;
            $useradditional->save();

            if ($request->hasFile('company_image')) {
                $image = Helper::image_upload($request->file('company_image'), 'users');
                $useradditional->update([
                    'company_image' => $image
                ]);
            }

            $type = null;
            if ($request->type == 1) {
                $type = "normal";
            } elseif ($request->type == 3) {
                $type = "company";
            }

            return redirect(route('users.index', ['type' => $type]))->with('success', 'Yaradıldı');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = users($id, 'id');
            return view('orders.users.show', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = users($id, 'id');
            $type = $data->type;
            return view('orders.users.create_edit', ['data' => $data, 'type' => $type]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = users($id, 'id');
            $user->name_surname = $request->name_surname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->phone_2 = $request->phone_2;
            $user->phone_2 = $request->phone_2;
            $user->type = $request->type;
            $user->update();

            if (isset($request->company_en_name) && !empty($request->company_en_name)) {

                $company_name = [
                    'az_name' => $request->company_en_name ?? $request->name_surname,
                    'ru_name' => $request->company_en_name ?? $request->name_surname,
                    'en_name' => $request->company_en_name ?? $request->name_surname,
                    'tr_name' => $request->company_en_name ?? $request->name_surname,
                ];

                $company_slugs = [
                    'az_slug' => Str::slug($company_name['az_name']),
                    'ru_slug' => Str::slug($company_name['ru_name']),
                    'en_slug' => Str::slug($company_name['en_name']),
                    'tr_slug' => Str::slug($company_name['tr_name']),
                ];
            } else {
                $company_name = [];

                $company_slugs = [];
            }

            if (isset($request->company_en_description) && !empty($request->company_en_description)) {
                $company_description = [
                    'az_description' => $request->company_en_description ?? '',
                    'ru_description' => isset($request->company_ru_description) && !empty($request->company_ru_description) ? $request->company_ru_description : trim(GoogleTranslate::trans($request->company_en_description, 'ru')),
                    'en_description' => isset($request->company_en_description) && !empty($request->company_en_description) ? $request->company_en_description : trim(GoogleTranslate::trans($request->company_en_description, 'en')),
                    'tr_description' => isset($request->company_tr_description) && !empty($request->company_tr_description) ? $request->company_tr_description : trim(GoogleTranslate::trans($request->company_en_description, 'tr')),
                ];
            } else {
                $company_description = [];
            }


            $useradditional = UserAdditionals::where('user_id', $user->id)->latest()->first();
            $useradditional->company_name = $company_name;
            $useradditional->company_slugs = $company_slugs;
            $useradditional->company_description = $company_description;
            $useradditional->update();

            if (isset($request->password) && !empty($request->password)) {
                $user->update([
                    "password" => bcrypt($request->password)
                ]);

                $useradditional->update([
                    'original_pass' => $request->password
                ]);
            }

            if ($request->hasFile('company_image')) {
                $image = Helper::image_upload($request->file('company_image'), 'users');
                $useradditional->update([
                    'company_image' => $image
                ]);
            }


            return back()->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = users($id, 'id');
            if (!empty($user->deleted_at)) {
                $user->forceDelete();
            } else {
                $user->delete();
            }

            return redirect()->back()->with('success', trans('additional.messages.deleted'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function deleted(Request $request)
    {
        try {
            $type = $request->type;
            if (isset($type) && $type == "normal") {
                $data = User::orderBy("id", "DESC")->where('is_admin', false)->where('type', 1)->onlyTrashed()->get();
            } elseif (isset($type) && $type == "company") {
                $data = User::orderBy("id", "DESC")->where('is_admin', false)->where('type', 3)->onlyTrashed()->get();
            } else {
                $data = User::orderBy('id', 'DESC')->where('is_admin', false)->onlyTrashed()->get();
            }
            return view('orders.users.index', ['data' => $data, 'type' => $request->type]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
}
