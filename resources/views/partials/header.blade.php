<div id="header_wrapper">

    <header>

        <nav>
            <ul class="nav_right">

                <li class="nav_chat" id="nav_chat">
                    <a href="#">
                        <img src='{{ asset('img/Chat.png') }}'>
                        <div class="new-message-indicator {{App\Chat::where('receiver_id',$myUser->id)->where('seen',0)->first() ? null : 'hidden'}}"></div>
                        <p>chats</p>
                    </a>
                </li>

                <li class="nav_profile" id="nav_profile">
                    <a href="#">
                        <p>{{$myUser->first_name}}</p><div class="profile_pic" style="background-image: url({{$myUser->avatar}})"></div>

                        <div class="indicator-friends {{App\Friend::where('friend_receiver',$myUser->id)->where('request_type','pending')->first() ? null : 'hidden'}}" ></div>

                    </a>
                </li>

                <div class="dropdown-menu" id="dropdown-menu-profile" style="display:none">
                    <a class="dropdown-item dropdown-item-profile" href="{{URL::action('ProfileController@show',$myUser)}}">my profile</a>
                    <a class="dropdown-item dropdown-item-profile" href="{{URL::action('FriendController@index')}}">friends<div class="indicator-friends2 {{App\Friend::where('friend_receiver',$myUser->id)->where('request_type','pending')->first() ? null : 'hidden'}}" ></div></a>
                    <a class="dropdown-item dropdown-item-profile" href="{{URL::action('ProfileController@settings')}}">settings</a>
                    <a class="dropdown-item dropdown-item-profile" href="{{URL::action('Auth\LoginController@logout')}}">logout</a>
                </div>

            </ul>

            <div class="nav_left_wrapper">
                <ul class="nav_left">
                    <li class="nav_semestr"><a href="{{URL::action('HomeController@index')}}"><img src='{{ asset('img/Semestr_logo2_gray.png')
                    }}'><p>Semestr</p></a></li>
                    <li class="nav_aroundme"><a href="{{URL::action('HomeController@index')}}" class="nav_aroundme_link">around me</a></li>
                    <li class="nav_crossings"><a href="{{URL::action('ProfileController@index')}}" class="nav_crossings_link">crossings</a></li>
                    <li class="nav_groups"><a href="{{URL::action('ProfileController@school')}}" class="nav_groups_link">school</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>
