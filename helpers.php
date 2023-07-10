<?php

use App\Models\User;
use App\Models\Orders;
use App\Models\Sliders;
use App\Models\Comments;
use App\Models\Messages;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Settings;
use App\Models\ContactUs;
use App\Models\Languages;
use App\Models\SiteUsers;
use App\Models\Attributes;
use App\Models\Categories;
use App\Models\CouponCodes;
use App\Models\ProductType;
use App\Models\ViewCounters;
use App\Models\MessageGroups;
use App\Models\StandartPages;
use App\Models\MessageElements;
use App\Models\UserAdditionals;
use App\Models\BackgroundImages;
use App\Models\CategoryAttributes;
use App\Models\ProductsAttributes;
use App\Models\ProductEncodedImages;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    function setting()
    {
        $model = Settings::latest()->first();
        return Cache::rememberForever("settings", fn () => $model);
    }
}

if (!function_exists('categories')) {
    function categories($key = null)
    {
        if (isset($key) && !empty($key)) {
            if (is_numeric($key)) {
                $model = Categories::find($key)->first();
            } else {
                $model = Categories::where('slugs->az_slug', $key)
                    ->orWhere('slugs->ru_slug', $key)
                    ->orWhere('slugs->en_slug', $key)
                    ->orWhere('slugs->tr_slug', $key)
                    ->first();
            }
        } else {
            $model = Categories::where('status', true)->whereNull('top_id')->get();
        }
        return Cache::rememberForever("categories" . $key, fn () => $model);
    }
}

if (!function_exists('attributes')) {
    function attributes($key = null): object
    {
        if (isset($key) && !empty($key)) {
            if (is_numeric($key)) {
                $categoryAttributes = CategoryAttributes::where('category_id', $key)->with(['category', 'attribute_group'])->whereNotNull('attribute_group_id')->get();
                $model = $categoryAttributes;
            } else {
                $categoryAttributes = CategoryAttributes::where('category_id', categories($key)->id)->with(['category', 'attribute_group'])->whereNotNull('attribute_group_id')->get();
                $model = $categoryAttributes;
            }
        } else {
            $model = Attributes::orderBy('order_att', 'ASC')->get();
        }
        return Cache::rememberForever("attributes" . $key, fn () => $model);
    }
}

if (!function_exists('attribute')) {
    function attribute($key = null): object
    {
        if (is_numeric($key)) {
            $model = Attributes::find($key);
        } else {
            $model = Attributes::where('slugs->az_slug', $key)->orWhere('slugs->ru_slug', $key)->orWhere('slugs->en_slug', $key)->orWhere('slugs->tr_slug', $key)->first();
        }

        return Cache::rememberForever("attribute" . $key, fn () => $model);
    }
}

if (!function_exists('attributes_attribute')) {
    function attributes_attribute($key = null, $type = "int", $val = null)
    {
        if (isset($key) && !empty($key)) {
            if ($type == "int") {
                $model = Attributes::find($key);
            } else if ($type == "withgroupproduct") {
                $model = ProductsAttributes::where('product_id', $key)->where('attribute_group_id', $val)->with(['attribute', 'attributegroup'])->first();
            } else {
                $model = Attributes::where('group_id', $key)
                    ->where('name->az_name',  $val)
                    ->orWhere('name->ru_name',  $val)
                    ->orWhere('name->en_name',  $val)
                    ->orWhere('name->tr_name',  $val)
                    ->latest()->first();
            }
        } else {
            $model = Attributes::orderBy('order_att', 'ASC')->get();
        }
        return Cache::rememberForever("attributes_attribute" . $key . $type . $val, fn () => $model);
    }
}

