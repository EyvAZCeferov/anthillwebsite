<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Payments;
use App\Helpers\GUAVAPAY;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\SendEmailEvent;
use App\Models\UserAdditionals;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FunctionsController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = users($request->email, 'email');
            if (!empty($user)) {
                if ($user->additionalinfo->original_pass == $request->password) {
                    Auth::login($user);
                    return response()->json(['status' => 'success', 'message' => trans('additional.messages.logined', [], $request->language ?? 'en'), 'url' => route('auth.profile')]);
                } else {
                    return response()->json(['status' => 'error', 'message' => trans('additional.messages.passwordswrong', [], $request->language ?? 'en')]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.usernotfound', [], $request->language ?? 'en')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function register(Request $request)
    {
        try {
            $user = users($request->email, 'email') ?? users($request->phone, 'phone');
            if (!empty($user)) {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.userfound', [], $request->language ?? 'en')]);
            } else {
                DB::transaction(function () use ($request) {

                    $user = new User();
                    $user->name_surname = $request->name_surname;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->password = bcrypt($request->password);
                    $user->is_admin = false;
                    $user->type = 1;
                    $user->status = true;
                    $user->save();

                    $useradditional = new UserAdditionals();
                    $useradditional->user_id = $user->id;
                    $useradditional->original_pass = $request->password;
                    $useradditional->save();

                    // SendEmail
                    $datas = [
                        'message' => trans('additional.emailtemplates.service.registeredmessage', ['name' => $request->name_surname, 'url' => route('auth.login'),'password'=>$request->password], $request->language ?? 'en'),
                        'email' => env('MAIL_USERNAME'),
                        'name_surname' => env('APP_NAME'),
                        'type' => 'newregister',
                        'title' => trans('additional.emailtemplates.service.registered')
                    ];
                    event(new SendEmailEvent($datas));
                    Auth::login($user);
                });
                return response()->json(['status' => 'success', 'message' => trans('additional.messages.registered', [], $request->language ?? 'en'), 'url' => route('auth.profile')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function forgetpassword(Request $request)
    {
        try {
            $user = users($request->email, 'email');
            if (!empty($user)) {
                // Email Gonder
                $code = Helper::createRandomCode();
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => Str::random(60),
                    "code" => $code,
                    'created_at' => Carbon::now()
                ]);
                //Get the token just created above
                $tokenData = DB::table('password_resets')
                    ->where('email', $request->email)->first();

                $datas = [
                    'message' => trans("additional.emailtemplates.service.updatepasswordmessage", ['name' => $user->name_surname, 'code' => $code, 'url' => route('password.change', ['email' => $request->email, 'token' => $tokenData->token])]),
                    'email' => env('MAIL_USERNAME'),
                    'name_surname' => env('APP_NAME'),
                    'type' => 'forgetpassword',
                    'title' => trans("additional.emailtemplates.service.updtepassword"),
                    "id" => Helper::createRandomCode("int", 10),
                ];
                event(new SendEmailEvent($datas));

                return response()->json(['status' => 'success', 'message' => trans('additional.messages.emailsendedupdatepassword', [], $request->language ?? 'en')]);
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.usernotfound', [], $request->language ?? 'en')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function submitpin(Request $request)
    {
        try {
            $user = users($request->email, 'email');
            if (!empty($user)) {
                $tokenData = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('token', $request->token)->first();

                if ($tokenData == $request->number1 . $request->number2 . $request->number3 . $request->number4) {
                    return response()->json(['status' => 'success', 'message' => trans('additional.messages.passwordstrue', [], $request->language ?? 'en'), 'url' => route('password.change_view')]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => trans('additional.messages.passwordswrong', [], $request->language ?? 'en')]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.usernotfound', [], $request->language ?? 'en')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function updatedata(Request $request)
    {
        try {
            if (Auth::check()) {
                $user = users(auth()->user()->id, 'id');
                if ($request->type_request == "profile") {
                    $user->update([
                        "name_surname" => $request->name_surname,
                        "phone" => $request->phone,
                        "email" => $request->email,
                    ]);

                    if (isset($request->new_password) && !empty($request->new_password)) {
                        if (isset($request->old_password) && !empty($request->old_password)) {
                            if ($request->old_password == $user->additionalinfo->original_pass) {
                                $user->additionalinfo->update([
                                    "original_pass" => $request->new_password
                                ]);
                                $user->update([
                                    "password" => bcrypt($request->new_password)
                                ]);
                            } else {
                                return response()->json(['status' => 'error', 'message' => trans('additional.messages.oldpassword_doesnot_match')]);
                            }
                        } else {
                            return response()->json(['status' => 'error', 'message' => trans('additional.messages.enterold_password')]);
                        }
                    }

                    if (isset($request->company_logo) && !empty($request->company_logo) && $request->hasFile('company_logo')) {
                        $imageurl = Helper::uploadimage($request->file('company_logo'), 'users');
                        $user->additionalinfo->update([
                            'company_image' => $imageurl,
                        ]);
                    }

                    return response()->json(['status' => 'success', 'message' => trans('additional.messages.datasupdated')]);
                } else {

                    if (isset($request->phone_2) && !empty($request->phone_2)) {
                        $user->update([
                            "phone_2" => $request->phone_2,
                        ]);
                    }
                    if (isset($request->company_name) && !empty($request->company_name)) {
                        $name = [
                            'az_name' => trim($request->company_name),
                            "ru_name" => trim(GoogleTranslate::trans(trim($request->name), 'ru')),
                            "en_name" => trim(GoogleTranslate::trans(trim($request->name), 'en')),
                            "tr_name" => trim(GoogleTranslate::trans(trim($request->name), 'tr')),
                        ];
                        $user->additionalinfo->update([
                            "company_name" => $name
                        ]);
                    }

                    if (isset($request->company_description) && !empty($request->company_description)) {
                        $description = [
                            'az_description' => trim($request->company_description),
                            "ru_description" => trim(GoogleTranslate::trans(trim($request->description), 'ru')),
                            "en_description" => trim(GoogleTranslate::trans(trim($request->description), 'en')),
                            "tr_description" => trim(GoogleTranslate::trans(trim($request->description), 'tr')),
                        ];
                        $user->additionalinfo->update([
                            "company_description" => $description
                        ]);
                    }

                    if (isset($request->company_logo) && !empty($request->company_logo) && $request->hasFile('company_logo')) {
                        $imageurl = Helper::uploadimage($request->file('company_logo'), 'users');
                        $user->additionalinfo->update([
                            'company_image' => $imageurl,
                        ]);
                    }
                }
                return response()->json(['status' => 'success', 'message' => trans("additional.messages.datasupdated")]);
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.pleaselogin')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function togglelog_multiple($status)
    {
        try {
            $activemultiple = setting()->social_media;
            $activemultiple['log_enabled'] = $status;

            setting()->update([
                "social_media" => $activemultiple
            ]);

            return "Mod is " . $status;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function toggleservice($status)
    {
        try {
            $activemultiple = setting()->social_media;
            $activemultiple['active_service'] = $status;

            setting()->update([
                "social_media" => $activemultiple
            ]);

            return "Website is " . $status;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function callback(Request $request){
        try{
            $payment=Payments::where('payment_status',0)->orderBy('id','DESC')->first();
            $guavapay=GUAVAPAY::checkstatus($payment->transaction_id,'en');
            if(!empty($guavapay)){
                return redirect(route("orders.show",$guavapay->uid));
            }else{
                return redirect(route('messages.index'));
            }
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}