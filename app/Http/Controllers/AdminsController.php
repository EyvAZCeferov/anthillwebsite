<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = admin_users();
            return view('admins.admins', ['data' => $data]);
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
            $permissions = Permission::orderBy("id", 'DESC')->get();
            return view('admins.create', compact('permissions'));
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|string|email|max:255|min:3',
                'password' => 'required|confirmed|string|max:255|min:8',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $data = new User();
            $data->name_surname = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->is_admin = true;
            $data->password = bcrypt($request->password);
            $data->save();

            $data->assignRole($request->role_id);
            $perms = array_keys($request->permissions);

            if (!empty($request->permissions)) {
                $data->givePermissionTo($perms);
            }
            return redirect(route("admins.index"))->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        try {
            $permissions = Permission::orderBy("id", 'DESC')->get();
            return view('admins.edit', ['data' => User::where("is_admin", 1)->where("id", $user)->first(), 'permissions' => $permissions]);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|string|email|max:255|min:3',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }
            $data = [
                "name_surname" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
            ];

            if (request()->filled('password')) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|confirmed|string|max:255|min:8',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors());
                }
                $data['password'] = bcrypt($request->password);
            }

            $user = admin_users($user);
            $user->update($data);

            foreach (Role::get() as $role) {
                $user->removeRole($role->name);
            }

            $user->assignRole($request->role_id);

            $perms = array_keys($request->permissions);

            foreach (Permission::orderBy("id", 'DESC')->get() as $pe) {
                $user->removePermission($pe);
            }

            if (!empty($request->permissions)) {
                $user->givePermissionTo($perms);
            }

            return redirect(route("admins.index"))->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        try {
            
            $admin=admin_users($user);
            $admin->delete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recycle()
    {
        try {
            $data = User::where('is_admin', 1)->onlyTrashed()->get();
            return view('admins.admins_recycle', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function harddelete($user)
    {
        try {
            User::where("id", $user)->onlyTrashed()->forceDelete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore($user)
    {
        try {
            User::onlyTrashed()->find($user)->restore();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restoreall()
    {
        try {
            User::onlyTrashed()->restore();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function newadmin()
    {
        try {

            $data = new User();
            $data->name_surname = "Eyvaz Ceferov";
            $data->email = "eyvaz.ceferov@gmail.com";
            $data->phone = "0708288617";
            $data->is_admin = true;
            $data->password = bcrypt("E_r123456789");
            $data->save();

            return redirect(route('dashboard'))->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function newuser()
    {
        try {

            $data = new User();
            $data->name_surname = "Eyvaz Ceferov";
            $data->email = "eyvazc@bk.ru";
            $data->phone = "0509881763";
            $data->is_admin = false;
            $data->verified = true;
            $data->password = bcrypt("E_r123456789");
            $data->save();

            return redirect(route('dashboard'))->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function createroleandperm(Request $request)
    {
        try {
            return Role::create(['name' => $request->name]);
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
}
