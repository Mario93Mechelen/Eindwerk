@extends('layouts.master')

@section('content')
    <style>
        .chat-screen{
            width:100%;
            height:800px;
            background-color:whitesmoke;
        }
        .chats-view{
            width:80%;
            height:100%;
            margin:auto;
            overflow-y:scroll;
            background-color:white;
        }
        #chat-input{
            width:70%;
            margin-left:10%;
            margin-top:50px;
        }
    </style>
    <div class="chat-screen">
        <div class="chats-view">
            @if($conversation->chats)
            @foreach($conversation->chats as $chat)
                @if($chat->sender_id == $myUser->id)
                    <div class="chat-left">
                        <p>{{$chat->body}}</p>
                    </div>
                @else
                    <div class="chat-right">
                        <p>{{$chat->body}}</p>
                    </div>
                @endif
            @endforeach
            @else
                <div class="chat-center">
                    <p>Seems like you guys didn't talk so far</p>
                </div>
            @endif
        </div>
        <div class="chats-input">
            <textarea name="chat" id="chat-input" cols="30" rows="10"></textarea>
            <button class="send-chat">Verzenden</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.send-chat').on('click', function(){
           var text = $('#chat-input').val();
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('ConversationController@addChatToConversation', $conversation)}}",
                data:{
                    'message': text,
                    'sender_id': '{{$myUser->id}}',
                    'receiver_id': 3,
                    'id' : '{{$conversation->id}}'
                }
            }).done(function(response){
                if(response.code==200) {
                    console.log('message sent');
                }
            });
        });
    </script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('219878673544c0fd8948', {
            cluster: 'eu',
            encrypted: true
        });

        var channel = pusher.subscribe('chat'+'{{$conversation->id}}');
        channel.bind('new-chat', function(data) {
            alert(data.data.chat);
        });
    </script>
@endsection