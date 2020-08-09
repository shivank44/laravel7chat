<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Conversation;
use App\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index (Request $request){

        $user_id = $request->user_id;

        $success['status'] = 200;
        $unread_message_count = Message::select(DB::raw('count(messages.id) as unread_message_count'),'conversations.conversation_name')
                                ->join('conversations','conversations.id','messages.conversation_id')
                                ->where('read_status','1')
                                ->where('user_id',$user_id)
                                ->groupBy('messages.conversation_id')
                                ->get();
        $success['conversations'] = $unread_message_count;
        return response()->json(['success'=>$success]); 
    }
}
