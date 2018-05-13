@extends('layouts.master')

@section('content')

    <div id="chat_overview" class="row list-group">

        <!-- item -->
        <div class="item item-list col-xs-12 col-md-6">
            <div class="item-content">
                <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                <div class="caption">
                    <h4 class="list-item-name">Amber Heard</h4>
                    <p class="list-item-time">2h ago</p>
                    <p class="list-item-message">You: Thanks for dropping by the other...</p>
                </div>
            </div>
        </div>

    </div>


@endsection