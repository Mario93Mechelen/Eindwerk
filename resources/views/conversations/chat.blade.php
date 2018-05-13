@extends('layouts.master')

@section('content')

    <div id="chat_overview" class="row list-group">

        <!-- item -->
        <div class="item item-list col-xs-12 col-md-6">
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

        <!-- item -->
        <div class="item item-list col-xs-12 col-md-6">
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

        <!-- item -->
        <div class="item item-list col-xs-12 col-md-6">
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

    </div>



@endsection