<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\MetaSEO;
use App\Models\Products;
use App\Jobs\SendEmailJob;
use App\Models\Attributes;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsAttributes;
use App\Models\ProductCancelReasons;
use App\Models\ProductEncodedImages;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $category = $request->get('category_id') ?? null;
            $user = $request->get('user_id') ?? null;
            if (!empty($category)) {
                $data = Products::orderBy("id", "DESC")->orderBy('created_at', 'DESC')
                    ->where('category_id', $category)
                    ->get();
            } elseif ($user) {
                $data = Products::orderBy("id", "DESC")->orderBy('created_at', 'DESC')
                    ->where('user_id', $user)
                    ->get();
            } else {
                $data = Products::orderBy("id", "DESC")->orderBy('created_at', 'DESC')->get();
            }

            return view('shops.products.index', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    public function create(Request $request)
    {
        try {
            $categories = categories();
            $attributeGroups = Attributes::whereNull("group_id")->orderBy('order_att','ASC')->get();
            $codeofproduct = Helper::random_generator(7);
            $token = Str::uuid();

            $users = users_no_admin();

            return view(
                'shops.products.create',
                [
                    'token'=>$token,
                    'categories' => $categories,  'attributeGroups' => $attributeGroups,  'codeofproduct' => $codeofproduct,  'users' => $users,
                ]
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string',
                'images.*' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
                'category_id' => 'required|integer',
                'user_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $data=new Products();

            $name = [
                'az_name' => $request->en_name,
                'ru_name' => isset($request->ru_name) ? $request->ru_name : trim(GoogleTranslate::trans($request->en_name, 'ru')),
                'en_name' => isset($request->en_name) ? $request->en_name : trim(GoogleTranslate::trans($request->en_name, 'en')),
            ];

            $countofproducts=Products::where('slugs->az_slug',Str::slug($name['az_name']))
            ->orWhere('slugs->ru_slug',Str::slug($name['ru_name']))
            ->orWhere('slugs->en_slug',Str::slug($name['en_name']))->get();

            $slugs = [
                'az_slug' => count($countofproducts)==0 ? Str::slug($name['az_name']) : Str::slug($name['az_name']).'-'.count($countofproducts)*2,
                'ru_slug' => count($countofproducts)==0 ? Str::slug($name['ru_name']) : Str::slug($name['ru_name']).'-'.count($countofproducts)*2,
                'en_slug' => count($countofproducts)==0 ? Str::slug($name['en_name']) : Str::slug($name['en_name']).'-'.count($countofproducts)*2,
            ];

            $description = [
                'az_description' => $request->en_description,
                'ru_description' => isset($request->ru_description) ? $request->ru_description : trim(GoogleTranslate::trans($request->en_description, 'ru')),
                'en_description' => isset($request->en_description) ? $request->en_description : trim(GoogleTranslate::trans($request->en_description, 'en')),
                ];

            $data->name = $name;
            $data->slugs = $slugs;
            $data->code = $request->code;
            $data->uid = Str::uuid();
            $data->description = $description;
            $data->price = $request->prices['price'];
            $data->category_id = $request->category_id;
            $data->user_id = $request->user_id;
            $data->token=$request->token;
            $data->save();

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
                            $pratt->product_id = $data->id;
                            $pratt->attribute_group_id = $group->id;
                            $pratt->attribute_id = $element->id;
                            $pratt->save();
                        } else {
                            if (!empty(trim($val))) {
                                $name = [
                                    'az_name' => $val,
                                    'ru_name' => trim(GoogleTranslate::trans($val, 'ru')),
                                    'en_name' => trim(GoogleTranslate::trans($val, 'en')),
                                ];

                                if (isset($name['az_name']) && !empty($name['az_name'])) {

                                    $slugs = [
                                        'az_slug' => Str::slug(trim($name['az_name'])),
                                        'ru_slug' => Str::slug(trim($name['ru_name'])),
                                        'en_slug' => Str::slug(trim($name['en_name'])),
                                    ];

                                    $attr = new Attributes();
                                    $attr->name = $name;
                                    $attr->slugs = $slugs;
                                    $attr->group_id = $group->id;
                                    $attr->datatype = $group->datatype;
                                    $attr->save();

                                    $pratt = new ProductsAttributes();
                                    $pratt->product_id = $data->id;
                                    $pratt->attribute_group_id = $group->id;
                                    $pratt->attribute_id = $attr->id;
                                    $pratt->save();
                                }
                            }
                        }
                    }
                }
            }

            $meta_title = [
                'az_meta_title' => trim($request->en_meta_title) ?? $request->en_name,
                'ru_meta_title' => $request->ru_meta_title ?? $request->ru_name,
                'en_meta_title' => $request->en_meta_title ?? $request->en_name,
            ];

            $meta_description = [
                'az_meta_description' => trim($request->az_meta_description) ?? $meta_title['az_meta_title'],
                'ru_meta_description' => $request->ru_meta_description ?? $meta_title['ru_meta_title'],
                'en_meta_description' => $request->en_meta_description ?? $meta_title['en_meta_title'],
            ];

            $meta_keywords = [
                'az_meta_keywords' => $request->az_meta_keywords ?? trim($request->en_name),
                'ru_meta_keywords' => $request->ru_meta_keywords ?? trim($request->ru_name),
                'en_meta_keywords' => $request->en_meta_keywords ?? trim($request->en_name),
            ];
            if(isset($data) && !empty($data)){
            $seo = new MetaSEO();
            $seo->name = $meta_title;
            $seo->description = $meta_description;
            $seo->keywords = $meta_keywords;
            $seo->type="products";
            $seo->element_id=$data->id;
            $seo->save();
        

            foreach (ProductEncodedImages::where('token', $request->token)->get() as $ima) {
                $ima->update(['product_id' => $data->id,'code'=>$request->code]);
            }

        }

            return redirect(route("products.index"))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        return redirect()->back()->with("error", "Səhifə tapılmadı");
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
            $categories = categories();
            $attributeGroups = Attributes::whereNull("group_id")->orderBy('order_att','ASC')->get();
            $codeofproduct = Helper::random_generator(7);
            $users = users_no_admin();
            $token=Str::uuid();
            $data = Products::where('id',$id)->with(['attributes','seo','category','user','images'])->first();            

            $user_products = Products::where('user_id', $data->user_id)->get();
            $category_products = Products::where("category_id", $data->category_id)->get();

            return view(
                'shops.products.create',
                [
                    'token'=>$token,
                    'data' => $data, 'categories' => $categories,  'attributeGroups' => $attributeGroups,  'codeofproduct' => $codeofproduct,  'users' => $users,
                    "user_products" => $user_products,
                    "category_products" => $category_products,
                ]
            );
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
            $data = product($id);
            $validator = Validator::make($request->all(), [
                'code' => 'required|string',
                'other_images.*' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
                'category_id' => 'required|integer',
                'user_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $name = [
                'az_name' => $request->en_name,
                'ru_name' => isset($request->ru_name) ? $request->ru_name : trim(GoogleTranslate::trans($request->en_name, 'ru')),
                'en_name' => isset($request->en_name) ? $request->en_name : trim(GoogleTranslate::trans($request->en_name, 'en')),
                ];

                
            $description = [
                'az_description' => $request->en_description,
                'ru_description' => isset($request->ru_description) ? $request->ru_description : trim(GoogleTranslate::trans($request->en_description, 'ru')),
                'en_description' => isset($request->en_description) ? $request->en_description : trim(GoogleTranslate::trans($request->en_description, 'en')),
                'tr_description' => isset($request->tr_description) ? $request->tr_description : trim(GoogleTranslate::trans($request->en_description, 'tr')),
            ];

            $data->name = $name;
            $data->code = $request->code;
            $data->uid = Str::uuid();
            $data->description = $description;
            $data->price = $request->prices['price'];
            $data->category_id = $request->category_id;
            $data->user_id = $request->user_id;
            $data->token=$request->token;
            // $data->contactinfo = $request->contactinfo;
            $data->update();

            if ($request->attribute != null) {

                foreach ($request->attribute as $key => $value) {
                    $attribute = Attributes::where('group_id', $key)->where('name->az_name', $value)->orWhere("name->ru_name", $value)->orWhere('name->en_name', $value)->first();
                    foreach($data->attributes as $ats){
                        $ats->delete();
                    }
                    
                    if (isset($attribute) && !empty($attribute)) {
                        $productattribute=ProductsAttributes::where('product_id',$data->id)->where('attribute_id',$attribute->id)->where('attribute_group_id',$key)->first();
                        if(!empty($productattribute)){
                            $productattribute->product_id = $data->id;
                            $productattribute->attribute_id = $attribute->id;
                            $productattribute->attribute_group_id = $key;
                            $productattribute->update();
                        }else{
                            $productattribute = new ProductsAttributes();
                            $productattribute->product_id = $data->id;
                            $productattribute->attribute_id = $attribute->id;
                            $productattribute->attribute_group_id = $key;
                            $productattribute->save();
                        }
                        
                        
                    } else {
                        $attribute = new Attributes();
                        $attributegroup = Attributes::find($key);
                        $name = [
                            'az_name' => strval($value),
                            'ru_name' => trim(GoogleTranslate::trans(strval($value), 'ru')),
                            'en_name' => trim(GoogleTranslate::trans(strval($value), 'en')),
                            'tr_name' => trim(GoogleTranslate::trans(strval($value), 'tr')),
                        ];

                        $attribute->name = $name;
                        $attribute->group_id = $key;
                        $attribute->datatype = $attributegroup->datatype;
                        $attribute->order_att = count($attributegroup->groupElements) + 1;
                        $attribute->save();

                        $productattribute = new ProductsAttributes();
                        $productattribute->product_id = $data->id;
                        $productattribute->attribute_id = $attribute->id;
                        $productattribute->attribute_group_id = $key;
                        $productattribute->save();
                    }
                }
            }

            $meta_title = [
                'az_meta_title' => trim($request->az_meta_title) ?? $request->en_name,
                'ru_meta_title' => $request->ru_meta_title ?? $request->ru_name,
                'en_meta_title' => $request->en_meta_title ?? $request->en_name,
            ];

            $meta_description = [
                'az_meta_description' => trim($request->en_meta_description) ?? $meta_title['en_meta_title'],
                'ru_meta_description' => $request->ru_meta_description ?? $meta_title['ru_meta_title'],
                'en_meta_description' => $request->en_meta_description ?? $meta_title['en_meta_title'],
            ];

            $meta_keywords = [
                'az_meta_keywords' => $request->en_meta_keywords ?? trim($request->en_name),
                'ru_meta_keywords' => $request->ru_meta_keywords ?? trim($request->ru_name),
                'en_meta_keywords' => $request->en_meta_keywords ?? trim($request->en_name),
            ];

            $seo = MetaSEO::where('type','products')->where("element_id",$id)->first();
            if(empty($seo)){
                $seo=new MetaSEO();
                $seo->type="products";
                $seo->element_id=$id;
            }
            $seo->name = $meta_title;
            $seo->description = $meta_description;
            $seo->keywords = $meta_keywords;
            $seo->update();
        

            foreach (ProductEncodedImages::where('token', $request->token)->get() as $ima) {
                $ima->update(['product_id' => $data->id,'code'=>$request->code]);
            }

            return redirect(route("products.index"))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productattributesdestroy($id)
    {
        try {
            ProductsAttributes::where('id', $id)->delete();
            return redirect()->back()->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function deleteimage(Request $request)
    {
        try {
            ProductEncodedImages::where('product_id', $request->product_id)->where('id', $request->image)->delete();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function destroy($id)
    {
        try {
            $product = product($id);
            $product->delete();
            return redirect()->back()->with('success', trans('additional.messages.deleted'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    
    public function getorcreatedirectory($clasor, $token)
    {
        $directory = public_path('uploads/' . $clasor . '/' . $token);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }
   
    public function image_changeorder(Request $request, $code)
    {
        try {
            $a = [];
            foreach ($request->data as $key => $value) {
                $exploded = explode("image_", $value);
                if (isset($exploded[1]) && !empty($exploded[1])) {
                    $image = ProductEncodedImages::find($exploded[1]);
                    if ($image) {
                        $image->update(['order_a' => $key]);
                        array_push($a);
                    }
                }
            }
            return $a;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
}
