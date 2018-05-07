@extends('layouts.master')

@section('content')
    <div class="main">

        <section class="content aroundme">
            <h2 class="content_title">Around me</h2>

            <!-- nu placeholders, later loopen we hier de users uit de omgeving uit en vullen we de juiste zaken in  -->
            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

            <div class="aroundme_item main_item">
                <img class="aroundme_item_image" src="{{url('img/profile_pic_default.jpg')}}">
                <div class="aroundme_item_right aroundme_item_name">Amber Heard</div>
                <div class="aroundme_item_right aroundme_item_detail">
                    <div class="aroundme_item_school">student at NYU</div>
                    <div class="aroundme_item_age">27 years</div>
                    <div class="aroundme_item_country">United Kingdom</div>
                </div>
                <div class="aroundme_item_right aroundme_item_intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed.</div>
            </div>

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
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': "{{csrf_token()}}",

            }

        });
        $.ajax({
            method:"POST",
            url:"{{URL::action('LocationController@getLocation')}}",
            data:{
                'key': 'AIzaSyBvs7EHp5iJ5aaCe-k2DodKcTyzFtbqrdw',
            }
        }).done(function(response){
            if(response.code==200){
                latitude = response.res.location.lat;
                longitude = response.res.location.lng;
                storeLocation(latitude,longitude);
                initMap(latitude,longitude);
            }
        });
        /*function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }
        function showPosition(position) {
            latitude =  position.coords.latitude;
            longitude =  position.coords.longitude;
            console.log(latitude +' '+ longitude);*/
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
                        console.log(response.res.results[0].address_components[2].long_name);
                        $('.location_city').html(response.res.results[0].address_components[2].long_name);
                    }
                });
        }
        //getLocation();
        //http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=en&latlng=51.0350601,4.4531024
        function initMap(latitude,longitude) {
            var pos = {lat:latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: pos
            });
            var marker = new google.maps.Marker({
                position: pos,
                map: map
            });

        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMTFMU3WYZ1vlAuw2BGnuDgdsaIu5cdd0&callback=initMap">
    </script>

    @endsection