if (!function_exists('attributes_filter_params')) {
    function attributes_filter_params($key = null, $val = null, $operation = null): object
    {
        if (isset($key) && !empty($key)) {

            if (empty($operation)) {
                $model = Attributes::where('group_id', $key)
                    ->where('name->az_name',  $val)
                    ->orWhere('name->ru_name',  $val)
                    ->orWhere('name->en_name',  $val)
                    ->orWhere('name->tr_name',  $val)
                    ->get()->pluck('id');
            } else if (!empty($operation) && $operation == '>') {
                $model = Attributes::where('group_id', $key)
                    ->where('name->az_name', '>',  $val)
                    ->orWhere('name->ru_name', '>', $val)
                    ->orWhere('name->en_name', '>', $val)
                    ->orWhere('name->tr_name', '>', $val)
                    ->get()->pluck('id');
            } else if (!empty($operation) && $operation == '<') {
                $model = Attributes::where('group_id', $key)
                    ->where('name->az_name', '<',  $val)
                    ->orWhere('name->ru_name', '<', $val)
                    ->orWhere('name->en_name', '<', $val)
                    ->orWhere('name->tr_name', '<', $val)
                    ->get()->pluck('id');
            } else if (!empty($operation) && $operation == 'between') {
                $model = Attributes::where('group_id', $key)
                    ->whereBetween('name->az_name',   $val)
                    ->orWhereBetween('name->ru_name',  $val)
                    ->orWhereBetween('name->en_name',  $val)
                    ->orWhereBetween('name->tr_name',  $val)
                    ->get()->pluck('id');
            }
        }
        return Cache::rememberForever("attributes_filter_params" . $key . $val . $operation, fn () => $model);
    }
}

if (!function_exists('standartpages')) {
    function standartpages($key = null, $type = "slug")
    {

        if (isset($key) && !empty($key) && $type == "type") {

            $model = StandartPages::where('type', $key)->with('seo')->first();
        } else if (isset($key) && !empty($key) && $type == "slug") {
            $model = StandartPages::where('slugs->az_slug', $key)->orWhere('slugs->ru_slug', $key)->orWhere('slugs->en_slug', $key)->with('seo')->first();
        } else if (isset($key) && !empty($key) && $type == "id") {
            $model = StandartPages::where('id',$key)->with('seo')->first();
        } else {
            $model = StandartPages::all();
        }
        return Cache::rememberForever("standartpages" . $key . $type, fn () => $model);
    }
}

if (!function_exists('product')) {
    function product($key = null, $object = false)
    {
        if (isset($key) && !empty($key) && $object == false) {
            if (is_numeric($key)) {
                $model = Products::find($key)->with(['attributes', 'category', 'cancelreason', 'user', 'images', 'comments']);
            } else {
                $model = Products::where('slugs->az_slug', $key)
                    ->orWhere('slugs->ru_slug', $key)
                    ->orWhere('slugs->en_slug', $key)
                    ->orWhere('slugs->tr_slug', $key)
                    ->with(['attributes', 'category', 'cancelreason', 'user', 'images', 'comments'])
                    ->first();
            }
        } else if (isset($key) && !empty($key) && $object == true) {
            $model = Products::where('code', $key)->orWhere('slugs->az_slug',$key)->orWhere('slugs->ru_slug',$key)->orWhere('slugs->en_slug',$key)->with(['attributes', 'category', 'cancelreason', 'user', 'images', 'comments'])->first();
        }
        return Cache::rememberForever("product" . $key . $object, fn () => $model);
    }
}

if (!function_exists('product_category')) {
    function product_category($key = null, $type = null)
    {
        if (isset($key) && !empty($key) && !empty($type) && $type == "category") {
            if (is_numeric($key)) {
                $model = Products::where('category_id', $key)->with(['attributes', 'category', 'cancelreason', 'user', 'images', 'comments'])->get();
            } else {
                $model = Products::where('slugs->az_slug', $key)
                    ->orWhere('slugs->ru_slug', $key)
                    ->orWhere('slugs->en_slug', $key)
                    ->orWhere('slugs->tr_slug', $key)
                    ->with(['attributes', 'category', 'cancelreason', 'user', 'images', 'comments'])
                    ->first();
            }
        }
        return Cache::rememberForever("product_category" . $key . $type, fn () => $model);
    }
}

if (!function_exists('product_with_token')) {
    function product_with_token($key = null, $user = false)
    {
        if (isset($key) && !empty($key) && $user == false) {
            $model = Products::where('token', $key)->first();
        } else if (isset($key) && !empty($key) && $user == true) {
            $model = Products::where("user_id", $key)->pluck('id');
        } else {
            $model = Products::all();
        }
        return Cache::rememberForever("product_with_token" . $key . $user, fn () => $model);
    }
}

