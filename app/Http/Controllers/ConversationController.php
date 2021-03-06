<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Conversation;
use App\User;
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
        return view('conversations.chat', compact('user'));
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
        $myConvIDs = Auth::user()->conversation()->pluck('conversation_id')->toArray();
        $userConvIDs = User::find($id)->conversation()->pluck('conversation_id')->toArray();
        //check if I have conversations
        if($myConvIDs){
            //check if the user I clicked has conversations
            if($userConvIDs) {
                //check if we have a common conversation
                (array)$same_ids = array_intersect($myConvIDs, $userConvIDs);
                if($same_ids){
                    //if we have a common conversation, this is our id
                    $reindexed = array_values($same_ids);
                    $conversation_id = $reindexed;
                    $exists = 'yes';
                }else{
                    //we both have conversations but not a common one
                    $conversation = new Conversation();
                    $conversation->save();
                    $conversation->users()->attach($id);
                    $conversation->users()->attach($myId);
                    $conversation_id = $conversation->id;
                    $exists = 'no';
                }
            }else{
                //I have conversations but the user I clicked doesn't
                $conversation = new Conversation();
                $conversation->save();
                $conversation->users()->attach($id);
                $conversation->users()->attach($myId);
                $conversation_id = $conversation->id;
                    $exists = 'no';
            }
        }else{
            //We both don't have conversations
            $conversation = new Conversation();
            $conversation->save();
            $conversation->users()->attach($id);
            $conversation->users()->attach($myId);
            $conversation_id = $conversation->id;
                    $exists = 'no';
        }
        $receiver = User::find($id);
        return response()->json(['code' => 200, 'conversation_id' => $conversation_id,'existence' => $exists, 'receiver' => $receiver]);
    }

    public function getConversation(Request $request)
    {
        $conversation = Conversation::find($request->id)->chats;
        $message = [];
        $i=0;
        if(!$conversation->isEmpty()) {
            foreach ($conversation as $chat) {
                $message[$i] = ['text' => $chat->body, 'sender' => User::find($chat->sender_id)->toArray(), 'receiver' => User::find($chat->receiver_id)->toArray()];
                $i++;
            }
        }
        return response()->json(['code' => 200, 'conversation' => $message, 'myId' => Auth::user()->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        $users = $conversation->users;
        if($users->contains(Auth::user())) {
            return view('conversations.chats', compact('conversation'));
        }else{
            return redirect('/');
        }
    }

    public function updateSeenStatus(Request $request)
    {
        $chats = Chat::where('receiver_id',Auth::user()->id)->where('conversation_id',$request->convid)->where('seen',0)->get();
        foreach($chats as $chat){
            $chat->seen  = 1;
            $chat->save();
        }
        return response()->json(['code'=>200]);
    }

    public function addChatToConversation(Request $request)
    {
        $message = $request->message;
        $receiver_id = $request->receiver_id;
        $conversation_id = $request->id;

        $chat = new Chat();
        $chat->body = $message;
        $chat->conversation_id = $conversation_id;
        $chat->receiver_id = $receiver_id;
        $chat->sender_id = Auth::user()->id;
        $chat->save();

        $seenChats = Chat::where('receiver_id',Auth::user()->id)->where('conversation_id',$conversation_id)->where('seen',0)->get();
        foreach($seenChats as $s){
            $s->seen = 1;
            $s->save();
        };

        $this->makeEventObject()->trigger('chat'.$receiver_id,'new-chat',['data' => ['chat' => $message, 'sender' => Auth::user(), 'conversation_id' => $conversation_id]]);

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
