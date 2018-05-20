
<div class="chat-wrapper hide-chat">  <!-- default hidden / this div holds overlay for desktop, keeps header space untouched for mobile -->

    <div class="chat-total">  <!-- holds all chat logic -->

        <div class="chat-total-title">
            <h2 class="content_title">Chats</h2>
        </div>

        <div class="chat-list">  <!-- first section on mobile, left section on desktop -->

            <div class="search-bar">
                <div class="searchContainer">
                    <div class="searchBox">
                        <i class="fa fa-search searchIcon"></i>
                        <input class="searchBox_inner" type="search" name="search" placeholder="search for friends">
                    </div>
                </div>
            </div>

            <!-- overview active chats -->
            <div id="chat_overview" class="row list-group">
                @if(!$myUser->conversation->isEmpty())
                    @php
                        $chatsArr = [];
                        $i=0;
                        foreach($myUser->conversation as $conversation){
                            $chat = $conversation->chats()->orderBy('created_at', 'desc')->first();
                            if(!is_null($chat)){
                                $chatsArr[$i] = $chat;
                                $i++;
                            }
                         }
                         if($chatsArr){
                        foreach($chatsArr as $key => $row){
                            $dateArr[$key] = $row['created_at'];
                        }
                        array_multisort($dateArr, SORT_DESC,$chatsArr);
                        $j=0;
                        foreach($chatsArr as $chat){
                            $conversations[$j] = $chat->conversation;
                            $j++;
                        }
                        }else{
                            $conversations = null;
                        }
                    @endphp
                    @if(!is_null($conversations))
                        @foreach($conversations as $key => $conversation)
                            @php
                                $user = $conversation->users()->where('user_id','!=',$myUser->id)->first();
                                if(!($conversation->chats)->isEmpty()){
                                    $lastChat = $conversation->chats()->orderBy('created_at', 'desc')->first();
                                    if($lastChat->sender_id == $myUser->id){
                                        $text = 'You: '.$lastChat->body;
                                    }else{
                                        $text = $lastChat->body;
                                    }
                                }
                            @endphp
                            <div class="item item-list col-xs-12">
                                <a class="item-content chat_to_detail {{($key == 0) ? 'chat-active' : null }}" href="" data-user="{{$user->id}}" data-id="{{$conversation->id}}">
                                    <div class="active-chat-item-indicator {{($key == 0) ? null : 'hidden' }}"></div>
                                    <img class="chat-avatar" src='{{ asset($user->avatar) }}'>
                                    <div class="online-indicator {{$user->isOnline() ? 'online' : 'offline'}}"></div>
                                    <div class="chat-right">
                                        <div class="chat-nametime">
                                            <p class="chat-name">{{$user->first_name." ".$user->last_name}}</p>
                                            <p class="chat-time">{{$lastChat->calculateTimeElapsed()}}</p>
                                        </div>
                                        <p class="chat-last-message-start">{{ substr($text,0,47).'...'  }}</p>
                                    </div>
                                </a>
                            </div>

                        @endforeach
                    @endif
                @else
                    <div class="item item-list col-xs-12">
                        <a class="item-content chat_to_detail">
                            <div class="active-chat-item-indicator hidden"></div>
                            <img class="chat-avatar" src='{{ asset('/img/Semestr_logo2_gray.png') }}'>
                            <div class="chat-right">
                                <div class="chat-nametime">
                                    <p class="chat-name">Semestr Team</p>
                                    <p class="chat-time">just now</p>
                                </div>
                                <p class="chat-last-message-start">Hello there, seems like your new here, oh a spelling mistake just for you</p>
                            </div>
                        </a>
                    </div>
                @endif


            </div>  <!-- end of overview active chats -->

            <!--
            <a href="" class="chat_to_detail">to detail</a>
            -->
        </div>

        <div class="chat-detail">  <!-- second section on mobile, right section on desktop -->


            <div class="messages_container">

                <a href="" class="chat_to_list">
                    <img src="{{url('img/message_exit.png')}}">
                    <p>to list</p>
                </a>


                <div class="conversation-datetime">
                    <p>Today, 12:48 PM</p>
                </div>

                <div class="conversation-message-in">
                    <img src="{{url('/img/Semestr_logo2_gray.png')}}" alt="">
                    <p class="message message-in">Hey, it seems like you didn't make friends yet? Don't worry, we got you covered here at Semestr. There's plenty of fish in the see, ahum, we mean students in the library off course ;)
                    </p>
                </div>
            </div>

            <form class="new_message_form">
                <textarea class="new_message" id="chat-input" rows="4" placeholder="message"></textarea>
                <button type="submit" class="send_message"></button>
            </form>


        </div>

    </div>


</div>





