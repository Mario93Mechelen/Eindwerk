<?php

namespace App\Http\Controllers;

use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $myId = Auth::user()->id;
        /*            ;*/
        if(is_null(Conversation::where('user1',$id)->where('user2', $myId)->first())){
            if(is_null(Conversation::where('user1',$myId)->where('user2', $id)->first())){
                $conversation = new Conversation();
                $conversation->user1 = $myId;
                $conversation->user2 = $id;
                $conversation->save();
                $conversation_id = $conversation->id;
            }else{
                $conversation_id = Conversation::where('user1',$myId)->where('user2', $id)->first()->id;
            }

        }else{
            $conversation_id = Conversation::where('user1',$id)->where('user2', $myId)->first()->id;
        }
        return response()->json(['code' => 200, 'conversation_id' => $conversation_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        return view('conversations.chats',compact('conversation'));
    }

    public function addChatToConversation(Request $request)
    {
        $message = $request->message;
        $sender_id = $request->sender_id;
        $receiver_id = $request->receiver_id;
        $conversation_id = $request->id;

        $this->makeEventObject()->trigger('chat'.$conversation_id,'new-chat',['data' => ['chat' => $message, 'sender_id' => $sender_id, 'receiver_id' => $receiver_id]]);

        return response()->json(['code' => 200]);
    }

    private function makeEventObject()
    {
        $options = array(
            'cluster' => 'eu', // Cluster
            'encrypted' => true,
        );

        return new Pusher(
            env('PUSHER_APP_KEY'), // public key
            env('PUSHER_APP_SECRET'), // Secret
            env('PUSHER_APP_ID'), // App_id
            $options
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