if (!function_exists('user_companies')) {
    function user_companies($key = null, $random = false): object
    {
        if (isset($key) && !empty($key)) {
            if ($random == true) {
                $model = User::where('type', $key)->inRandomOrder()->with(['additionalinfo', 'products'])->get();
            } else {
                $model = User::where('type', $key)->orderBy('id', 'DESC')->with(['additionalinfo', 'products'])->get();
            }
        } else {
            $model = User::where('type', 3)->orderBy('id', 'DESC')->with(['additionalinfo', 'products'])->get();
        }
        return Cache::rememberForever("user_companies" . $key . $random, fn () => $model);
    }
}

if (!function_exists('user_company')) {
    function user_company($key = null, $type = null): object
    {
        if (isset($key) && !empty($key) && empty($type)) {
            $model = UserAdditionals::where('company_slugs->az_slug', $key)
                ->orWhere('company_slugs->ru_slug', $key)
                ->orWhere('company_slugs->en_slug', $key)
                ->orWhere('company_slugs->tr_slug', $key)
                ->with('user')
                ->first();
        } else if (isset($key) && !empty($key) && !empty($type)) {
            $model = UserAdditionals::where('user_id', $key)->with('user')->latest()->first();
        } else {
            $model = User::where('type', 3)->where('status', true)->with('user')->inRandomOrder()->get();
        }
        return Cache::rememberForever("user_company" . $key . $type, fn () => $model);
    }
}

if (!function_exists('users')) {
    function users($key = null, $type = null)
    {
        if (isset($key) && !empty($key)) {
            if (!empty($type) && $type == 'email') {
                $model = User::orderBy('id', 'DESC')->where('status', true)->where('email', $key)->with('additionalinfo')->first();
            } else if (!empty($type) && $type == 'phone') {
                $model = User::orderBy('id', 'DESC')->where('status', true)->where('phone', $key)->with('additionalinfo')->first();
            } else if (!empty($type) && $type == 'id') {
                $model = User::orderBy('id', 'DESC')->where('status', true)->where('id', $key)->with('additionalinfo')->first();
            } else {
                $model = User::orderBy('id', 'DESC')->where('status', true)->where('id', $key)->with('additionalinfo')->first();
            }
        } else {
            $model = User::orderBy('id', 'DESC')->where('status', true)->get();
        }
        return Cache::rememberForever("users" . $key . $type, fn () => $model);
    }
}

