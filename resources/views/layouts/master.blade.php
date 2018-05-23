<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Semestr</title>
    <link rel="stylesheet" href="/fonts/fontawesome-free-5.0.12/web-fonts-with-css/css/fontawesome-all.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/emoji.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <style>
        #header-wrapper{
            background-image:none !important;
        }
        .online-cirlce{

        }
    </style>
</head>
<body>

@include('partials.header')

<main>
    @yield('content')

    @include('conversations.chat')
</main>

<footer>

</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="/js/semestr.js"></script>
<script src="/js/emoji.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    $(document).ready(function(){
        Pusher.logToConsole = true;

        var pusher = new Pusher('219878673544c0fd8948', {
            cluster: 'eu',
            encrypted: true
        });

        var channel = pusher.subscribe('chat'+'{{$myUser->id}}');
        channel.bind('new-chat', function(data) {
            if($('.chat-wrapper').is(':visible')) {
                if ($('*[data-id="' + data.data.conversation_id + '"]').hasClass('chat-active')) {
                    console.log('chat is open');
                    var newdiv = '<div class="conversation-message-in"><img src="' + data.data.sender.avatar + '" alt=""><p class="message message-in">' + data.data.chat + '</p></div>';
                    $(newdiv).appendTo('.messages_container').hide().fadeIn(1000);
                    $(".messages_container").animate({scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
                    console.log(data);
                } else {
                    console.log('chat is closed');
                    if ($('*[data-id="' + data.data.conversation_id + '"]').length) {
                        $('.active-chat-item-indicator').addClass('hidden');
                        var div = $('*[data-id="' + data.data.conversation_id + '"]').parent().html();
                        var composedDiv = '<div class="item item-list col-xs-12">' + div + '</div>';
                        $('*[data-id="' + data.data.conversation_id + '"]').parent().remove();
                        $('#chat_overview').prepend(composedDiv);
                        $('*[data-id="' + data.data.conversation_id + '"]').find('.active-chat-item-indicator').removeClass('hidden');
                        $('*[data-id="' + data.data.conversation_id + '"]').find('.chat-time').html('just now');
                        $('*[data-id="' + data.data.conversation_id + '"]').find('.chat-last-message-start').html(data.data.chat);
                    } else {
                        $('.active-chat-item-indicator').addClass('hidden');
                        $('#chat_overview').prepend('<div class="item item-list col-xs-12"><a class="item-content chat_to_detail chat-active" href="" data-user="' + data.data.sender.id + '" data-id="' + data.data.conversation_id + '"><div class="active-chat-item-indicator"></div><img class="chat-avatar" src="' + data.data.sender.avatar + '"><div class="online-indicator online"></div><div class="chat-right"><div class="chat-nametime"><p class="chat-name">' + data.data.sender.first_name + ' ' + data.data.sender.last_name + '</p><p class="chat-time">just now</p></div><p class="chat-last-message-start">' + data.data.chat + '</p></div></a></div>');
                        $('.chat_to_detail').on('click', function (e) {
                            e.preventDefault();
                            getChats(data.data.conversation_id);
                        })
                    }
                }
            }else{
                $('.new-message-indicator').removeClass('hidden');
                
            }

        });

        var channel2 = pusher.subscribe('friend_request'+'{{$myUser->id}}');
        channel2.bind('new-request', function(data) {
            if(data.data.request == "sent"){
                console.log(data);
                $('.indicator-friends').removeClass('hidden');
            }
        });
        function getChats(id){
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                }

            });
            $.ajax({
                method:"POST",
                url:"/getConversation",
                data:{
                    'id':id
                }
            }).done(function(response){
                if(response.code==200) {
                    console.log(response);
                    $('.conversation-message-in').remove();
                    $('.conversation-message-out').remove();
                    if(response.conversation.length>0) {
                        for(var i=0;i<response.conversation.length;i++) {
                            var src='';
                            if(response.conversation[i].sender.avatar.includes('http')){
                                src=response.conversation[i].sender.avatar;
                            }else{
                                src='/'+response.conversation[i].sender.avatar;
                            };
                            if (response.myId != response.conversation[i].sender.id) {
                                var newdiv = '<div class="conversation-message-in"><img src="' + src + '" alt=""><p class="message message-in">' + response.conversation[i].text + '</p></div>';
                                $('.messages_container').append(newdiv);
                            } else {
                                var newdiv = '<div class="conversation-message-out"><p class="message message-out">' + response.conversation[i].text + '</p></div>';
                                $('.messages_container').append(newdiv);
                            };
                        }
                    }
                }
            });
        }
    })
</script>
@yield('scripts')

</body>
</html>