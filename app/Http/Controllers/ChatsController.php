<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\MessageGroups;
use App\Events\NewChatMessage;
use App\Models\MessageElements;
use App\Models\ProductsAttributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            return view('messages.index');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function fetchmessagegroups(Request $request)
    {
        try {
            $data = messagegroups(Auth::id(), 'get_message_groups');
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function fetchmessages($roomid)
    {
        try {
            $messages = MessageElements::where('message_group_id', $roomid)->orderBy('created_at', 'DESC')->with(['group','senderelement'])->get();
            return response()->json(['status' => 'success', 'data' => $messages]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function fetchattributes($id)
    {
        try {
            $productattributes = ProductsAttributes::where('product_id', $id)
                ->whereHas('attribute', function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->whereNotNull('name->az_name')
                            ->orWhereNotNull('name->ru_name')
                            ->orWhereNotNull('name->en_name')
                            ->orWhereNotNull('name->tr_name');
                    });
                })
                ->with('attribute')
                ->get()
                ->map(function ($item) {
                    $item->attribute->name = array_filter($item->attribute->name, function ($value) {
                        return !empty($value);
                    });
                    return $item;
                })
                ->reject(function ($item) {
                    return empty($item->attribute->name);
                });

            return response()->json(['data' => $productattributes]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function sendmessage(Request $request, $roomid)
    {
        try {
            DB::transaction(function () use ($request, $roomid) {
                $message = new MessageElements();
                $message->user_id = Auth::id();
                $message->message_group_id = $roomid;
                $message->message = $request->message;
                $message->status = false;
                $message->save();

                broadcast(new NewChatMessage($message))->toOthers();
            });

            return response()->json(['status' => 'success', 'message' => "İsmarıc göndərildi"], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } finally {
            Helper::dbdeactive();
        }
    }
    public function readmessage($messageid)
    {
        try {
            $message = messageelements($messageid, 'id');
            $message->update(['status' => true]);
            return response()->json([$message], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function create_and_redirect(Request $request)
    {
        try {
            if (isset($request->user_id) && !empty($request->user_id) && isset($request->auth_id) && !empty($request->auth_id)) {
                $data = MessageGroups::where('sender_id', $request->user_id)->where('receiver_id', $request->auth_id)->first();
                if (empty($data)) {
                    $data = new MessageGroups();
                    $data->sender_id = $request->user_id;
                    $data->receiver_id = $request->auth_id;
                    $data->save();
                }

                if (isset($request->product_id)) {
                    $data->product_id = $request->product_id;
                }
                $data->update();

                $messagecontent = '' . route("services.show", $data->product->slugs[app()->getLocale() . "_slug"]) . '';

                $message = new MessageElements();
                $message->user_id = Auth::id();
                $message->message_group_id = $data->id;
                $message->message = $messagecontent;
                $message->status = false;
                $message->save();

                // broadcast(new NewChatMessage($message))->toOthers();

                return response()->json([
                    'status' => 'success',
                    'message' => trans('additional.messages.redirectingformessagesending', [], $request->language ?? 'en'),
                    'url' => route('messages.index', ['createdvia' => $request->user_id]),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => trans('additional.messages.pleaselogin', [], $request->language ?? 'en')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        } finally {
            Helper::dbdeactive();
        }
    }
}
