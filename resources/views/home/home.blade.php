@extends('layouts.master')

@section('content')
    <style>
        #header-wrapper{
            background-image:none !important;
        }
    </style>
    <div class="main">

        <section class="content aroundme">
            <h2 class="content_title">Around me</h2>

            <!-- nu placeholders, later loopen we hier de users uit de omgeving uit en vullen we de juiste zaken in  -->
            @if(isset($distance))
                @foreach($distance as $d)
                    @php
                        $crossing = \App\User::where('id',$d['id'])->first();
                    @endphp
                <div class="aroundme_item main_item" data-id="{{$crossing->id}}">
                    <img class="aroundme_item_image" src="{{$crossing->avatar}}">
                    <div class="aroundme_item_right aroundme_item_name">{{$crossing->first_name." ".$crossing->last_name}}</div>
                    <div class="aroundme_item_right aroundme_item_detail">
                        <div class="aroundme_item_school">student at NYU</div>
                        <div class="aroundme_item_age">{{$crossing->birthday ? \Carbon\Carbon::parse($crossing->birthday)->diffInYears(\Carbon\Carbon::now())." years" : "unknown age"}}</div>
                        <div class="aroundme_item_country">{{$crossing->myLocation->city ? $crossing->myLocation->city : "no current location"}}</div>
                    </div>
                    <p>{{$d['kms']}} kms away from you</p>
                    <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>

                </div>
                @endforeach
            @else
            @endif

        </section>

        <section class="sidebar chat">
            <h3 class="sidebar_title">Chat</h3>

            <!-- nu placeholders, later loopen we hier chat items uit en vullen we de juiste zaken in uit de database -->
            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="chat_item sidebar_item">
                <img class="chat_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="chat_item_name">Amber Heard</div>
                <div class="chat_item_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>
        </section>

    </div>

    @endsection

@section('scripts')
    <script>
        var longitude;
        var latitude;

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            console.log(latitude+":"+longitude)
            storeLocation(latitude, longitude);
        }

        function positionToMap(position) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                zoom: 15,
                zoomControl:false,
                scaleControl:false,
                mapTypeControl:false,
                streetViewControl:false,
                fullscreenControl:false

            });
        }

        function initMap(){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(positionToMap);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
        }

        getLocation();
        window.setInterval(getLocation, 300000);

        function storeLocation(latitude,longitude){
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('LocationController@store')}}",
                data:{
                    'longitude': longitude,
                    'latitude': latitude,
                }
            }).done(function(response){
                if(response.code==200) {
                    if(response.res.results[0]) {
                        console.log(response.res.results[0].address_components[2].long_name);
                        $('.location_city').html(response.res.results[0].address_components[2].long_name);
                    }else{
                        $('.location_city').html("seems like we couldn't find your location");
                    }
                }
            });
        }
    </script>
    <script>
        $('.aroundme_item').on('click', function(){
            var id = $(this).data('id');
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': "{{csrf_token()}}",

                }

            });
            $.ajax({
                method:"POST",
                url:"{{URL::action('ConversationController@store')}}",
                data:{
                    'id': id,
                }
            }).done(function(response){
                if(response.code==200) {
                    console.log('conversation '+response.conversation_id+' created');
                    window.location.replace('/conversation/'+response.conversation_id);
                }
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>

    @endsection