if (!function_exists('users_types')) {
    function users_types($key = null): object
    {
        if (isset($key) && !empty($key)) {
            $model = User::orderBy('id', 'DESC')->where('type', $key)->get();
        } else {
            $model = User::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("users_types" . $key, fn () => $model);
    }
}

if (!function_exists('products')) {
    function products($key = null, $search = null): object
    {
        if (isset($key) && !empty($key)) {
            if (!isset($search) && empty($search)) {
                $model = Products::orderBy('updated_at', 'DESC')->with(['category', 'user', 'images', 'comments'])->where('user_id', $key)
                    ->get();
            } else {
                $model = Products::orderBy('updated_at', 'DESC')
                    ->with(['category', 'user', 'images', 'comments'])
                    ->where('user_id', $key)
                    ->whereRaw('LOWER(JSON_EXTRACT(`name`, "$.az_name")) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.ru_name")) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.en_name")) like ?', ['%' . $search . '%'])
                    ->get();
            }
        } else {
            $model = Products::orderBy('updated_at', 'DESC')->with(['category', 'user', 'images', 'comments'])
                ->get();
        }
        return Cache::rememberForever("products" . $key . $search, fn () => $model);
    }
}

if (!function_exists('view_counters')) {
    function view_counters($key, $type): object
    {
        $model = ViewCounters::where("element_id", $key)->where('type', $type)->get();
        return Cache::rememberForever("view_counters" . $key . $type, fn () => $model);
    }
}

if (!function_exists('siteuser')) {
    function siteuser($key = null)
    {
        if (isset($key) && !empty($key)) {
            $model = SiteUsers::where("ipaddress", $key)->first();
        } else {
            $model = SiteUsers::all();
        }
        return Cache::rememberForever("siteuser" . $key, fn () => $model);
    }
}

if (!function_exists('contactus')) {
    function contactus($key = null): object
    {
        if (isset($key) && !empty($key)) {
            $model = ContactUs::where("id", $key)->first();
        } else {
            $model = ContactUs::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("contactus" . $key, fn () => $model);
    }
}

if (!function_exists('admin_users')) {
    function admin_users($key = null, $type = null): object
    {
        if (isset($key) && !empty($key)) {
            if (isset($type) && !empty($type)) {
                $model = User::where("id", $key)->where('is_admin', true)->withTrashed()->first();
            } else {
                $model = User::where("id", $key)->where('is_admin', true)->first();
            }
        } else {
            if (isset($type) && !empty($type)) {
                if ($type == "trash") {
                    $model = User::where('is_admin', true)->onlyTrashed()->get();
                } else if ($type == "withtrash") {
                    $model = User::where('is_admin', true)->withTrashed()->get();
                } else {
                    $model = User::where('is_admin', true)->get();
                }
            } else {
                $model = User::where('is_admin', true)->get();
            }
        }
        return Cache::rememberForever("admin_users" . $key . $type, fn () => $model);
    }
}

if (!function_exists('users_no_admin')) {
    function users_no_admin($key = null): object
    {
        if (isset($key) && !empty($key)) {
        } else {
            $model = User::where('is_admin', false)->get();
        }
        return Cache::rememberForever("users_no_admin" . $key, fn () => $model);
    }
}

if (!function_exists('comments')) {
    function comments($key = null): object
    {
        if (isset($key) && !empty($key)) {
            $model = Comments::find($key);
        } else {
            $model = Comments::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("comments" . $key, fn () => $model);
    }
}

if (!function_exists('couponcodes')) {
    function couponcodes($key = null, $type = "code"): object
    {
        if (isset($key) && !empty($key)) {
            if ($type == "id") {
                $model = CouponCodes::find($key);
            } else if ($type == "code") {
                $model = CouponCodes::where('code', $key)->first();
            }
        } else {
            $model = CouponCodes::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("couponcodes" . $key, fn () => $model);
    }
}

if (!function_exists('orders')) {
    function orders($key = null, $type = "code", $pagination = 1): object
    {
        if (isset($key) && !empty($key)) {
            if ($type == "id") {
                $model = Orders::where('id',$key)->with(['from','touser','product','payment'])->first();
            } else if ($type == "from_id") {
                $model = Orders::where('from_id', $key)->orderBy('id', 'DESC')->with(['from','touser','product','payment'])->paginate(5, ['*'], 'page', $pagination);
            } else if ($type == "to_id") {
                $model = Orders::where('to_id', $key)->orderBy('id', 'DESC')->with(['from','touser','product','payment'])->paginate(5, ['*'], 'page', $pagination);
            } else if ($type == "product") {
                $model = Orders::where('product_id', $key)->orderBy('id', 'DESC')->with(['from','touser','product','payment'])->paginate(5, ['*'], 'page', $pagination);
            } else if ($type == "status") {
                $model = Orders::where('status', $key)->orderBy('id', 'DESC')->with(['from','touser','product','payment'])->paginate(5, ['*'], 'page', $pagination);
            } else if ($type == "uid") {
                $model = Orders::where('uid', $key)->with(['from','touser','product','payment'])->first();
            } else if ($type == "to_one_user_id") {
                $model = Orders::where('to_id', $key)->with(['from','touser','product','payment'])->first();
            }
        } else {
            $model = Orders::orderBy('id', 'DESC')->paginate(5, ['*'], 'page', $pagination)->with(['from','touser','product','payment'])->orderBy('id','DESC');
        }
        return Cache::rememberForever("orders" . $key . $type . $pagination, fn () => $model);
    }
}

if (!function_exists('product_encoded_images')) {
    function product_encoded_images($key = null, $type = "code", $additionalkey = null)
    {
        if (isset($key) && !empty($key)) {
            if ($type == "id") {
                $model = ProductEncodedImages::find($key);
            } else if ($type == "code") {
                $model = ProductEncodedImages::where('code', $key)->get();
            } else if ($type == "product_id") {
                $model = ProductEncodedImages::where('product_id', $key)->get();
            } else if ($type == "original_images") {
                $model = ProductEncodedImages::where('original_images', $key)->first();
            } else if ($type == "token") {
                $model = ProductEncodedImages::where('token', $key)->get();
            } else if ($type == "token_original_images") {
                $model = ProductEncodedImages::where('token', $key)->where('original_images', $additionalkey)->first();
            }
        } else {
            $model = ProductEncodedImages::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("product_encoded_images" . $key . $type . $additionalkey, fn () => $model);
    }
}

if (!function_exists('messagegroups')) {
    function messagegroups($key = null, $type = null)
    {
        if (isset($key) && !empty($key)) {
            if (isset($type) && !empty($type) && $type == "get_message_groups") {
                $model =MessageGroups::where('receiver_id', $key)
                ->orWhere('sender_id', $key)
                ->with([
                    'senderinfo',
                    'receiverinfo',
                    'message_elements',
                ])
                ->get()
                ->sortBy(function ($group) {
                    return [
                        $group->message_elements->max('status'),
                        $group->message_elements->max('created_at'),
                    ];
                });
            } else if (isset($type) && !empty($type) && $type == "id") {
                $model = MessageGroups::where('id', $key)
                    ->with(['senderinfo', 'receiverinfo', 'message_elements'])
                    ->frist();
            }
        } else {
            $model = MessageGroups::orderBy('created_at', 'desc')->with(['senderinfo', 'receiverinfo', 'message_elements'])->get()->sortBy(function ($group) {
                return [
                    $group->message_elements->max('status'),
                    $group->message_elements->max('created_at'),
                ];
            });
        }
        return Cache::rememberForever("messagegroups" . $key . $type, fn () => $model);
    }
}

if (!function_exists('messageelements')) {
    function messageelements($key = null, $type = null)
    {
        if (isset($key) && !empty($key)) {
            if (isset($type) && !empty($type) && $type == "get_messages_from_groups") {
                $model = MessageElements::where('message_group_id', $key)
                    ->with(['group', 'senderelement'])->orderBy('created_at', 'DESC')->get();
            } else if (isset($type) && !empty($type) && $type == "id") {
                $model = MessageElements::where('id', $key)
                    ->with(['group', 'senderelement'])->first();
            }
        } else {
            $model = MessageElements::orderBy('created_at', 'desc')->with(['group', 'senderelement'])->orderBy('created_at', 'DESC')->get();
        }
        return Cache::rememberForever("messageelements" . $key . $type, fn () => $model);
    }
}

if (!function_exists('sliders')) {
    function sliders($key = null): object
    {
        if (isset($key) && !empty($key)) {
            $model = Sliders::where("id", $key)->first();
        } else {
            $model = Sliders::orderBy('order', 'ASC')->get();
        }
        return Cache::rememberForever("sliders" . $key, fn () => $model);
    }
}

if (!function_exists('languages')) {
    function languages($key = null): object
    {
        if (isset($key) && !empty($key)) {
            $model = Languages::where("name", $key)->first();
        } else {
            $model = Languages::orderBy('id', 'ASC')->where('status', true)->get();
        }
        return Cache::rememberForever("languages" . $key, fn () => $model);
    }
}

if (!function_exists('payments')) {
    function payments($key = null, $type = "code", $pagination = 1): object
    {
        if (isset($key) && !empty($key)) {
            if ($type == "id") {
                $model = Payments::find($key);
            } else if ($type == "from_id") {
                $model = Payments::where('from_id', $key)->orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $pagination);
            } else if ($type == "to_id") {
                $model = Payments::where('to_id', $key)->orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $pagination);
            } else if ($type == "product") {
                $model = Payments::where('product_id', $key)->orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $pagination);
            } else if ($type == "status") {
                $model = Payments::where('payment_status', $key)->orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $pagination);
            }
        } else {
            $model = Payments::orderBy('id', 'DESC')->paginate(10, ['*'], 'page', $pagination);
        }
        return Cache::rememberForever("payments" . $key . $type, fn () => $model);
    }
}

if (!function_exists('background_images')) {
    function background_images($key = null)
    {
        if (isset($key) && !empty($key)) {
            $model = BackgroundImages::where("type", $key)->first();
        } else {
            $model = BackgroundImages::orderBy('id', 'DESC')->get();
        }
        return Cache::rememberForever("background_images" . $key, fn () => $model);
    }
}

