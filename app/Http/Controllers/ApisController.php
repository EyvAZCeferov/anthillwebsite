<?php

namespace App\Http\Controllers;

use App\Models\WishlistItems;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Orders;
use App\Helpers\Helper;
use App\Models\Comments;
use App\Models\Payments;
use App\Models\Products;
use App\Helpers\GUAVAPAY;
use App\Mail\GeneralMail;
use App\Models\ContactUs;
use App\Jobs\SendEmailJob;
use App\Models\Attributes;
use App\Models\Categories;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;
use App\Models\MessageGroups;
use App\Events\NewChatMessage;
use App\Events\SendEmailEvent;
use App\Models\MessageElements;
use App\Models\UserAdditionals;
use App\Models\ProductsAttributes;
use Illuminate\Support\Facades\DB;
use App\Models\ProductEncodedImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ApisController extends Controller
{
    public function cacheflush()
    {
        try {
            Cache::flush();
            return "Cache Flushed";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function get_attributes(Request $request)
    {
        try {
            return response()->json(attributes(intval($request->category_id)));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function image_upload(Request $request, $clasore)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $clasore . '-' . time() . '.' . $image->extension();
                $image = Helper::uploadimage($request->file('image'), $clasore, $filename);

                return $image;
            } else {
                return response()->json(['status' => 'error', 'message' => 'Yüklenecek bir resim bulunamadı']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function imageupload(Request $request, $token)
    {
        try {
            if (!empty($request->file('file'))) {
                $imageName = null;

                if (isset($request->file) && !empty($request->file) && $request->hasFile('file')) {
                    $imageName = Helper::uploadimage($request->file('file'), 'products');
                }
                $images = new ProductEncodedImages();
                $images->original_images = $imageName;
                $images->order_a = count(product_encoded_images($token, 'token')) + 1;
                $images->token = $token;
                $images->save();

                return $imageName;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function uploaded_images($token)
    {
        $product = Products::where('token', $token)->first();
        $images = ProductEncodedImages::where('code', $product->code)->whereNotNull('original_images')->orderBy("order_a", 'ASC')->get();
        $imagesArray = [];
        foreach ($images as $image) {
            $imagesArray[] = [
                'name' => $image->original_images,
                'size' => 10,
                'path' => Helper::getImageUrl($image->original_images, 'products'),
            ];
        }

        return response()->json($imagesArray);
    }
    public function imagedelete(Request $request, $token)
    {
        try {
            $productimages = product_encoded_images($token, 'token_original_images', $request->filename);
            if (!empty($productimages)) {
                Helper::delete_image($request->filename, "products/" . $token);

                $productimages->delete();
                return true;
            } else {
                return 'a';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function image_changeorder($token, Request $request)
    {
        try {
            $images = product_encoded_images($token, 'token');

            foreach ($request->data as $key => $value) {
                $image = $images->firstWhere('original_images', $value);
                if ($image) {
                    $image->update(['order_a' => $key]);
                }
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function addnewform(Request $request)
    {
        try {
            if (
                isset($request->token) &&
                isset($request->category_id) &&
                isset($request->additional_info) &&
                isset($request->price)
            ) {
                $product_count = count(products());
                $codeofproduct = Helper::random_generator($product_count);

                if ($product_count >= 999) {
                    $codeofproduct = intval(Products::latest()->first()->code) + 1;
                }

                $name = [
                    'az_name' => $request->name,
                    'ru_name' => trim(GoogleTranslate::trans($request->name, 'ru')),
                    'en_name' => trim(GoogleTranslate::trans($request->name, 'en')),
                ];

                $description = [
                    'az_description' => $request->additional_info ?? ' ',
                    'ru_description' => $request->additional_info ?? ' ',
                    'en_description' => $request->additional_info ?? ' ',
                ];

                $countofproducts = Products::where('slugs->az_slug', Str::slug($name['az_name']))
                    ->orWhere('slugs->ru_slug', Str::slug($name['ru_name']))
                    ->orWhere('slugs->en_slug', Str::slug($name['en_name']))->get();

                $slugs = [
                    'az_slug' => count($countofproducts) == 0 ? Str::slug($name['az_name']) : Str::slug($name['az_name']) . '-' . count($countofproducts) * 2,
                    'ru_slug' => count($countofproducts) == 0 ? Str::slug($name['ru_name']) : Str::slug($name['ru_name']) . '-' . count($countofproducts) * 2,
                    'en_slug' => count($countofproducts) == 0 ? Str::slug($name['en_name']) : Str::slug($name['en_name']) . '-' . count($countofproducts) * 2,
                ];
                $product = new Products;

                DB::transaction(function () use ($request, $codeofproduct, $name, $description, $slugs, &$product) {

                    $product->code = $codeofproduct;
                    $product->token = $request->token;
                    $product->name = $name;
                    $product->description = $description;
                    $product->slugs = $slugs;
                    $product->uid = Str::uuid();
                    $product->category_id = $request->category_id;
                    $product->price = $request->price;
                    $product->status = 0;
                    $product->user_id = $request->user_id ?? Auth::user()->id;
                    $product->save();

                    if ($request->attribute != null) {
                        $keys = array_keys($request->attribute);
                        if ($request->type_product == 1) {
                            $key = array_search(9, $keys);
                            unset($keys[$key]);
                        }
                        foreach ($keys as $key) {
                            $val = $request->attribute[$key];
                            if (!empty(trim($val))) {
                                $group = attributes_attribute($key);
                                $element = attributes_attribute($key, 'string', $val);

                                if (!empty($element) && isset($element->id)) {
                                    $pratt = new ProductsAttributes();
                                    $pratt->product_id = $product->id;
                                    $pratt->attribute_group_id = $group->id;
                                    $pratt->attribute_id = $element->id;
                                    $pratt->save();
                                } else {
                                    if (!empty(trim($val))) {
                                        $name = [
                                            'az_name' => $val,
                                            'ru_name' => trim(GoogleTranslate::trans($val, 'ru')),
                                            'en_name' => trim(GoogleTranslate::trans($val, 'en')),
                                            'tr_name' => trim(GoogleTranslate::trans($val, 'tr')),
                                        ];

                                        if (isset($name['az_name']) && !empty($name['az_name'])) {

                                            $slugs = [
                                                'az_slug' => Str::slug(trim($name['az_name'])),
                                                'ru_slug' => Str::slug(trim($name['ru_name'])),
                                                'en_slug' => Str::slug(trim($name['en_name'])),
                                                'tr_slug' => Str::slug(trim($name['tr_name'])),
                                            ];

                                            $attr = new Attributes();
                                            $attr->name = $name;
                                            $attr->slugs = $slugs;
                                            $attr->group_id = $group->id;
                                            $attr->datatype = $group->datatype;
                                            $attr->save();

                                            $pratt = new ProductsAttributes();
                                            $pratt->product_id = $product->id;
                                            $pratt->attribute_group_id = $group->id;
                                            $pratt->attribute_id = $attr->id;
                                            $pratt->save();
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach (ProductEncodedImages::where('token', $request->token)->get() as $ima) {
                        $ima->update(['product_id' => $product->id, "code" => $codeofproduct]);
                    }

                    $user = users($request->user_id, 'id');

                    // $datas = [
                    //     'message' => trans("additional.emailtemplates.service.newservicemessage", ['username' => $user->name_surname, 'website' => env("WEBSITE_NAME"), 'name' => $product->name[app()->getLocale() . '_name']]),
                    //     'email' => $user->email,
                    //     'name_surname' => $user->name_surname,
                    //     'type' => 'addnewelan',
                    //     'title' => trans('additional.emailtemplates.service.newservice', [], app()->getLocale())
                    // ];
                    // event(new SendEmailEvent($datas));
                });
                return response()->json(['status' => "success", 'url' => route("myservices.index")]);


            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.datasnull')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function updatenewform(Request $request)
    {
        try {
            if (
                isset($request->token) &&
                isset($request->category_id) &&
                isset($request->additional_info) &&
                isset($request->price) &&
                isset($request->code)
            ) {
                $product_count = count(products());
                $product = product($request->code, true);
                $codeofproduct = $request->code;
                if ($product_count >= 999) {
                    $codeofproduct = intval($product->code) + 1;
                }
                $name = [
                    'az_name' => $request->name,
                    'ru_name' => trim(GoogleTranslate::trans($request->name, 'ru')),
                    'en_name' => trim(GoogleTranslate::trans($request->name, 'en')),
                    'tr_name' => trim(GoogleTranslate::trans($request->name, 'tr')),
                ];

                $description = [
                    'az_description' => $request->input('additional_info') ?? ' ',
                    'ru_description' => $request->input('additional_info') ?? ' ',
                    'en_description' => $request->input('additional_info') ?? ' ',
                ];


                DB::transaction(function () use ($request, $codeofproduct, $name, $description, &$product) {

                    $product->name = $name;
                    $product->description = $description;
                    $product->category_id = $request->category_id;
                    $product->price = $request->price;
                    $product->status = 0;
                    $product->update();

                    foreach ($product->attributes as $attribute) {
                        $attribute->delete();
                    }

                    if ($request->attribute != null) {
                        $keys = array_keys($request->attribute);

                        foreach ($keys as $key) {
                            $val = $request->attribute[$key];
                            if (!empty(trim($val))) {
                                $group = attributes_attribute($key);
                                $element = attributes_attribute($key, 'string', $val);

                                if (!empty($element) && isset($element->id)) {
                                    $pratt = new ProductsAttributes();
                                    $pratt->product_id = $product->id;
                                    $pratt->attribute_group_id = $group->id;
                                    $pratt->attribute_id = $element->id;
                                    $pratt->save();
                                } else {
                                    if (!empty(trim($val))) {
                                        $name = [
                                            'az_name' => $val,
                                            'ru_name' => trim(GoogleTranslate::trans($val, 'ru')),
                                            'en_name' => trim(GoogleTranslate::trans($val, 'en')),
                                            'tr_name' => trim(GoogleTranslate::trans($val, 'tr')),
                                        ];

                                        if (isset($name['az_name']) && !empty($name['az_name'])) {

                                            $slugs = [
                                                'az_slug' => Str::slug(trim($name['az_name'])),
                                                'ru_slug' => Str::slug(trim($name['ru_name'])),
                                                'en_slug' => Str::slug(trim($name['en_name'])),
                                                'tr_slug' => Str::slug(trim($name['tr_name'])),
                                            ];

                                            $attr = new Attributes();
                                            $attr->name = $name;
                                            $attr->slugs = $slugs;
                                            $attr->group_id = $group->id;
                                            $attr->datatype = $group->datatype;
                                            $attr->save();

                                            $pratt = new ProductsAttributes();
                                            $pratt->product_id = $product->id;
                                            $pratt->attribute_group_id = $group->id;
                                            $pratt->attribute_id = $attr->id;
                                            $pratt->save();
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach (ProductEncodedImages::where('token', $request->token)->whereNull('code')->get() as $ima) {
                        $ima->update(['product_id' => $product->id, "code" => $codeofproduct]);
                    }

                    // $user = users($request->user_id, 'id');

                    // $datas = [
                    //     'message' => trans("additional.emailtemplates.service.updateservicemessage", ['username' => $user->name_surname, 'website' => env("WEBSITE_NAME"), 'name' => $product->name[app()->getLocale() . '_name']]),
                    //     'email' => $user->email,
                    //     'name_surname' => $user->name_surname,
                    //     'type' => 'updateelan',
                    //     'title' => trans("additional.emailtemplates.service.updateservice", [], $request->language)
                    // ];
                    // event(new SendEmailEvent($datas));
                });
                return response()->json(['status' => "success", 'url' => route("myservices.index")]);
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.datasnull')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function sharecomment(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $comment = new Comments();
                $comment->user_id = $request->user_id;
                $comment->product_id = $request->product_id;
                $comment->rating = $request->yildiz ?? 5;
                $comment->comment = $request->message;
                $comment->status = true;
                $comment->save();
            });
            return response()->json(['status' => 'success', 'message' => trans('additional.messsages.sharedcommentpleasewait', [], $request->language)]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function createpayment(Request $request)
    {
        try {

            $service = product($request->service_id, true);

            $payment = new Payments();

            // DB::transaction(function () use ($request, &$payment, $service) {

                $payment->transaction_id = Helper::createRandomCode('string', 10);
                $payment->payment_status = 0;
                $payment->amount = isset($request->price) && !empty($request->price) && $request->price > 0 ? $request->price : $service->price;
                $payment->from_id = $request->sender_id;
                $payment->to_id = $request->receiver_id ?? null;
                $payment->data = [
                    "name" => $service->name,
                    "from_id" => $request->sender_id,
                    "to_id" => $request->receiver_id ?? null,
                    'ipaddress' => $request->ip(),
                    "orderid" => Helper::createRandomCode('string', 22),
                    "service_id" => $service->id,
                    "order_id"=>''
                ];
                $payment->save();
            // });

                // DB::transaction(function () use ($request,$service,$payment) {
                    $neworder = new Orders();
                    $neworder->uid = Helper::createRandomCode('string', 22);
                    $neworder->from_id = $request->sender_id;
                    $neworder->to_id = $request->receiver_id??null;
                    $neworder->product_id = $service->id;
                    $neworder->payment_id = $payment->id;
                    $neworder->status = 0;
                    $neworder->price = isset($request->price) && !empty($request->price) && $request->price > 0 ? $request->price : $service->price;
                    $neworder->ipaddress = $request->ip();
                    $neworder->save();
                // });
            $payment->update(['data->order_id'=>$neworder->id]);

            return GUAVAPAY::createorder($payment->id, $request->language ?? 'en');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function deleteservice(Request $request)
    {
        try {
            $product = product($request->code, true);
            if ($product->user_id == $request->auth) {
                $product->delete();
                return response()->json(['status' => 'success', 'message' => trans('additional.messages.deletedservice', [], $request->language)]);
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.notyours', [], $request->language)]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function serviceinfo($code, Request $request)
    {
        try {
            $service = product($code, true);
            return response()->json($service);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function searchinfilled(Request $request)
    {
        try {
            if ($request->type == "services") {
                if (isset($request->action) && !empty($request->action)) {
                    if ($request->action == "category") {
                        if ($request->category == "all") {
                            $data = products();
                        } else {
                            $category = Categories::where('slugs->az_slug', $request->category)
                                ->orWhere('slugs->ru_slug', $request->category)
                                ->orWhere('slugs->en_slug', $request->category)
                                ->where('status', true)
                                ->orderBy('id', 'DESC')
                                ->first();
                            if (!empty($category)) {
                                $data = Products::where("category_id", $category->id)->get();
                            } else {
                                $data = [];
                            }
                        }
                    }
                } else {
                    $data = Products::whereRaw('LOWER(JSON_EXTRACT(`name`, "$.az_name")) like ?', ['%' . $request->input('query') . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.ru_name")) like ?', ['%' . $request->input('query') . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.en_name")) like ?', ['%' . $request->input('query') . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`description`, "$.az_description")) like ?', ['%' . $request->input('query') . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`description`, "$.ru_description")) like ?', ['%' . $request->input('query') . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`description`, "$.en_description")) like ?', ['%' . $request->input('query') . '%'])
                        ->get();
                }
            } else {
                $ids = UserAdditionals::whereRaw('LOWER(JSON_EXTRACT(`company_name`, "$.az_name")) like ?', ['%' . $request->input('query') . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`company_name`, "$.ru_name")) like ?', ['%' . $request->input('query') . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`company_name`, "$.en_name")) like ?', ['%' . $request->input('query') . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`company_description`, "$.az_description")) like ?', ['%' . $request->input('query') . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`company_description`, "$.ru_description")) like ?', ['%' . $request->input('query') . '%'])
                    ->orWhereRaw('LOWER(JSON_EXTRACT(`company_description`, "$.en_description")) like ?', ['%' . $request->input('query') . '%'])
                    ->select('user_id')
                    ->get()
                    ->pluck('user_id');

                $data = User::whereIn('id', $ids)->with(['additionalinfo', 'products'])->where('type', 3)->get();
            }
            return response()->json([
                'status' => 'success',
                "view" => view($request->type . '.render_products', compact('data'))->render()
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function filterelements(Request $request)
    {
        try {
            $ids = $request->ids;
            $orderby = null;
            if (isset($request->orderby) && !empty($request->orderby) && $request->orderby == "asc") {
                $orderby = 'name->"$.' . $request->language . '_name"' . $request->orderby;
            } else if (isset($request->orderby) && !empty($request->orderby) && $request->orderby == "desc") {
                $orderby = 'name->"$.' . $request->language . '_name"' . $request->orderby;
            } else if (isset($request->orderby) && !empty($request->orderby) && $request->orderby == "random") {
                $orderby = "inrandomorder";
            } else if (isset($request->orderby) && !empty($request->orderby) && $request->orderby == "priceasc") {
                $orderby = 'price asc';
            } else if (isset($request->orderby) && !empty($request->orderby) && $request->orderby == "pricedesc") {
                $orderby = 'price desc';
            }

            if ($request->type == "services") {
                if ($orderby != "inrandomorder") {
                    $data = Products::whereIn('code', $ids)->orderByRaw($orderby)->get();
                } else {
                    $data = Products::whereIn('code', $ids)->inRandomOrder()->get();
                }
            }
            return response()->json([
                'status' => 'success',
                "view" => view('services.render_products', compact('data'))->render()
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function bookmarktoggle(Request $request)
    {
        try {
            $product=product($request->code,true);
            if(Auth::check()){
                $item=wishlist_items(Auth::id(),$product->id);
                if(!empty($item)){
                    $item->delete();
                }else{
                    DB::transaction(function () use ($request,$product) {
                        $wishlistitem=new WishlistItems();
                        $wishlistitem->product_id=$product->id;
                        $wishlistitem->user_id=Auth::id();
                        $wishlistitem->ipaddress=$request->ip();
                        $wishlistitem->save();
                    });
                }

                return response()->json(['status' => 'success', 'added'=>true]);
            }else{
                return response()->json(['status' => 'error', 'url'=>route('auth.login')]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }finally{
            Helper::dbdeactive();
        }
    }
    public function services_user($user_id)
    {
        try {
            $data = products($user_id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error']);
        }
    }
    public function services_user_search($user_id, $search)
    {
        try {
            $data = Products::orderBy('updated_at', 'DESC')
                ->with(['category', 'user', 'images', 'comments'])
                ->where('user_id', $user_id)
                ->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(`name`, "$.az_name")) like ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.ru_name")) like ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(`name`, "$.en_name")) like ?', ['%' . $search . '%']);
                })->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error']);
        }
    }
    public function get_category_datas($token, $attribute_group_id)
    {
        try {
            $product = product_with_token($token, false);
            $withgroupproduct = attributes_attribute($product->id, 'withgroupproduct', $attribute_group_id);
            return response()->json($withgroupproduct->attribute);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function sendform(Request $request)
    {
        try {
            $contactus = new ContactUs();

            // DB::transaction(function () use ($request, &$contactus) {
                $contactus->message = $request->message;
                $contactus->name = $request->name;
                $contactus->email = $request->email;
                $contactus->phone = $request->phone;
                $contactus->ipadress = $request->ip();
                if (Auth::check()) {
                    $contactus->user_id = Auth::id();
                }
                $contactus->save();
            // });

            $datas = [
                'message' => trans("additional.emailtemplates.contactusmessage", ['username' => $contactus->name ?? null, 'email' => $contactus->email, 'tel' => $contactus->phone, 'desc' => $contactus->message]),
                'email' => $contactus->email,
                'name_surname' => $contactus->name,
                'type' => 'contactus',
                'title' => trans('additional.emailtemplates.contactus')
            ];

            // \Log::info($datas);
            // dispatch(new SendEmailJob($datas));
            Mail::send(new GeneralMail($datas['type'], $datas['title'], $datas['message'],env('MAIL_USERNAME'), env('MAIL_FROM_NAME')));

            return response()->json(['status' => 'success', 'message' => trans('additional.messages.messagesended', [], $request->language ?? 'en')]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function changestat_order(Request $request)
    {
        try {
            if (isset($request->authent) && !empty($request->authent)) {
                DB::transaction(function () use ($request) {

                    $data = orders($request->order, 'uid');
                    $user = users($data->to_id, 'id');
                    $data->update([
                        "status" => $request->change_status
                    ]);
                    $datas = [
                        'message' => trans("additional.messages.orderupdatedmessage", ['status' => trans('additional.pages.payments.status_' . $request->change_status)]),
                        'email' => $user->email,
                        'name_surname' => $user->name_surname,
                        'type' => 'orderstatuschanged',
                        'title' => trans('additional.emailtemplates.service.orderupdated')
                    ];

                    // broadcast(new SendEmailEvent($data))->toOthers()->onConnection('redis');
                    broadcast(new SendEmailEvent($datas));
                });
                return response()->json(['status' => 'success', 'message' => trans('additional.messages.datasupdated', [], $request->language ?? 'en')]);
            } else {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.pleaselogin', [], $request->language ?? 'en')]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function checkpayment($transaction_id)
    {
        try {
            $payment = Payments::where("transaction_id", $transaction_id)->first();
            if (!empty($payment)) {
                return GUAVAPAY::checkstatus($transaction_id, 'az');
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function sitemap()
    {
        try {
            if (File::exists(public_path('sitemap.xml'))) {
                File::delete(public_path("sitemap.xml"));
            }

            $routes = [
                [
                    "url" => route("welcome"),
                    "priorty" => 0.7
                ],
                [
                    "url" => route("auth.login"),
                    "priorty" => 0.7
                ],
                [
                    "url" => route("auth.register"),
                    "priorty" => 0.7
                ],
                [
                    "url" => route("auth.forgetpassword"),
                    "priorty" => 0.7
                ],
                [
                    "url" => route("services.addnew"),
                    "priorty" => 0.9
                ],
            ];

            foreach (standartpages() as $page) {
                $element = [
                    "url" => route("standartpages.show", $page->slugs[app()->getLocale() . '_slug']),
                    "priorty" => 0.8
                ];
                $routes = array_merge($routes, [$element]);
            }

            foreach (products() as $page) {
                $element = [
                    "url" => route("services.show", $page->slugs[app()->getLocale() . '_slug']),
                    "priorty" => 0.9
                ];
                $routes = array_merge($routes, [$element]);
            }

            foreach (user_companies() as $page) {
                $element = [
                    "url" => route("companies.show", $page->additionalinfo->company_slugs[app()->getLocale() . '_slug']),
                    "priorty" => 0.9
                ];
                $routes = array_merge($routes, [$element]);
            }
            $sitemap = Sitemap::create();
            foreach ($routes as $route) {
                $sitemap->add($route['url'], now(), $route['priorty']);
            }
            $sitemap->writeToFile(public_path('sitemap.xml'));
            return $sitemap;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function registerandchatithuser(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                return response()->json(['status' => 'error', 'message' => trans('additional.messages.userfound', [], $request->language ?? 'en'), 'url' => route("auth.login")]);
            } else {
                DB::transaction(function () use ($request) {
                    $password = Str::slug($request->name_surname ?? Helper::createRandomCode("string", 12));
                    $user = new User();
                    $user->name_surname = $request->name_surname;
                    $user->email = $request->email;
                    $user->phone = null;
                    $user->password = bcrypt($password);
                    $user->is_admin = false;
                    $user->type = 1;
                    $user->status = true;
                    $user->save();

                    $useradditional = new UserAdditionals();
                    $useradditional->user_id = $user->id;
                    $useradditional->original_pass = $password;
                    $useradditional->save();
                    $datas = [
                        'message' => trans('additional.emailtemplates.service.registeredmessage', ['name' => $request->name_surname, 'url' => route('auth.login'), 'password' => $password], $request->language ?? 'en'),
                        'email' => env('MAIL_USERNAME'),
                        'name_surname' => env('APP_NAME'),
                        'type' => 'newregister',
                        'title' => trans('additional.emailtemplates.service.registered')
                    ];
                    // event(new SendEmailEvent($datas));
                    Auth::login($user);

                    $data = new MessageGroups();
                    $data->sender_id = $request->user_id;
                    $data->receiver_id = $user->id;
                    if (isset($request->product_id)) {
                        $data->product_id = $request->product_id;
                    }
                    $data->save();

                    $messagecontent = '' . route("services.show", $data->product->slugs[app()->getLocale() . "_slug"]) . '';

                    $message = new MessageElements();
                    $message->user_id = Auth::id();
                    $message->message_group_id = $data->id;
                    $message->message = $messagecontent;
                    $message->status = false;
                    $message->save();

                    // broadcast(new NewChatMessage($message))->toOthers();
                });
                return response()->json([
                    'status' => 'success',
                    'message' => trans('additional.messages.redirectingformessagesending', [], $request->language ?? 'en'),
                    'url' => route('messages.index', ['createdvia' => $request->user_id]),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function getnotreadedmessagescount(Request $request)
    {
        $notreadedmessages = Helper::getnotreadedmessagescount();
        return response()->json($notreadedmessages);
    }
    public function delete_attribute(Request $request){
        try{
            $productattribute=ProductsAttributes::where('product_id',$request->product_id)->where('attribute_group_id',$request->group_id)->first();
            $productattribute->delete();
            return response()->json(['message'=>trans('additional.messages.deleted'),'status'=>'success']);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage(),'status'=>'error']);
        }finally{
            Helper::dbdeactive();
        }
    }
}
