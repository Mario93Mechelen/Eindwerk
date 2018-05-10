<div id="header_wrapper">

    <header>

        <nav>
            <ul class="nav_right">
                <li class="nav_chat"><a href="#"><img src='{{ asset('img/Chat.png') }}'><p>chat</p></a></li>
                <li class="nav_profile"><a href="#"><div class="profile_pic" style="background-image: url('{{$myUser->avatar}}');"></div>
                        <p>profile</p></a></li>
            </ul>
            <div class="nav_left_wrapper">
                <ul class="nav_left">
                    <li class="nav_semestr"><a href="#">semestr</a></li>
                    <li class="nav_aroundme"><a href="#">around me</a></li>
                    <li class="nav_crossings"><a href="#">crossings</a></li>
                    <li class="nav_groups"><a href="#">groups</a></li>
                </ul>
            </div>
        </nav>

    </header>
</div>