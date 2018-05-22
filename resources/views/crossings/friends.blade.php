@extends('layouts.master')

@section('content')

    <div class="friends_page">

        @include('partials.topmap_and_search')

        <div class="friends_page_content">

            <div class="friends-request-toggle">
                <ul>
                    <li class="see-friends active">friends</li>
                    <li class="see-requests">requests</li>
                </ul>
            </div>

            <div class="friends_container row list-group">
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-since">friends since 14 January 2016</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-since">friends since 14 January 2016</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-since">friends since 14 January 2016</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="requests_container row list-group">
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <div class="friend-request-buttons">
                                    <ul>
                                        <li class="friend-request-accept active">accept</li>
                                        <li class="friend-request-decline">decline</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <div class="friend-request-buttons">
                                    <ul>
                                        <li class="friend-request-accept active">accept</li>
                                        <li class="friend-request-decline">decline</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="item item-list col-xs-12 col-md-6">
                    <a href="">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <div class="friend-request-buttons">
                                    <ul>
                                        <li class="friend-request-accept active">accept</li>
                                        <li class="friend-request-decline">decline</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>



        </div>

    </div>

@endsection

@section('scripts')

    <script>
        $('.searchBox_inner').on('keyup', function(e){
            var name = $(this).val().toLowerCase();
            console.log(name);
            if(name != "" && e.keyCode!=8) {
                console.log('other keys are pressed');
                $('.list-item-name').each(function () {
                    console.log($(this).html());
                    if (!$(this).html().toLowerCase().includes(name)) {
                        $(this).parent().parent().parent().hide();
                    }
                });
            }else if(e.keyCode == 8){
                console.log('backspace pressed');
                $('.list-item-name').each(function () {
                    console.log($(this).html());
                    if ($(this).html().toLowerCase().includes(name)) {
                        $(this).parent().parent().parent().show();
                    }
                });
            }
        });
    </script>
    <script>
        <!-- show selected radius filter -->
        var slidingTimer;                //timer identifier
        var doneSlidingInterval = 1000;
        var distance = 5;
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

            var cityCircle = new google.maps.Circle({
                strokeColor: '#0048d9',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#0048d9',
                fillOpacity: 0.35,
                map: map,
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                radius: distance*1000
            });
        }

        function initMap(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(positionToMap);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        $(document).ready(function() {

            $("#radiusSlider").change(function() {
                var rate  = $(this).val();
                if(rate == 1){
                    distance = 0.1;
                }else if(rate == 2){
                    distance = 0.25;
                }else if(rate == 3){
                    distance = 0.5;
                }else if(rate == 4){
                    distance = 1;
                }else if(rate == 5){
                    distance = 2;
                }else if(rate == 6){
                    distance = 3;
                }else if(rate == 7){
                    distance = 4;
                }else if(rate == 8){
                    distance = 5;
                }else if (rate == 9){
                    distance = 100;
                }

                $('#selectedRadius').html(distance+'km');
                console.log(distance);
                clearTimeout(slidingTimer);
                slidingTimer = setTimeout(doneSliding(distance), doneSlidingInterval);

                function doneSliding(distance){
                    initMap();
                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': "{{csrf_token()}}",

                        }

                    });
                    $.ajax({
                        method:"POST",
                        url:"{{URL::action('HomeController@filterDistance')}}",
                        data:{
                            'distance': distance,
                        }
                    }).done(function(response){
                        if(response.code==200) {

                        }
                    });
                }

            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>
@endsection