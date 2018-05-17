
<div class="chat-wrapper">  <!-- default hidden / this div holds overlay for desktop, keeps header space untouched for mobile -->

    <div class="chat-total">  <!-- holds all chat logic -->

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


                <div class="item item-list col-xs-12">
                    <a class="item-content" href="">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                                <p class="chat-name">Amber Heard</p>
                                <p class="chat-time">2h ago</p>
                            </div>
                            <p class="chat-last-message-start">You: Hey, thanks for dropping by the other...</p>
                        </div>
                    </a>
                </div>


                <div class="item item-list col-xs-12">
                    <a class="item-content" href="">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                                <p class="chat-name">Amber Heard</p>
                                <p class="chat-time">2h ago</p>
                            </div>
                            <p class="chat-last-message-start">You: Hey, thanks for dropping by the other...</p>
                        </div>
                    </a>
                </div>


                <div class="item item-list col-xs-12">
                    <a class="item-content" href="">
                        <img class="chat-avatar" src='{{ asset('img/profile_pic_default.jpg') }}'>
                        <div class="chat-right">
                            <div class="chat-nametime">
                                <p class="chat-name">Amber Heard</p>
                                <p class="chat-time">2h ago</p>
                            </div>
                            <p class="chat-last-message-start">You: Hey, thanks for dropping by the other...</p>
                        </div>
                    </a>
                </div>

            </div>  <!-- end of overview active chats -->

            <a href="" id="test_to_detail">to detail</a>
        </div>

        <div class="chat-detail">  <!-- second section on mobile, right section on desktop -->
            <a href="" id="test_to_list">to list</a>

        </div>

    </div>


</div>


<!--

-->



