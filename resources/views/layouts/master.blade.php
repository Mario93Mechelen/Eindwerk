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
            if($('*[data-id="'+data.data.conversation_id+'"]').hasClass('chat-active')) {
                console.log('chat is open');
                var src = "";
                if (data.data.sender.avatar.includes('http')) {
                    src = response.conversation[i].sender.avatar;
                } else {
                    src = '/' + data.data.sender.avatar;
                }
                ;
                var newdiv = '<div class="conversation-message-in"><img src="' + src + '" alt=""><p class="message message-in">' + data.data.chat + '</p></div>';
                $(newdiv).appendTo('.messages_container').hide().fadeIn(1000);
                $(".messages_container").animate({scrollTop: $('.chats-view').prop("scrollHeight")}, 500);
                console.log(data);
            }else{
                console.log('chat is closed');
                var div = $('*[data-id="'+data.data.conversation_id+'"]').parent().html();
                var composedDiv = '<div class="item item-list col-xs-12">'+div+'</div>';
                $('*[data-id="'+data.data.conversation_id+'"]').parent().remove();
                $('#chat_overview').prepend(composedDiv);
                $('*[data-id="'+data.data.conversation_id+'"]').find('.chat-time').html('just now');
                $('*[data-id="'+data.data.conversation_id+'"]').find('.chat-last-message-start').html(data.data.chat);
            }

        });
    })
</script>
@yield('scripts')

</body>
</html>