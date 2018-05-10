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
            width:70% !important;
            margin-left:10%;
            margin-top:50px;
        }
        .chat-left{
            height:50px;
            width:50%;
            background-color:blue;
            color:white;
            margin-left:10%;
            margin-top:25px;
            display:inline-block;
            text-align:center;
            line-height: 50px;
        }

        .chat-right{
            height:50px;
            width:50%;
            background-color:grey;
            color:white;
            margin-left:40%;
            margin-top:25px;
            display:inline-block;
            text-align:center;
            line-height: 50px;
        }
        .chat-center{
            height:50px;
            width:50%;
            background-color:grey;
            color:white;
            margin-left:25%;
            margin-top:25px;
            display:inline-block;
            text-align:center;
            line-height: 50px;
            animation: opacity 0.5s ease-in-out;
        }
    </style>
    <div class="chat-screen">
        <div class="chats-view">
            @if(!$conversation->chats->isEmpty())
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
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('219878673544c0fd8948', {
            cluster: 'eu',
            encrypted: true
        });

        var channel = pusher.subscribe('chat'+'{{$conversation->id}}');
        channel.bind('new-chat', function(data) {
            $('.chat-center').remove();
            if(data.data.sender_id == '{{\Illuminate\Support\Facades\Auth::user()->id}}'){
                var newdiv = '<div class="chat-left"><p>'+data.data.chat+'</p></div>';
                $(newdiv).appendTo('.chats-view').hide().fadeIn(1000);
                $(".chats-view").animate({ scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
            }else{
                var newdiv = '<div class="chat-right"><p>'+data.data.chat+'</p></div>';
                $(newdiv).appendTo('.chats-view').hide().fadeIn(1000);
                $(".chats-view").animate({ scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.chats-view').scrollTop($('.chats-view')[0].scrollHeight);
            var input = "";
            $("#chat-input").emojioneArea({

                pickerPosition: "top",
                tonesStyle: "bullet",
                events: {
                    keyup: function (editor, event) {
                        input = this.getText();
                        if(event.keyCode == 13){
                            input = this.getText();
                            saveChat(input);
                            this.setText("");
                        }
                    },
                    change: function(editor,event){
                        input = this.getText();
                    }
                }
            });

            $('#emoji-face').click(function () {
                $('.emojionearea-button').click()
            });

            $('.send-chat').on('click', function(){
                saveChat(input);
                $('.emojionearea-editor').html('');
            })

            function saveChat(input){
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': "{{csrf_token()}}",

                    }

                });
                $.ajax({
                    method:"POST",
                    url:"{{URL::action('ConversationController@addChatToConversation', $conversation)}}",
                    data:{
                        'message': input,
                        'sender_id': '{{$myUser->id}}',
                        'receiver_id': 3,
                        'id' : '{{$conversation->id}}'
                    }
                }).done(function(response){
                    if(response.code==200) {
                        console.log('message sent');
                    }
                })
            }

        });
    </script>
@endsection