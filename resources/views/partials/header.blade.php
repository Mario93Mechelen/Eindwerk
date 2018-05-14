<div id="header_wrapper">

    <header>

        <nav>
            <ul class="nav_right">

                <li class="nav_chat" id="nav_chat">
                    <a href="#">
                        <img src='{{ asset('img/Chat.png') }}'>
                        <p>chats</p>
                    </a>
                </li>

                <div class="dropdown-menu" id="dropdown-menu-chat" style="display:none">
                    <a class="dropdown-item dropdown-item-chat" href="#">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                            <p class="chat-name">Amber Heard</p>
                            <p class="chat-time">2h ago</p>
                        </div>
                        <p class="chat-last-message-start">How are you doing</p>
                        </div>
                    </a>
                    <a class="dropdown-item dropdown-item-chat" href="#">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                                <p class="chat-name">Amber Heard</p>
                                <p class="chat-time">2h ago</p>
                            </div>
                            <p class="chat-last-message-start">How are you doing</p>
                        </div>
                    </a>
                    <a class="dropdown-item dropdown-item-chat" href="#">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                                <p class="chat-name">Amber Heard</p>
                                <p class="chat-time">2h ago</p>
                            </div>
                            <p class="chat-last-message-start">How are you doing</p>
                        </div>
                    </a>

                    <a class="dropdown-item all-chats-link" href="">go to all chats</a>

                </div>

                <li class="nav_profile" id="nav_profile">
                    <a href="#">
                        <p>{{$myUser->first_name}}</p><div class="profile_pic" style="background-image: url({{url($myUser->avatar)}})"></div>
                    </a>
                </li>

                <div class="dropdown-menu" id="dropdown-menu-profile" style="display:none">
                    <a class="dropdown-item dropdown-item-profile" href="#">my profile</a>
                    <a class="dropdown-item dropdown-item-profile" href="#">settings</a>
                    <a class="dropdown-item dropdown-item-profile" href="#">logout</a>
                </div>

            </ul>

            <div class="nav_left_wrapper">
                <ul class="nav_left">
                    <li class="nav_semestr"><a href="#"><img src='{{ asset('img/Semestr_logo2_gray.png')
                    }}'><p>Semestr</p></a></li>
                    <li class="nav_aroundme"><a href="#">around me</a></li>
                    <li class="nav_crossings"><a href="#">crossings</a></li>
                    <li class="nav_groups"><a href="#">groups</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>