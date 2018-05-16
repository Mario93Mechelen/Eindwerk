@extends('layouts.master')

@section('content')

    <div class="aroundme_page">

        <div class="map-top">

            <div class="map-top-img">
                <div id="map" style="position:absolute !important; height:290px;width:100%;"></div>
            </div>

            <div class="search-bar">

                <div class="searchContainer">
                    <div class="searchBox">
                        <i class="fa fa-search searchIcon"></i>
                        <input class="searchBox_inner" type="search" name="search" placeholder="search for users">
                    </div>

                    <input type="submit" value="" class="searchButton">
                    
                </div>

                <div class="searchButtonOptions hidden">
                    <div class="searchButtonOptionRadius">
                        <h6>radius</h6>
                        <div class="radiusSliderContainer">
                            <input type="range" min="1" max="9" value="9" class="slider radiusSlider" id="radiusSlider">
                        </div>
                        <div id="selectedRadius">100km</div>
                    </div>
                    <div class="searchButtonOptionInterests">
                        <h6>interests</h6>
                        <ul>
                            <li class="interest-item selected">chinese food</li>
                            <li class="interest-item selected">tennis</li>
                            <li class="interest-item">beer</li>
                            <li class="interest-item">foreign languages</li>
                            <li class="interest-item selected">movies</li>
                            <li class="interest-item">dance music</li>
                            <li class="interest-item">video games</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>



        <h2 class="content_title">People around me</h2>

        <div class="crossings-indicator-wrapper">
            <a href="#" class="crossings-indicator">
                <div class="crossing_icon"></div>
                <p>you crossed some new people</p>
            </a>
        </div>




        <!-- grid & list views -->
        <section>

            <div class="container gridlist-container">
                <!-- toggle switch -->
                <div class="gridlist-toggle">
                    <strong>Display</strong>
                    <div class="btn-group">
                        <a href="#" id="list" class="btn btn-default btn-sm gridlist toggle-active"><span
                                    class="glyphicon
                        glyphicon-th-list">
                        </span><p>List</p></a> <a href="#" id="grid" class="btn btn-default btn-sm gridlist"><span
                                    class="glyphicon glyphicon-th"></span><p>Grid</p></a>
                    </div>
                </div>

                <!-- list & grid view  -->
                <div id="aroundme_overview" class="row list-group">

                    <!-- item -->
                    @if(isset($distance))
                    @foreach($distance as $d)
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url($d['user']['avatar'] ? $d['user']['avatar'] : '')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">{{$d['user']['first_name']." ".$d['user']['last_name']}}</h4>
                                <p class="list-item-distance">{{$d['kms']}} km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                     @endforeach
                     @else
                        <p>We couldn't find users nearby, did you share your location with us?</p>
                     @endif

                    <!-- for further layout testing -->

                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="item item-list col-xs-12 col-md-6">
                        <div class="item-content">
                            <img class="list-item-img" src="{{url('img/profile_pic_default.jpg')}}" alt=""/>
                            <div class="caption">
                                <h4 class="list-item-name">Amber Heard</h4>
                                <p class="list-item-distance">2km away</p>
                                <p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    


                </div>
            </div>

        </section>

    </div>

    @endsection

@section('scripts')



    <script>
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
        $(document).ready(function() {
            $("#radiusSlider").change(function() {
                var rate  = $(this).val();
                var distance = 0;
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
                            $('.item').each(function(){
                                $(this).remove();
                            });
                            for(i=0;i<response.distance.length;i++){
                                if($('#list').hasClass('toggle-active')){
                                    $('#aroundme_overview').append('<div class="item item-list col-xs-12 col-md-6"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p></div></div></div>')
                                    console.log(response.distance[i]['user'])
                                }else{
                                    $('#aroundme_overview').append('<div class="item item-grid col-xs-6 col-md-3"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p></div></div></div>')

                                }
                            }
                        }
                    });
                }

            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmUI9YUBTI-gDW2mmBUpSx9DR3PiaSfns&callback=initMap"
            async defer></script>

    @endsection