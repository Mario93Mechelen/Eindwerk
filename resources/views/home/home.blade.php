@extends('layouts.master')

@section('content')

    <div class="aroundme_page">

    @include('partials.topmap_and_search')

        <h2 class="content_title">People around me</h2>

        <div class="crossings-indicator-wrapper">
            @if(!$myUser->myCrossings()->where('seen',0)->get()->isEmpty())
                <a href="{{URL::action('ProfileController@index')}}" class="crossings-indicator">
                    <div class="crossing_icon"></div>
                    <p>you crossed some new people</p>
                </a>
            @else
                <a href="{{URL::action('ProfileController@index')}}" class="crossings-indicator">
                    <div class="crossing_icon"></div>
                    <p>no new crossings yet</p>
                </a>
            @endif
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
                        @if(!$d['user']->isBlocked($myUser->id) && !$d['user']->blockedBy($myUser->id))
                            <div class="item item-home item-list col-xs-12 col-md-6">
                                <a href="{{URL::action('ProfileController@show',$d['user'])}}">
                                <div class="item-content">
                                    <img class="list-item-img" src="{{url($d['user']['avatar'] ? $d['user']['avatar'] : '')}}" alt=""/>
                                    <div class="caption">
                                        <h4 class="list-item-name list-item-name-home">{{$d['user']['first_name']." ".$d['user']['last_name']}}</h4>
                                        <p class="list-item-distance">{{$d['kms']}} {{($myUser->setting->distance == "km") ? 'km' : 'miles'}} away</p>
                                        <p class="list-item-intro">{{$d['user']['intro']}}</p>
                                    </div>
                                </div>
                                </a>
                            </div>

                        @endif
                     @endforeach
                     @else
                        <p class="aroundme_no_users">We couldn't find users nearby, did you share your location with
                            us?</p>
                     @endif

                    <div class="item item-home item-list col-xs-12 col-md-6">
                        <a href="">
                            <div class="item-content">
                                <img class="list-item-img" src="/img/profile_pic_default.jpg" alt=""/>
                                <div class="caption">
                                    <h4 class="list-item-name list-item-name-home">Amber Heard</h4>
                                    <p class="list-item-distance">2km away</p>
                                    <p class="list-item-intro">introtekst komt hier</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </section>

    </div>

    @endsection

@section('scripts')


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
               $('.list-item-name-home').each(function () {
                   console.log($(this).html());
                   if (!$(this).html().toLowerCase().includes(name)) {
                       $(this).parent().parent().parent().hide();
                   }
               });
           }else if(e.keyCode == 8){
               console.log('backspace pressed');
                $('.list-item-name-home').each(function () {
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
                distance = 0;
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
                if('{{$myUser->setting->distance == 'km'}}') {
                    $('#selectedRadius').html(distance + 'km');
                }else{
                    $('#selectedRadius').html(distance/1.6 + 'miles')
                }
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
                            $('.item-home').each(function(){
                                $(this).remove();
                            });
                            for(i=0;i<response.distance.length;i++){
                                if($('#list').hasClass('toggle-active')){
                                    $('#aroundme_overview').append('<div class="item item-home item-list col-xs-12 col-md-6"><a href="/users/'+response.distance[i]['user']['id']+'"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name list-item-name-home">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">'+((response.distance[i]['user']['intro'] == null) ?  '' : response.distance[i]['user']['intro'] )+'</p></div></div></a></div>')
                                    console.log(response.distance[i]['user'])
                                }else{
                                    $('#aroundme_overview').append('<div class="item item-home item-grid col-xs-6 col-md-3"><a href="/users/'+response.distance[i]['user']['id']+'"><div class="item-content"><img class="list-item-img" src="' + response.distance[i]['user']['avatar'] + '" alt=""/><div class="caption"><h4 class="list-item-name list-item-name-home">' + response.distance[i]['user']['first_name'] + ' ' + response.distance[i]['user']['last_name'] + '</h4><p class="list-item-distance">' + response.distance[i]['kms'] + ' km away</p><p class="list-item-intro">'+((response.distance[i]['user']['intro'] == null) ?  '' : response.distance[i]['user']['intro'] )+'</p></div></div></a></div>')

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